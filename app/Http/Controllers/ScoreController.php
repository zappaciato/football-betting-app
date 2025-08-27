<?php

namespace App\Http\Controllers;

use App\Models\MatchModel;
use App\Models\Tournament;
use App\Models\Prediction;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    /**
     * Calculate and persist points for all predictions of a match.
     */
    public function updateMatchScores(MatchModel $match)
    {
        $predictions = $match->predictions;

        foreach ($predictions as $prediction) {
            $points = 0;

            if ($prediction->predicted_home === $match->result_home &&
                $prediction->predicted_away === $match->result_away) {
                $points = 3;
            } else {
                $predictionOutcome = $prediction->predicted_home <=> $prediction->predicted_away;
                $matchOutcome = $match->result_home <=> $match->result_away;

                if ($predictionOutcome === $matchOutcome) {
                    $points = 1;
                }
            }

            $prediction->update(['points_awarded' => $points]);
        }

        return redirect()->back()->with('status', 'Points calculated for predictions.');
    }

    /**
     * Return users with their total points for the given tournament.
     */
    public function show(Tournament $tournament)
    {
        $scores = Prediction::select('user_id', DB::raw('SUM(points_awarded) as points'))
            ->where('tournament_id', $tournament->id)
            ->groupBy('user_id')
            ->with('user')
            ->orderByDesc('points')
            ->get()
            ->map(function ($row) {
                return [
                    'user' => $row->user,
                    'points' => $row->points,
                ];
            });

        return $scores;
    }
}
