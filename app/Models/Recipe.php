<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'image',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class);
    }

    public function foodType()
    {
        return $this->belongsToMany(FoodType::class);
    }

    public function diets()
    {
        return $this->belongsToMany(Diet::class);
    }

}

