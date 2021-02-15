<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Exercise extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function types(){
        return $this->belongsToMany(Type::class);
    }

    public function levels(){
        return $this->belongsToMany(Level::class);
    }

    public function user(){
        return $this->belongsTo(User::class)->select(["id", "firstName", "lastName"]);
    }

    public function exerciseScore(){
        return $this->hasMany(ExerciseScore::class);
    }

    public function exerciseRates(){
        return $this->hasMany(ExerciseRating::class);//->select(DB::raw("AVG(rate) as avg_rating"));
    }

}
