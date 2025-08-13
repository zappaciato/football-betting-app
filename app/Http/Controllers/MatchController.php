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
    $matches = MatchModel::where(function ($query) {
        $query->whereNull('result_home')
              ->orWhereNull('result_away')
              ->orWhere('result_home', '')
              ->orWhere('result_away', '');
    })
    ->orderBy('match_date', 'asc')
    ->get();

    return view('matches.index', compact('matches'));

        // $matches = MatchModel::all();
        // return view('matches.matches_index', compact('matches'));
    }

public function indexUser(Request $request)
{
    $user = auth()->user(); // logged-in user
    $showAll = $request->query('show') === 'all';

    // 1. Get all tournament IDs the user belongs to
    $tournamentIds = $user->tournaments()->pluck('tournaments.id');

    // 2. Get all match IDs from tournament_matches for these tournaments
    $matchIds = \DB::table('tournament_matches')
        ->whereIn('tournament_id', $tournamentIds)
        ->pluck('match_id');

    // 3. Get matches with optional filtering
    $matchesQuery = MatchModel::whereIn('id', $matchIds)->with('tournament');

    if (!$showAll) {
        $matchesQuery->where(function ($query) {
            $query->whereNull('result_home')
                  ->orWhereNull('result_away')
                  ->orWhere('result_home', '')
                  ->orWhere('result_away', '');
        });
    }

    // 4. Order by date
    $matches = $matchesQuery->orderBy('match_date', 'asc')
        ->get();

    return view('matches.indexUser', compact('matches', 'showAll'));
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
