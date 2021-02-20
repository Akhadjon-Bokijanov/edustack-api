<?php


namespace App\Helpers;


use App\Models\User;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use Aws\S3\PostObjectV4;
use Aws\Exception\AwsException;

class S3Helper
{
    public function uploadAvatar(Request $request){
        try {
            $path = $request->file("avatar")->store("/images", 's3');

            //Storage::disk('s3')->setVisibility($path);

            if (auth()->user()->avatar){
                Storage::disk('s3')->delete(auth()->user()->avatar);
            }

            $user = User::find(auth()->id());
            $user->update(["avatar"=>$path]);

            return ["ok"=>true, "avatar"=>Storage::disk("s3")->temporaryUrl($path,'+10minutes')];
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public static function deleteFile($path){
        try {

            return Storage::disk("s3")->delete($path);


        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public function getSignedUrl(){
        try {
            $folder="uploads/";
            if (isset($_GET["folder"])){
                $folder=$_GET["folder"]."/";
            }
            $adapter = Storage::getAdapter();
            $client = $adapter->getClient();
            $bucket = $adapter->getBucket();

            $acl = 'public-read';
            $expires = '+10 minutes';
            $redirectUrl = url('/');

            $formInputs = [
                'acl' => $acl,
                'key' => $folder . '${filename}',
                //'success_action_redirect' => $redirectUrl,
            ];

            $options = [
                ['acl' => $acl],
                ['bucket' => $bucket],
                ['starts-with', '$key', $folder],
                //['eq', '$success_action_redirect', $redirectUrl],
            ];

            $postObject = new PostObjectV4($client, $bucket, $formInputs, $options, $expires);
            $attributes = $postObject->getFormAttributes();
            $inputs = $postObject->getFormInputs();

            return ["attributes"=>$attributes, "inputs"=>$inputs];
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
}
