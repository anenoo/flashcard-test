<?php

namespace Database\Seeders;

use App\Models\Flashcards;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FlashcardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Flashcards::factory()
            ->count(10)
            ->create();
    }
}
