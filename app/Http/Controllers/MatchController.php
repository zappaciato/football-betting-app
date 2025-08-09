<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MatchModel;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matches = MatchModel::all();
        return view('matches.matches_index', compact('matches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('matches.matches_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'home_team'     => 'required|string|max:255',
            'away_team'     => 'required|string|max:255',
            'match_date'    => 'required|date',
            'home_score'    => 'nullable|integer|min:0',
            'away_score'    => 'nullable|integer|min:0',
        ]);

        MatchModel::create($validated);

        return redirect()->route('matches.index')->with('success', 'Match created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $match = MatchModel::findOrFail($id);
        return view('matches.show', compact('match'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $match = MatchModel::findOrFail($id);
        return view('matches.edit', compact('match'));
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
        $validated = $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'home_team'     => 'required|string|max:255',
            'away_team'     => 'required|string|max:255',
            'match_date'    => 'required|date',
        ]);

        $match = MatchModel::findOrFail($id);
        $match->update($validated);

        return redirect()->route('matches.index')->with('success', 'Match updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $match = MatchModel::findOrFail($id);
        $match->delete();

        return redirect()->route('matches.index')->with('success', 'Match deleted successfully.');
    }
}
