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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();

            $table->integer('level')->default(1);
            $table->unsignedBigInteger('kr')->default(0);
            $table->string('clan')->nullable();

            $table->float('junk')->nullable();
            $table->bigInteger('score')->nullable();
            $table->bigInteger('kills')->nullable();
            $table->bigInteger('deaths')->nullable();
            $table->bigInteger('games')->nullable();
            $table->bigInteger('wins')->nullable();
            $table->bigInteger('assists')->nullable();
            $table->bigInteger('melee')->nullable();
            $table->bigInteger('headshots')->nullable();
            $table->bigInteger('wallbangs')->nullable();
            $table->bigInteger('shots')->nullable();
            $table->bigInteger('hits')->nullable();
            $table->bigInteger('misses')->nullable();
            $table->time('time_played')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
