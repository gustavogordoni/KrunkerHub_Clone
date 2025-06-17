<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imagePath = $this->getValidImageUrl();

        return [
            'name' => fake()->words(2, true),
            'rarity' => fake()->randomElement([
                'Unobtainable', // rarity: 6
                'Contraband', // rarity: 5
                'Relic', // rarity: 4
                'Legendary', // rarity: 3
                'Epic', // rarity: 2
                'Rare', // rarity: 1
                'Uncommon' // rarity: 0
            ]),
            'season' => fake()->numberBetween(1, 8),
            'category' => fake()->randomElement([
                'Sniper Rifle', // weapons/1_x.png
                'Assault Rifle', // weapons/2_x.png
                'Pistol', // weapons/3_x.png
                'Submachine Gun', // weapons/4_x.png
                'Revolver', // weapons/5_x.png
                'Shotgun', // weapons/6_x.png
                'Machine Gun', // weapons/7_x.png
                'Semi Auto', // weapons/8_x.png
                'Rocket Launcher', // weapons/9_x.png
                'Akimbo Uzi', // weapons/10_x.png
                'Desert Eagle', // weapons/11_x.png
                'Alien Blaster', // weapons/12_x.png
                'Crossbow', // weapons/14_x.png
                'Famas', // weapons/15_x.png
                'Sawed OFF', // weapons/16_x.png
                'Auto Pistol', // weapons/17_x.png
                'Blaster', // weapons/19_x.png
                'Grappler', // weapons/_x.png
                'Tehchy', // weapons/22_x.png
                'Noob Tube', // weapons/23_x.png
                'Zapper', // weapons/25_x.png
                'Akimbo Pistol', // weapons/28_x.png
                'Charge Rifle', // weapons/19_x.png
                'Compressor',
                'Hats', // cosmetics/1_x.png
                'Back', // cosmetics/2_x.png
                'Body',
                'Melee', // melee/melee_x.png
                'Sprays', // sprays/459.png (sem "previews/" antes)
                'Dyes', // cosmetics/5_x.png
                'Waist', // cosmetics/6_x.png
                'Faces', // cosmetics/7_x.png
                'Shoes', // cosmetics/8_x.png
                'Pets', // cosmetics/9_x.png
                'Collectibles', // cosmetics/10_x.png
                'Wrist', // cosmetics/11_x.png
                'Charms', // cosmetics/12_x.png
                'Tickets', // cosmetics/13_0_x.png
                'Head',
                'Playercards' /// playercards/card_x.webp (sem "previews/" antes)
            ]),
            'tag' => fake()->optional()->randomElement(['Vaulted', 'Twitch', 'Raid', '???', 'Kanji', 'Subzero', 'Christmas']),
            'author' => fake()->numberBetween(1, 10),
            'image_path' => $imagePath,
        ];
    }

    private function getValidImageUrl(): ?string
    {
        $defaultUrl = 'https://assets.krunker.io/textures/previews/weapons/weapon_1_1.png';
        // https://assets.krunker.io/textures/previews/cosmetics/6_79.png
        // https://assets.krunker.io/textures/previews/melee/melee_115.png
        // https://assets.krunker.io/textures/previews/cosmetics/13_0_8.png
        // https://assets.krunker.io/textures/sprays/459.png
        // https://assets.krunker.io/textures/playercards/card_9.webp

        try {
            $check = Http::head($defaultUrl);

            if (!$check->successful()) {
                throw new \Exception("Não foi possível acessar a imagem padrão dos assets do Krunker.");
            }
                        
            $maxTries = 10;

            for ($i = 0; $i < $maxTries; $i++) {
                $class = rand(1, 20);
                $skin = rand(1, 100);
                $url = "https://assets.krunker.io/textures/previews/weapons/weapon_{$class}_{$skin}.png";

                try {
                    $response = Http::head($url);
                    if ($response->successful()) {
                        return $url;
                    }
                } catch (\Exception $e) {
                    
                }
            }
        } catch (\Exception $e) {
            throw new \Exception("Erro ao tentar acessar os assets do Krunker: " . $e->getMessage());
        }

        return null;
    }
}
