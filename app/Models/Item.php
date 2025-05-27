<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rarity',
        'season',
        'category',
        'tag',
        'price',
        'author',
        'image_path',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function owners()
{
    return $this->belongsToMany(User::class)->withTimestamps();
}
}
