<?php

namespace App\Console\Commands;

use App\Models\Item;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportSkins extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:skins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa os dados do arquivo skins.js para a tabela items';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = storage_path('skins.json');

        $content = file_get_contents($path);
        $items = json_decode($content, true);

        if (!$items) {
            $this->error("Erro ao processar JSON");
            return 1;
        }

        foreach ($items as $item) {
            $category = $this->detectCategory($item);
            $imagePath = $this->generateImagePath($item, $category);

            $item = Item::create([
                'name' => $item['name'],
                'rarity' => $this->rarityLabel($item['rarity'] ?? 0),
                'season' => $item['seas'] ?? 1,
                'category' => $category,
                'tag' => $item['limT'] ?? null,
                'author' => is_numeric($item['creator'] ?? null) ? $item['creator'] : null,
                'image_path' => $imagePath,
            ]);

            Sale::create([
                'user_id' => 1,
                'item_id' => $item->id,
                'price' => 10,
            ]);
        }

        $this->info("Importação concluída com sucesso.");
        return 0;
    }

    private function rarityLabel($index)
    {
        return [
            'Uncommon',
            'Rare',
            'Epic',
            'Legendary',
            'Relic',
            'Contraband',
            'Unobtainable'
        ][$index] ?? 'Uncommon';
    }

    private function detectCategory(array $item): string
    {
        $weaponCategories = [
            1 => 'Sniper Rifle',
            2 => 'Assault Rifle',
            3 => 'Pistol',
            4 => 'Submachine Gun',
            5 => 'Revolver',
            6 => 'Shotgun',
            7 => 'Machine Gun',
            8 => 'Semi Auto',
            9 => 'Rocket Launcher',
            10 => 'Akimbo Uzi',
            11 => 'Desert Eagle',
            12 => 'Alien Blaster',
            14 => 'Crossbow',
            15 => 'Famas',
            16 => 'Sawed OFF',
            17 => 'Auto Pistol',
            19 => 'Blaster',
            22 => 'Tehchy',
            23 => 'Noob Tube',
            25 => 'Zapper',
            28 => 'Akimbo Pistol'
        ];

        if (isset($item['weapon']) && isset($weaponCategories[$item['weapon']])) {
            return $weaponCategories[$item['weapon']];
        }

        if (isset($item['type'])) {
            return match ($item['type']) {
                0 => 'Melee',
                1 => $item['keyW'] ?? 'Hats',
                2 => 'Back',
                3 => 'Body',
                4 => 'Sprays',
                5 => 'Dyes',
                6 => 'Waist',
                7 => 'Faces',
                8 => 'Shoes',
                9 => 'Pets',
                10 => 'Collectibles',
                11 => 'Wrist',
                12 => 'Charms',
                13 => 'Tickets',
                14 => 'Head',
                15 => 'Playercards',
                default => 'Unknown',
            };
        }

        return 'Unknown';
    }

    private function generateImagePath(array $item, string $category): ?string
    {
        $id = $item['id'] ?? null;
        $weapon = $item['weapon'] ?? null;
        $type = $item['type'] ?? null;
        $pat = $item['pat'] ?? null;
        $mid = $item['mid'] ?? null;
        $midT = $item['midT'] ?? null;
        $tex = $item['tex'] ?? null;
        $keyW = $item['keyW'] ?? null;

        if ($type === 3) {
            $category = 'Melee';
        }

        if ($type === 1 && in_array($keyW, ['Hat', 'Head'])) {
            $category = $keyW;
        }

        $folder = $this->cosmeticTypeToFolder($category, $keyW);

        // 1. Skins com 'pat'
        if ($pat !== null) {
            $urls = match (true) {
                $category === 'Melee' => ["https://assets.krunker.io/textures/previews/melee/melee_{$id}_c{$pat}.png"],
                $folder > 0 => ["https://assets.krunker.io/textures/previews/cosmetics/{$folder}_c{$pat}.png"],
                default => ["https://assets.krunker.io/textures/previews/weapons/weapon_{$weapon}_c{$pat}.png"],
            };
            foreach ($urls as $url) {
                if ($this->urlExists($url)) return $url;
            }
        }

        // 2. Regra especial: weapon com mid === 0 e midT → usar weapon_{weapon}_m0_{midT}.png
        if ($mid === 0 && $midT !== null && in_array($weapon, [6, 8, 10])) {
            $url = "https://assets.krunker.io/textures/previews/weapons/weapon_{$weapon}_m0_{$midT}.png";
            if ($this->urlExists($url)) return $url;
        }

        // 2.1. Regra especial: Pistolas com modelos customizados (midT e mid definidos)
        if ($weapon === 3 && $mid !== null && $midT !== null) {
            $url = "https://assets.krunker.io/textures/previews/weapons/weapon_3_m{$mid}_{$midT}.png";
            if ($this->urlExists($url)) return $url;
        }

        // 3. Skins com 'midT'
        if ($midT !== null && $weapon !== null && $id !== null) {
            $url = "https://assets.krunker.io/textures/previews/weapons/weapon_{$weapon}_m{$midT}_{$id}.png";
            if ($this->urlExists($url)) return $url;
        }

        // 4. Skins com 'mid'
        if ($mid !== null) {
            $urls = match (true) {
                $category === 'Melee' => ["https://assets.krunker.io/textures/previews/melee/melee_m{$mid}.png"],
                $folder > 0 => ["https://assets.krunker.io/textures/previews/cosmetics/{$folder}_m{$mid}.png"],
                $weapon !== null => ["https://assets.krunker.io/textures/previews/weapons/weapon_{$weapon}_m{$mid}.png"],
                default => []
            };
            foreach ($urls as $url) {
                if ($this->urlExists($url)) return $url;
            }

            // 4.5. Skins com 'mid' + id
            if ($weapon !== null && $id !== null) {
                $url = "https://assets.krunker.io/textures/previews/weapons/weapon_{$weapon}_m{$mid}_{$id}.png";
                if ($this->urlExists($url)) return $url;
            }
        }

        // 5. Skins com 'tex'
        if ($tex !== null) {
            $urls = match (true) {
                $category === 'Melee' => ["https://assets.krunker.io/textures/previews/melee/melee_{$id}_{$tex}.png"],
                $folder > 0 => ["https://assets.krunker.io/textures/previews/cosmetics/{$folder}_{$id}_{$tex}.png"],
                $weapon !== null => ["https://assets.krunker.io/textures/previews/weapons/weapon_{$weapon}_{$tex}.png"],
                default => [],
            };
            foreach ($urls as $url) {
                if ($this->urlExists($url)) return $url;
            }
        }

        // 6. URLs padrão por categoria
        $urls = match ($category) {
            'Melee' => ["https://assets.krunker.io/textures/previews/melee/melee_{$id}.png"],
            'Sprays' => ["https://assets.krunker.io/textures/sprays/{$id}.png"],
            'Playercards' => ["https://assets.krunker.io/textures/playercards/card_{$id}.webp"],
            'Hats', 'Head' => ["https://assets.krunker.io/textures/previews/cosmetics/1_{$id}.png"],
            default => $weapon !== null
                ? ["https://assets.krunker.io/textures/previews/weapons/weapon_{$weapon}_{$id}.png"]
                : ($folder > 0 ? ["https://assets.krunker.io/textures/previews/cosmetics/{$folder}_{$id}.png"] : []),
        };

        foreach ($urls as $url) {
            if ($this->urlExists($url)) return $url;
        }

        return null;
    }

    private function cosmeticTypeToFolder(string $type, ?string $keyW = null): int
    {
        return [
            'Hat' => 1,
            'Head' => 1,
            'Back' => 2,
            'Body' => 3,
            'Dyes' => 5,
            'Waist' => 6,
            'Faces' => 7,
            'Shoes' => 8,
            'Pets' => 9,
            'Collectibles' => 10,
            'Wrist' => 11,
            'Charms' => 12,
            'Tickets' => 13,
        ][$type] ?? (
            $keyW === 'Hat' ? 1 : 0
        );
    }

    private function urlExists(string $url): bool
    {
        try {
            return Http::head($url)->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}
