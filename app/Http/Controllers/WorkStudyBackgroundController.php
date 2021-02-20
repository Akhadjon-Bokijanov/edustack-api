<?php

namespace App\Http\Controllers;

use App\Models\WorkStudyBackground;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkStudyBackgroundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return ["background"=>WorkStudyBackground::where("user_id",auth()->id())->get()];
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
        $data=$request->all();
        try {
            DB::beginTransaction();
            WorkStudyBackground::where("user_id", auth()->id())->delete();
            foreach ($data["background"] as $datum){
                $bg = new WorkStudyBackground();
                $bg->user_id = auth()->id();
                $bg->address = $datum["address"];
                $bg->organization = $datum["organization"];
                $bg->startDate = date('Y-m-d H:m:s', strtotime($datum["startDate"]));
                $bg->endDate = date('Y-m-d H:m:s', strtotime($datum["endDate"]));
                if(!$bg->save()){
                    throw new \Exception("not  saved!", 400);
                }
            }
            DB::commit();
            return ["ok"=>true, "message"=>"success"];
        }catch (\Exception $exception){
            DB::rollBack();
            return  $exception->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkStudyBackground  $workStudyBackground
     * @return \Illuminate\Http\Response
     */
    public function show(WorkStudyBackground $workStudyBackground)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkStudyBackground  $workStudyBackground
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkStudyBackground $workStudyBackground)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkStudyBackground  $workStudyBackground
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkStudyBackground $workStudyBackground)
    {
        //
    }
}
