<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionAnswerLike extends Model
{
    use HasFactory;

    public $timestamps=false;

    protected $guarded=[];

    public function questionAnswer(){
        return $this->belongsTo(QuestionAnswer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
