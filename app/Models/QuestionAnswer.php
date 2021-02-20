<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function questionAnswerLikes(){
        return $this->hasMany(QuestionAnswerLike::class);
    }

    public function user(){
        return $this->belongsTo(User::class)
            ->select(["id", "firstName", "lastName", "avatar"]);
    }

}
