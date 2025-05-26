<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'image_path' => null,
        ];
    }
}
