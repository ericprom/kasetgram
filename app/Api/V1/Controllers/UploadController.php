<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Image;
use Response;

class UploadController extends Controller
{
    use Helpers;


    public $successStatus = 200;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function avatar(Request $request){
        try {
            $data = $request->all();
            $filename = sha1('avatar-'.  $data['filename'].'-'.time()).".jpg";
            Image::make(file_get_contents( $data['base64_image']))->save(public_path('avatars/' . $filename));
            $user = Auth::user();
            $user->avatar = '/avatars/' .$filename;
            $user->save();
            return Response::json([
                'user' => $user
            ], $this->successStatus);
        } catch (Exception $e) {
            return Response::json([
                'type' => 'warning',
                'title' => 'Warning',
                'text' => 'เกิดข้อผิดพลาดไม่สามารถบันทึกข้อมูลได้'
            ], $this->errorStatus);
        }
    }
}
