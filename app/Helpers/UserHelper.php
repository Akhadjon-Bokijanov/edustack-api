<?php


namespace App\Helpers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserHelper
{
    public static function verifyUser(Request $request){
        try {

            $data = $request->only(["vToken"]);

            $user = User::find(auth()->user()->id)->first();

            if (!empty($user)){
                if ((integer)$user->verification_code===(integer)$data["vToken"]){
                    $user->email_verified_at = now(env("APP_LOCALE", "Asia/Tashkent"));
                    if ($user->save()){

                        return ["user"=>$user];
                    }
                }else{
                    return response()->json([
                        "message"=>"Kode xato!",
                    ], 401);
                }
            }
            return response()->json("User not found", 401);
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public static function signUpUser(Request $request){
        try {
            $data = $request->all();

            $user = new User();
            $user->firstName = $data["firstName"];
            $user->lastName = $data["lastName"];
            $user->email = $data["email"];
            $user->password = Hash::make($data["password"]);
            $user->auth_key = Str::random(30);
            $user->verification_code = rand(100201, 999090);

            if ($user->save()){
                $token = auth()->attempt(["email"=>$data["email"], "password"=>$data["password"]]);
                $user = auth()->user();
                $user["role"] = auth()->user()->role();
                    return [
                        "token"=>$token,
                        "user"=>$user,
                    ];
            }

        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public static function signInUser(Request $request){
        try {

            $data = $request->only(["email", "password"]);

            $token = auth()->attempt($data);
            $user = auth()->user();
            $user["role"] = auth()->user()->role;
            if ($token){
                return ["token"=> $token, "user"=>$user];
            }else{
                return ["token"=>null, "ok"=> false, "message"=>"fail"];
            }


        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
}
