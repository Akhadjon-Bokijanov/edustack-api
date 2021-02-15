<?php


namespace App\Helpers;


use App\Models\User;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class S3Helper
{
    public function uploadAvatar(Request $request){
        try {
            $path = $request->file("avatar")->store("/images", 's3');

            Storage::disk('s3')->setVisibility($path, 'public');

            if (auth()->user()->avatar){
                Storage::disk('s3')->delete(auth()->user()->avatar);
            }

            $user = User::find(auth()->id());
            $user->update(["avatar"=>$path]);

            return ["ok"=>true, "avatar"=>$path];
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
}
