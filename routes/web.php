<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\ScoreController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



    Route::get('/dashboard', [TournamentController::class, 'indexUser'])->name('tournament.indexUser');
    Route::get('/homeee', [TournamentController::class, 'index'])->name('homeee'); //to jest do wywalenia
    Route::get('tournaments/user', [TournamentController::class, 'indexUser'])->name('tournaments.indexUser');

    Route::get('tournaments/{tournament}/predictions/create', [PredictionController::class, 'createForTournament'])->name('predictions.create');
    Route::get('tournaments/user/{tournament}', [TournamentController::class, 'tournamentUser'])->name('tournaments.tournamentUser');

    Route::get('matches/user', [MatchController::class, 'indexUser'])->name('matches.indexUser');
    Route::resource('matches', MatchController::class);

    Route::get('tournaments/{tournament}/matches/{match}/predictions/create', [PredictionController::class, 'create'])->name('predictions.create');
    Route::post('tournaments/{tournament}/matches/{match}/predictions', [PredictionController::class, 'store'])->name('predictions.store');


//Admin routes
    Route::middleware('admin')->group(function () {

        Route::get('matches/{match}/edit-score', [MatchController::class, 'editScore'])->name('matches.editScore');
        Route::put('matches/{match}/update-score', [MatchController::class, 'updateScore'])->name('matches.updateScore');
        Route::post('matches/{match}/score', [ScoreController::class, 'updateMatchScores'])->name('scores.update');
        Route::resource('tournaments', TournamentController::class);
        Route::delete('tournaments/{tournament}/matches/{match}', [TournamentController::class, 'removeMatch'])
            ->name('tournaments.matches.remove');

        Route::post('tournaments/{tournament}/matches', [TournamentController::class, 'addMatch'])
            ->name('tournaments.matches.add');

        Route::delete('tournaments/{tournament}/users/{user}', [TournamentController::class, 'removeUser'])
            ->name('tournaments.users.remove');

        Route::post('tournaments/{tournament}/users', [TournamentController::class, 'addUser'])
            ->name('tournaments.users.add');

});



});

require __DIR__.'/auth.php';

Auth::routes();


