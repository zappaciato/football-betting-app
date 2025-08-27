<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MatchModel;
use App\Services\ScoreService;
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
        $userId = $request->user()->id;

    // 1) Turnieje użytkownika
    $tournamentIds = \DB::table('tournament_users')
        ->where('user_id', $userId)
        ->pluck('tournament_id');

    if ($tournamentIds->isEmpty()) {
        // Brak turniejów -> pokaż pusty stan w tym samym widoku
        return view('matches.indexUser', [
            'matches'     => collect(),
            'emptyTitle'  => 'Brak turniejów',
            'emptyText'   => 'Nie jesteś przypisany do żadnego turnieju.',
            // opcjonalnie np. link dokądś:
            'emptyCtaUrl' => route('tournaments.indexUser'),
            'emptyCtaTxt' => 'Zobacz swoje turnieje',
        ]);
    }

    // 2) Mecze dla tych turniejów
    $matchIds = \DB::table('tournament_matches')
        ->whereIn('tournament_id', $tournamentIds)
        ->distinct()
        ->pluck('match_id');

    if ($matchIds->isEmpty()) {
        return view('matches.indexUser', [
            'matches'     => collect(),
            'emptyTitle'  => 'Brak meczów',
            'emptyText'   => 'Twoje turnieje nie mają jeszcze żadnych meczów.',
        ]);
    }

    // 3) Normalny listing
    $matches = MatchModel::whereIn('id', $matchIds)
        ->with('tournaments')
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

    // Recalculate prediction points for this match
    app(ScoreService::class)->updatePredictionsForMatch($match);


return redirect()->route('matches.index')
                 ->with('success', 'Match scores updated successfully!')
                 ->with('status', 'Predictions recalculated.');
}
}
