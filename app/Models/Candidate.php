<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function voter()
    {
        return $this->belongsTo(Voter::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
