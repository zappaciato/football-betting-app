<?php

namespace App\Services;

use App\Models\MatchModel;
use App\Models\Prediction;
use Illuminate\Support\Facades\Log;

class ScoreService
{
    /**
     * Recalculate prediction points for a given match.
     */
    public function updatePredictionsForMatch(MatchModel $match): void
    {
        // make sure predictions and related users are loaded
        $match->load('predictions.user');

        foreach ($match->predictions as $prediction) {
            if ($match->result_home === null || $match->result_away === null) {
                continue; // cannot score without results
            }

            $points = 0;

            if ($prediction->predicted_home === $match->result_home &&
                $prediction->predicted_away === $match->result_away) {
                $points = 3; // exact score
            } else {
                $predOutcome = $this->outcome($prediction->predicted_home, $prediction->predicted_away);
                $matchOutcome = $this->outcome($match->result_home, $match->result_away);
                if ($predOutcome === $matchOutcome) {
                    $points = 1; // correct result
                }
            }

            if ($prediction->points_awarded != $points) {
                $prediction->points_awarded = $points;
                $prediction->save();

                // Optional: update user's total points
                if ($prediction->user) {
                    $total = Prediction::where('user_id', $prediction->user_id)->sum('points_awarded');
                    $prediction->user->total_points = $total;
                    $prediction->user->save();
                }
            }
        }

        Log::info('Predictions recalculated for match ID ' . $match->id);
    }

    /**
     * Helper to determine outcome (-1 away win, 0 draw, 1 home win).
     */
    protected function outcome(int $home, int $away): int
    {
        return $home <=> $away;
    }
}