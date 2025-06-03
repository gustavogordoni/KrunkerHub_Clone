<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $games = fake()->numberBetween(100, 10000);
        $wins = fake()->numberBetween(0, $games);

        $totalShots = fake()->numberBetween(10000, 2000000);
        $accuracy = fake()->randomFloat(2, 0.05, 0.60);
        $hits = (int) round($totalShots * $accuracy);
        $misses = $totalShots - $hits;

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),

            'level' => fake()->numberBetween(1, 150),
            'kr' => fake()->numberBetween(0, 200000),
            'clan' => fake()->randomElement(['KRK', 'NTG', 'GOD', 'MPKS', null]),

            'junk' => fake()->randomFloat(2, 0, 300),
            'score' => fake()->numberBetween(10000, 99999999),
            'kills' => fake()->numberBetween(0, 500000),
            'deaths' => fake()->numberBetween(0, 400000),
            'games' => $games,
            'wins' => $wins,
            'assists' => fake()->numberBetween(0, 30000),
            'melee' => fake()->numberBetween(0, 10000),
            'headshots' => fake()->numberBetween(0, 50000),
            'wallbangs' => fake()->numberBetween(0, 5000),
            'shots' => $totalShots,
            'hits' => $hits,
            'misses' => $misses,
            'time_played' => fake()->time('H:i:s'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
