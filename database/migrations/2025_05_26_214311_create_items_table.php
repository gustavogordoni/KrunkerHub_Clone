<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('rarity'); // Unobtainable, Contraband, Relic, Legendary, Epic, Rare, Uncommon
            $table->integer('season'); // 1, 2, 3, 4, 5, 6, 7, 8
            $table->string('category'); // Sniper Rifle, Assault Rifle, Pistol, Submachine Gun, Revolver, Shotgun, Machine Gun, Semi Auto, Rocket Launcher, Akimbo Uzi, Desert Eagle, Alien Blaster, Crossbow, Famas, Sawed OFF, Auto Pistol, Blaster, Grappler, Tehchy, Noob Tube, Zapper, Akimbo Pistol, Charge Rifle, Compressor, Hats, Body, Melee, Sprays, byes, Waist, Faces, Shoes, Pets, Collectibles, Wrist, Charms, Tickets, Back, Head, Playercards.
            $table->string('tag')->nullable()->default('Vaulted'); // Vaulted, Twitch, Raid, ???. [others ?]
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('author')->nullable();
            $table->string('image_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
