<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\User;
use App\Models\MatchModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $showAll = $request->query('show') === 'all';

    $tournaments = Tournament::with('matches');

    if (!$showAll) {
        // Only tournaments with matches missing scores
        $tournaments->whereHas('matches', function ($query) {
            $query->where(function ($q) {
                $q->whereNull('result_home')
                  ->orWhereNull('result_away')
                  ->orWhere('result_home', '')
                  ->orWhere('result_away', '');
            });
        });
    }

    // Order tournaments by latest match date
    $tournaments = $tournaments->withMax('matches', 'match_date')
                               ->orderBy('matches_max_match_date', 'desc')
                               ->get();

    return view('tournaments.index', compact('tournaments', 'showAll'));
    }

public function create()
{
    $users = User::all();
    $matches = \App\Models\MatchModel::all();
    return view('tournaments.create', compact('users','matches'));
}

public function store(Request $request)
{
        $data = $request->validate([
        'name' => 'required|string|unique:tournaments,name',
        'description' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'users' => 'required|array|min:1',
        'users.*' => 'exists:users,id',
        'matches' => 'required|array|min:1',
        'matches.*' => 'exists:matches,id',
    ]);

    $data['slug'] = Str::slug($data['name']); // dodajemy slug

    $tournament = Tournament::create($data);

    $tournament->users()->sync($data['users']);
    $tournament->matches()->sync($data['matches']);

    return redirect()->route('tournaments.index')->with('success', 'Tournament created successfully!');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $tournament = Tournament::findOrFail($id);

        return view('tournaments.tournament', compact('tournament'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tournament $tournament)
    {
        $allMatches = MatchModel::orderBy('match_date', 'asc')->get();
        $allUsers = User::orderBy('name')->get(); 
        $latestMatchDate = $tournament->matches()->max('match_date');

        return view('tournaments.edit', compact('tournament', 'allMatches', 'allUsers', 'latestMatchDate'));
    }

    public function addUser(Request $request, Tournament $tournament)
{
    $request->validate([
        'user_id' => 'required|exists:users,id'
    ]);

    $tournament->users()->attach($request->user_id);

    return redirect()->back()->with('success', 'User added to the tournament.');
}

public function removeUser(Tournament $tournament, User $user)
{
    $tournament->users()->detach($user->id);

    return redirect()->back()->with('success', 'User removed from the tournament.');
}

public function addMatch(Request $request, Tournament $tournament)
{
    $request->validate([
        'match_id' => 'required|exists:matches,id'
    ]);

    $tournament->matches()->attach($request->match_id);

    return redirect()->back()->with('success', 'Match added to the tournament.');
}

public function removeMatch(Tournament $tournament, MatchModel $match)
{
    $tournament->matches()->detach($match->id);

    return redirect()->back()->with('success', 'Match removed from the tournament.');
}


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tournament $tournament)
    {
    // Validate only fields you want editable
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_date' => 'required|date',
    ]);

    // Update basic fields
    $tournament->fill($validated);

    // Calculate latest match date for this tournament
    $latestMatchDate = $tournament->matches()->max('match_date');

    if ($latestMatchDate) {
        $tournament->end_date = \Carbon\Carbon::parse($latestMatchDate)->format('Y-m-d');
    } else {
        $tournament->end_date = $tournament->start_date; // fallback if no matches
    }

    $tournament->save();

    return redirect()->route('tournaments.edit', $tournament->id)
                     ->with('success', 'Tournament updated successfully.');
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
