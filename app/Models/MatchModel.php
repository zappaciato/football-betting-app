<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchModel extends Model
{
    use HasFactory;
    
    protected $table = 'matches'; // Important, otherwise Laravel will expect 'match_models' table
    protected $fillable = [
        'home_team', 'away_team', 'match_date',
        'home_score', 'away_score'
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function predictions()
    {
        return $this->hasMany(Prediction::class, 'match_id');
    }
}
