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

    if ($showAll) {
        // Show all tournaments, no filter
        $tournaments = Tournament::orderBy('created_at', 'desc');

    } else {
        // Show tournaments having at least one match with missing score (active tournaments)
        $tournaments = Tournament::whereHas('matches', function ($query) {
            $query->whereNull('result_home')
                  ->orWhereNull('result_away')
                  ->orWhere('result_home', '')
                  ->orWhere('result_away', '');
        })->orderBy('created_at', 'desc');

    }
    $tournaments = $tournaments->get();

    return view('tournaments.index', compact('tournaments', 'showAll'));
    }

public function create()
{
    $users = User::all();
    $matches = \App\Models\MatchModel::all();
    return view('tournaments.tournaments_create', compact('users','matches'));
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
                print_r($tournament);
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

        return view('tournaments.edit', compact('tournament', 'allMatches', 'allUsers'));
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


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tournament->update($request->all());
        return response()->json($tournament);
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
