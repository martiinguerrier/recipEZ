<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Desayuno',
            'Almuerzo',
            'Comida',
            'Merienda',
            'Cena',
            'Entrante',
            'Postre',
            'Snack',
            'Bebida'
        ];

        foreach ($types as $type) {
            \App\Models\FoodType::create(['name' => $type]);
        }
    }

}
