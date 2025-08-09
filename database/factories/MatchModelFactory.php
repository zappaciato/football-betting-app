<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tournament;

class MatchModelFactory extends Factory
{
    protected $model = \App\Models\MatchModel::class;

    public function definition()
    {
        // Random teams from a predefined list
        $teams = ['Chelsea', 'Real Madrid', 'Bayern Munich', 'Manchester City', 'Arsenal', 'Liverpool', 'Manchester United'];

        // Pick two distinct teams for home and away
        $home_team = $this->faker->randomElement($teams);
        do {
            $away_team = $this->faker->randomElement($teams);
        } while ($away_team === $home_team);

        // Random match date between tournament dates (you can customize)
        $match_date = $this->faker->dateTimeBetween('2025-03-01', '2025-06-01');

        return [
            'home_team' => $home_team,
            'away_team' => $away_team,
            'match_date' => $match_date,
            'result_home' => null,
            'result_away' => null,
        ];
    }
}
