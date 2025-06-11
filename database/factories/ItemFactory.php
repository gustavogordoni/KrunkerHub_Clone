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
                'Sniper Rifle', // 1
                'Assault Rifle', // 2
                'Pistol', // 
                'Submachine Gun', // 4
                'Revolver', // 5
                'Shotgun', // 6
                'Machine Gun', // 7
                'Semi Auto', // 8
                'Rocket Launcher', // 9
                'Akimbo Uzi', // 10
                'Desert Eagle', // 11
                'Alien Blaster', // 12
                'Crossbow', // 14
                'Famas', // 15
                'Sawed OFF', // 16
                'Auto Pistol', // 17
                'Blaster', // 19
                'Grappler', // 
                'Tehchy', // 22
                'Noob Tube', // 23
                'Zapper', // 25
                'Akimbo Pistol', // 28
                'Charge Rifle', // 19
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
            'tag' => fake()->optional()->randomElement(['Vaulted', 'Twitch', 'Raid', '???', 'Kanji', 'Subzero', 'Christmas']),
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
