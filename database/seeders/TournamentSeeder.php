<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\TournamentSeeder;
use Database\Seeders\MatchSeeder;
use App\Models\Tournament;


class TournamentSeeder extends Seeder
{

    public function generateUniqueTournamentName()
{

        $digits = rand(100, 999);
        $letter = chr(rand(65, 90)); // A-Z uppercase
        $name = $digits . $letter;

    return $name;
}
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tournament::insert([
            [
                'name' => $this->generateUniqueTournamentName().'UEFA Champions League 2025',
                'slug' => $this->generateUniqueTournamentName().'uefa-champions-league-2025',
                'description' => 'Top European clubs competition 2025 season.',
                'start_date' => '2025-02-15',
                'end_date' => '2025-06-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => $this->generateUniqueTournamentName().'English Premier League 2025',
                'slug' => $this->generateUniqueTournamentName().'english-premier-league-2025',
                'description' => 'English top football league 2025 season.',
                'start_date' => '2025-08-10',
                'end_date' => '2026-05-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
