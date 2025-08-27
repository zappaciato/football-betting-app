<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MatchModel;
use App\Models\Prediction;
use App\Models\Tournament;

class PredictionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource. It creates the list of unpredicted matches. 
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Tournament $tournament, MatchModel $match, Request $request)
    {
        //  abort_unless($match->tournament_id === $tournament->id, 404);

        $matchIds = $request->query('match_ids', []);

        if (!is_array($matchIds)) {
            $matchIds = json_decode($matchIds, true) ?: [];
        }

        $matchIds = array_map('intval', $matchIds);
        $matchIds = array_values(array_diff($matchIds, [$match->id]));

        $userId = $request->user()->id;
        $matchIds = MatchModel::whereIn('id', $matchIds)
            ->whereHas('tournaments', function ($q) use ($tournament) {
            $q->where('tournament_id', $tournament->id);
        })
            ->whereDoesntHave('predictions', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->pluck('id')
            ->toArray();

        return view('predictions.create', [
            'tournament' => $tournament,
            'match' => $match,
            'matchIds' => $matchIds,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tournament $tournament, MatchModel $match)
    {
        // abort_unless($match->tournament_id === $tournament->id, 404);

        $matchIds = $request->input('match_ids', []);
        if (!is_array($matchIds)) {
            $matchIds = json_decode($matchIds, true) ?: [];
        }

        $matchIds = array_map('intval', $matchIds);

        $userId = $request->user()->id;
        $matchIds = MatchModel::whereIn('id', $matchIds)
            ->whereHas('tournaments', function ($q) use ($tournament) {
            $q->where('tournament_id', $tournament->id);
        })
            ->whereDoesntHave('predictions', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->pluck('id')
            ->toArray();

        $validated = $request->validate([
            'predicted_home' => ['required', 'integer', 'min:0'],
            'predicted_away' => ['required', 'integer', 'min:0'],
        ]);

        $prediction = Prediction::updateOrCreate(
            [
                'tournament_id' => $tournament->id,
                'match_id' => $match->id,
                'user_id' => $userId,
            ],
            [
                'predicted_home' => $validated['predicted_home'],
                'predicted_away' => $validated['predicted_away'],
            ]
        );



        $nextMatchId = array_shift($matchIds);

        if ($nextMatchId) {
            return redirect()->route('predictions.create', [
                'tournament' => $tournament->id,
                'match' => $nextMatchId,
                'match_ids' => $matchIds,
            ])->with('status', 'Prediction saved.');
        }
        $scores = app(\App\Http\Controllers\ScoreController::class)->show($tournament);
        // return redirect()->route('tournaments.tournamentUser', $tournament)->with('status', 'Prediction saved.');
            return view('tournaments.tournamentUser', compact('tournament', 'prediction', 'scores'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
