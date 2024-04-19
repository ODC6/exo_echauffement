<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    protected $table = 'dish';

    protected $fillable = [
        'dish_name',
        'slug',
        'dish_ingredient',
        'dish_recette',
        'preparation',
        'cuissons',
        'temps_total',
        'id_category'
    ];
}
