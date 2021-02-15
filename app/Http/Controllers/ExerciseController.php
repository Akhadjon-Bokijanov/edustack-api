<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return Exercise::with(['user', "types", "levels"])
            ->withCount("exerciseScore")
            ->withAvg("exerciseRates", "rate")
            ->get()->makeHidden(["inputFields"]);
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
                $exercise = new Exercise();
                $exercise->user_id = auth()->user()->id;
                $exercise->description = $data["description"];
                $exercise->title = $data["title"];
                $exercise->isActive = $data["isActive"];
                $exercise->isPrivate = $data["isPrivate"] ?? false;
                $exercise->time = $data["time"];
                $exercise->cost = $data["cost"];
                $exercise->inputFields = json_encode($data["inputFields"]);
                $exercise->save();

                foreach ($data["levels"] as $level){
                    $exercise->levels()->attach($level);
                }
                foreach ($data["types"] as $type){
                    $exercise->types()->attach($type);
                }

            } catch (\Exception $exception){
                DB::rollBack();
                return  $exception->getMessage();
            }


            DB::commit();

            return $exercise;
        }catch (\Exception $exception){
            return $exception->getMessage();
        }




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return Exercise::with(['user', "types", "levels"])
            ->withCount("exerciseScore")
            ->withAvg("exerciseRates", "rate")
            ->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
