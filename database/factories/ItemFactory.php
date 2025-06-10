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
                'Unobtainable',
                'Contraband',
                'Relic',
                'Legendary',
                'Epic',
                'Rare',
                'Uncommon'
            ]),
            'season' => fake()->numberBetween(1, 8),
            'category' => fake()->randomElement([
                'Sniper Rifle',
                'Assault Rifle',
                'Pistol',
                'Submachine Gun',
                'Revolver',
                'Shotgun',
                'Machine Gun',
                'Semi Auto',
                'Rocket Launcher',
                'Akimbo Uzi',
                'Desert Eagle',
                'Alien Blaster',
                'Crossbow',
                'Famas',
                'Sawed OFF',
                'Auto Pistol',
                'Blaster',
                'Grappler',
                'Tehchy',
                'Noob Tube',
                'Zapper',
                'Akimbo Pistol',
                'Charge Rifle',
                'Compressor',
                'Hats',
                'Body',
                'Melee',
                'Sprays',
                'Dyes',
                'Waist',
                'Faces',
                'Shoes',
                'Pets',
                'Collectibles',
                'Wrist',
                'Charms',
                'Tickets',
                'Back',
                'Head',
                'Playercards'
            ]),
            'tag' => fake()->optional()->randomElement(['Vaulted', 'Twitch', 'Raid', '???']),
            'author' => fake()->numberBetween(1, 10),
            'image_path' => $imagePath,
        ];
    }

    private function getValidImageUrl(): ?string
    {
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
                continue;
            }
        }

        return null;
    }
}
