<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MatchModel;
use Carbon\Carbon;


class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    // Only matches missing scores
    $matches = MatchModel::get();


    return view('matches.index', compact('matches'));

        // $matches = MatchModel::all();
        // return view('matches.matches_index', compact('matches'));
    }

public function indexUser(Request $request)
{
        $user = auth()->user(); // logged-in user

    // 1. Get all tournament IDs the user belongs to (from tournaments_users pivot table)
    $tournamentIds = \DB::table('tournament_users')
        ->where('user_id', $user->id)
        ->pluck('tournament_id');

    if ($tournamentIds->isEmpty()) {
    // User is not part of any tournament
        return redirect()->route('matches.indexUser')
                     ->with('warning', 'You are not part of any tournament yet.');
    }

    // 2. Get all match IDs for these tournaments (from tournament_matches pivot table)
    $matchIds = \DB::table('tournament_matches')
        ->whereIn('tournament_id', $tournamentIds)
        ->pluck('match_id')
        ->unique(); // remove duplicates if the same match is in multiple tournaments

    if ($matchIds->isEmpty()) {
        // No matches for these tournaments
    // User is not part of any tournament
    return redirect()->route('matches.indexUser')
                     ->with('warning', 'You are not part of any tournament yet.');
    }

    // 3. Get matches with optional filtering (matches without results)
    $matches = MatchModel::whereIn('id', $matchIds)
        ->with('tournament')
        ->orderBy('match_date', 'asc')
        ->get();

    return view('matches.indexUser', compact('matches'));
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('matches.create');
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

    // Show form to edit only the score of a match
public function editScore(MatchModel $match)
{
    return view('matches.edit_score', compact('match'));
}

// Handle updating just the scores
public function updateScore(Request $request, MatchModel $match)
{
// dd($request);
$data = $request->validate([
        'result_home' => 'required|integer|min:0',
        'result_away' => 'required|integer|min:0',
    ]);

    // Only update scores explicitly
    $match->result_home = $data['result_home'];
    $match->result_away = $data['result_away'];
    $match->save();

return redirect()->route('matches.index')
                 ->with('success', 'Match scores updated successfully!');
}
}
