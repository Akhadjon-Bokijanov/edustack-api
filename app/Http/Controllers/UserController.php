<?php

namespace App\Http\Controllers;

use App\Helpers\S3Helper;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
        try {
            if ($user){
                $data = $request->all();

                if (!empty($data["avatar"]) && $user->avatar){
                    //return ["req"=>$data["avatar"], "user_a"=>$user->avatar];
                    S3Helper::deleteFile($user->avatar);
                }

                if (!empty($data["dateOfBirth"])){
                    $data["dateOfBirth"] = date('Y-m-d 00:00:00', strtotime($data["dateOfBirth"]));
                }

                if ($user->update($data)){
                    return ["user"=>$user];
                }
                return response()->json("fail to update", 500);
            }
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
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
