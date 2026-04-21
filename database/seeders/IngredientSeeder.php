<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = [
            'Leche',
            'Huevo',
            'Tomate',
            'Cebolla',
            'Aceite de oliva',
            'Sal',
            'Azúcar',
            'Harina',
            'Pollo',
            'Arroz',
        ];

        foreach ($ingredients as $ingredient) {
            \App\Models\Ingredient::create(['name' => $ingredient]);
        }
    }

}
