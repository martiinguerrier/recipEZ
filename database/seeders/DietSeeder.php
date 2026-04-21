<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DietSeeder extends Seeder
{
    public function run(): void
    {
        $diets = [
            'Keto',
            'Vegana',
            'Vegetariana',
            'Mediterránea',
            'Sin gluten',
            'Paleo',
            'Low-carb'
        ];

        foreach ($diets as $diet) {
            \App\Models\Diet::create(['name' => $diet]);
        }
    }

}
