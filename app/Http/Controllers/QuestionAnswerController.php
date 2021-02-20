<?php

namespace App\Http\Controllers;

use App\Models\QuestionAnswer;
use Illuminate\Http\Request;

class QuestionAnswerController extends Controller
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
            $data = $request->only(["question_id", "answer"]);
            $data["user_id"] = auth()->id();
            QuestionAnswer::create($data);

            return ["ok"=>true, "message"=>"success"];
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionAnswer  $questionAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionAnswer $questionAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionAnswer  $questionAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionAnswer $questionAnswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionAnswer  $questionAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionAnswer $questionAnswer)
    {
        //
        try {
            if (!empty($questionAnswer) && (auth()->user()->role===2 || auth()->id()===$questionAnswer->user_id)){
                $questionAnswer->delete();
                return ["ok"=>true, "message"=>"success"];
            }

            return response("fail to delete", 500);
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }
}
