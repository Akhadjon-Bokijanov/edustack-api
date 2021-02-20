<?php

namespace App\Http\Controllers;

use App\Models\QuestionAnswerLike;
use Illuminate\Http\Request;

class QuestionAnswerLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
            $i = $request->only(["question_answer_id"]);
            if (empty(QuestionAnswerLike::where(["user_id"=>auth()->id(), "question_answer_id"=>$i])->first())){
                $a = new QuestionAnswerLike();
                $i["user_id"] = auth()->id();
                QuestionAnswerLike::create($i);
            }

            return ["ok"=>true, "message"=>"success"];
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionAnswerLike  $questionAnswerLike
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionAnswerLike $questionAnswerLike)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionAnswerLike  $questionAnswerLike
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionAnswerLike $questionAnswerLike)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionAnswerLike  $questionAnswerLike
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionAnswerLike $questionAnswerLike)
    {
        //
    }
}
