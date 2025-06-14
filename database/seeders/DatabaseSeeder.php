<?php

namespace Database\Seeders;

use App\Models\Item;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Item::factory(100)->create();
        
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@email.com',
            'password' => Hash::make('password'),
        ]);
        
        $inventoryItemIds = Item::inRandomOrder()->limit(rand(5, 50))->pluck('id');
        $user->items()->attach($inventoryItemIds);
        
        $saleItemIds = Item::whereNotIn('id', $inventoryItemIds)
            ->inRandomOrder()
            ->limit(rand(3, 15))
            ->pluck('id');

        foreach ($saleItemIds->take(10) as $itemId) {
            Sale::factory()->create([
                'user_id' => $user->id,
                'item_id' => $itemId,
                'status' => fake()->randomElement(['on_sale', 'sold']),
            ]);
        }
        
        User::factory(10)->create()->each(function ($user) {
            $inventoryItemIds = Item::inRandomOrder()->limit(rand(5, 50))->pluck('id');
            $user->items()->attach($inventoryItemIds);

            $saleItemIds = Item::whereNotIn('id', $inventoryItemIds)
                ->inRandomOrder()
                ->limit(5)
                ->pluck('id');

            foreach ($saleItemIds as $itemId) {
                Sale::factory()->create([
                    'user_id' => $user->id,
                    'item_id' => $itemId,
                ]);
            }
        });

        Sale::factory(30)->create();
    }
}
