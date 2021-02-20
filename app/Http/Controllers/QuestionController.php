<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try {

            return Question::with(["user", "types"])
            ->withCount("questionAnswers")
                ->orderBy("created_at", "DESC")->get();

        }catch (\Exception $exception){
            return $exception->getMessage();
        }
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
            $data = $request->all();
            try {
                DB::beginTransaction();

                $q = new Question();
                $q->user_id = auth()->id();
                $q->question = $data["question"];
                $q->description = $data["description"];
                $q->exercise_id = $data["exercise_id"] ?? 0;

                $q->save();

                foreach ($data["categories"] as $category){
                    $t = new QuestionType();
                    $t->type_id = $category;
                    $t->question_id = $q->id;
                    $t->save();
                }


            }catch (\Exception $exception){
                DB::rollBack();
                return $exception->getMessage();
            }
            DB::commit();

            return ["ok"=>true, "message"=>"success"];

        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
        try {
          return Question::with(["user", "types", "questionAnswers", "questionAnswers.user", "questionAnswers.questionAnswerLikes"])
          ->withCount("questionAnswers")
              ->first();

        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
        try {
            if (!empty($question) && auth()->id()===$question->user_id){
                $question->update($request->all());
                return ["ok"=>true, "message"=>"success"];
            }
            return response("unathorized!", 401);

        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
        try {
            if (!empty($question) && (auth()->id()===2 || $question->user_id === auth()->id())){
                $question->delete();

            }
            return ["ok"=>true, "message"=>"success"];
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
}
