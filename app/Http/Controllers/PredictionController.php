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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Tournament $tournament, MatchModel $match)
    {
        return view('predictions.create', compact('tournament', 'match'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tournament $tournament, MatchModel $match)
    {
                $validated = $request->validate([
            'predicted_home' => ['required', 'integer', 'min:0'],
            'predicted_away' => ['required', 'integer', 'min:0'],
        ]);

        Prediction::updateOrCreate(
            [
                'tournament_id' => $tournament->id,
                'match_id' => $match->id,
                'user_id' => $request->user()->id,
            ],
            [
                'predicted_home' => $validated['predicted_home'],
                'predicted_away' => $validated['predicted_away'],
            ]
        );

        return redirect()->back()->with('status', 'Prediction saved.');
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
