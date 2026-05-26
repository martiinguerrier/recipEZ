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

    public function likes()
    {
        return $this->hasMany(RecipeLike::class);
    }

    public function likedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function saves()
    {
        return $this->hasMany(RecipeSave::class);
    }

    public function savedBy(User $user)
    {
        return $this->saves()->where('user_id', $user->id)->exists();
    }

}

