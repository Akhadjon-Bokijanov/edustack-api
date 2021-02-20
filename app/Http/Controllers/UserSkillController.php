<?php

namespace App\Http\Controllers;

use App\Models\UserSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return ["skills"=>UserSkill::where("user_id", auth()->id())->get()];
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

            $data = $request->all();
            DB::beginTransaction();
            try {
                auth()->user()->userSkills()->delete();
                foreach ($data["skills"] as $skill){
                    $s = new UserSkill();
                    $s->skill = $skill["skill"];
                    $s->level = $skill["level"];
                    $s->user_id = auth()->id();

                    if (!$s->save()){
                        throw new \Exception("Skill not saved", 500);
                    }
                }
            }catch (\Exception $exception){
                DB::rollBack();
                return $exception->getMessage();
            }
            DB::commit();
            return ["ok"=>true, "message"=>"success"];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserSkill  $userSkill
     * @return \Illuminate\Http\Response
     */
    public function show(UserSkill $userSkill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserSkill  $userSkill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserSkill $userSkill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserSkill  $userSkill
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserSkill $userSkill)
    {
        //
    }
}
