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
        return $this->hasMany(MatchModel::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'tournament_user');
    }
}
