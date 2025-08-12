<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'start_date', 'end_date'];

    public function matches()
    {
        return $this->belongsToMany(
        MatchModel::class,
        'tournament_matches', // pivot table name
        'tournament_id',      // foreign key on pivot table for this model (Tournament)
        'match_id'            // foreign key on pivot table for related model (MatchModel)
    );
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'tournament_users');
    }

}
