<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\TournamentSeeder;
use Database\Seeders\MatchSeeder;
use App\Models\Tournament;
use App\Models\MatchModel;


class MatchSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Assuming tournaments with IDs 1 and 2 exist
        MatchModel::factory()
            ->count(5)
            ->create();

        MatchModel::factory()
            ->count(5)
            ->create();
    }
}
