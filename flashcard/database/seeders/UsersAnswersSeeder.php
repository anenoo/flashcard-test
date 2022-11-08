<?php

namespace Database\Seeders;

use App\Models\UsersAnswers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersAnswersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UsersAnswers::factory()
            ->count(10)
            ->create();
    }
}
