<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $tournaments = Tournament::get();
        return view('tournaments.tournaments_index', compact('tournaments'));
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
        return $tournament->load('matches', 'users');
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
