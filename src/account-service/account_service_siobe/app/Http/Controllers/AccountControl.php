<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Hashing\BcryptHasher;
use GuzzleHttp\Client;
use App\Models\User;
use App\Models\StudentData;

class AccountControl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','forgot_password','get_profile']]);
    }

    public function get_profile($id, User $user)
    {
        $ids = explode('-', $id);

        $response = [];

        foreach ($ids as $userId) {
            $matchedUser = User::find($userId);

            if ($matchedUser) {
                $nim = $matchedUser->getNim->student_id_number;

                $response[] = [
                    "id" => $matchedUser->id,
                    "name" => $matchedUser->name,
                    "email" => $matchedUser->email,
                    "role" => $matchedUser->role,
                    "student_id_number" => $nim,
                ];
            }
            else {
                $response[] = [
                    "id" => $userId,
                    "status" => "user not found"
                ];
            }
        }
        return response()->json($response);
    }

    //HTTP POST
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ]);
        if($validator->fails()){
            return response()->json($validator->messages());
        }
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>Hash::make($request->password),
        ]);
        $user->save();

        //untuk membuat link email verifikasi
        $user = User::where('email', $request->email)->first();
        $p = "";
        $link = "http://127.0.0.1:8000/api/auth/verify-email?token=";
        $token = auth()->login($user);
        $generatedlink = implode($p, array($link, $token));

        // //request send email
        // $client = new Client();
        // $response = $client -> post('http://127.0.0.1:8080/emails', [
        //     'json' => [
        //         'to' => $user->email,
        //         'subject' => "Verify Email Address",
        //         'text' => $token." \n This email verification will expire in 60 minutes",
        //     ]
        // ]);
        // //response handle
        // $body = $response->getBody();
        // $data = json_decode($body, true);
        // $status = $data['status'];
        // $message = $data['message'];

        if($user){
            // return response()->json([
            //      "status" => "201 User successfully created",
            //      "status" => $status,
            //      "message" => $message,
            // ]);  
            return response()->json([
                "status" => "201 User successfully created",
                "email_to" => $user->email,
                "link" => $generatedlink,
            ]);          
        }
        else{
            return response()->json([
                "status" => "503 service unavailable",
            ]);
        }
    }

    public function verify_email(Request $request, User $user)
    {
        $id = auth()->user()->id;
        $user = $user::find($id);
        $verify = ([
            'email_verified_at' => now(),
        ]);
        $user->update($verify);
        //agar link verify tidak berlaku lagi setelah berhasil verify
        Auth::logout();
        return response()->json([
            "status" => "email verified",
        ]);
    }


    public function login(Request $request, User $user)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->messages());
        }
        if (! $token = auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'status' => 'incorrect username or password'], 401);
        }
        return $this->respondWithToken($token);     
    }


    public function profile(Request $request, User $user, StudentData $studentdata)
    {
        $validator = Validator::make($request->all(),[
            'password' => 'required',
            'new_name' => 'max:255',
            'email' => 'email|unique:users',
            'new_password' => 'min:8',
            'new_password_confirmation' => 'same:new_password',
            'student_id_number' => 'max:255|unique:student_data',
        ]);
        if($validator->fails()){
            return response()->json($validator->messages());
        }

        $id = auth()->user()->id;
        $user = User::find($id);
        $studentid = StudentData::find($id);

        $statusnim ="";
        $statusname ="";
        $statuspassword = "";
        $statusemail = "";
        $email_to = "";
        $generatedlink = "";

        if (($user->id == $id) && (Hash::check($request->password, $user->password))) {
            if(isset($request->new_name)){
                $user->update(['name' => $request->new_name]);
                $statusname = "Success";
            }
            if((isset($request->new_password)) && (isset($request->new_password_confirmation))){
                $user->update(['password' => Hash::make($request->new_password)]);
                $statuspassword = "Success";
            }
            if(isset($request->email)){
                $reset =([
                    'email' => $request->email,
                    'email_verified_at' => null,
                ]);
                $user->update($reset);
                $statusemail = "Success";

                //untuk membuat link email verifikasi
                $p = "";
                $link = "http://127.0.0.1:8000/api/auth/verify-email?token=";
                $token = auth()->login($user);
                $generatedlink = implode($p, array($link, $token));
                //
                $email_to = $user->email;
            }
            if(isset($request->student_id_number)){
                if($studentdata->where('id', $id)->doesntExist()){
                    $newnim = new StudentData([
                    'id' => $id,
                    'student_id_number' => $request->student_id_number,
                ]);
                $newnim->save();
                $statusnim = "Success";
                }
                else{
                    $studentid->update(['student_id_number' => $request->student_id_number]);
                    $statusnim = "Success";
                }
            }
            $response[] = [
                "nim_update" => $statusnim,
                "name_update" => $statusname,
                "password_update" => $statuspassword,
                "email_update" => $statusemail,
                "email_to" => $email_to,
                "verification_link" => $generatedlink,
            ];
            if($user->wasChanged() || $statusnim === "Success"){
                return response()->json(
                    $response
                );
            }
            else{
                return response()->json([
                    "status" => "200 nothing has changed"
                ]);
            }
        }
        else {
            return response()->json([
                "status" => "401 incorrect password",
            ]);
        }
    }

    public function forgot_password(Request $request, User $user)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
        ]);
        if($validator->fails()){
            return response()->json($validator->messages());
        }
        if ($user->where('email', $request->email)->doesntExist()) {
            return response()->json([
                "Status" => "400 Email doesnt exist",
            ]);
        }
        else {
            //generate token
            $user = $user->where('email', $request->email)->first();
            $p = "";
            $link = "http://127.0.0.1:8000/api/auth/reset-password?token=";
            $token = auth()->login($user);
            $generatedlink = implode($p, array($link, $token));

            return response()->json([
                "email_to" => $user->email,
                "link" => $generatedlink,
            ]);

        //     //request send email
        //     $client = new Client();
        //     $response = $client -> post('http://127.0.0.1:8080/emails', [
        //     'json' => [
        //         'to' => $user->email,
        //         'subject' => "Reset Password Notification",
        //         'text' => $token." \n This email verification will expire in 60 minutes",
        //     ]
        //     ]);
        //     //response handle
        //     $body = $response->getBody();
        //     $data = json_decode($body, true);
        //     $status = $data['status'];
        //     $message = $data['message'];

        //     return response()->json([
        //         "status" => $status,
        //         "message" => $message,
        //     ]);
        }
    }   

    public function reset_password(Request $request, User $user)
    { 
        $id = auth()->user()->id;
        $user = $user::find($id);

        $validator = Validator::make($request->all(),[
            'new_password' => 'required|min:8',
            'new_password_confirmation' => 'required|same:new_password',
        ]);
        if($validator->fails()){
            return response()->json($validator->messages());
        }
        $reset = ([
            'password' => Hash::make($request->new_password),
        ]);
        $user->update($reset);
        //agar link reset tidak berlaku lagi setelah berhasil ganti pass
        Auth::logout();
        return response()->json([
            "status" => "password changed successfully",
        ]);
    }


    public function delete_account($id, User $user)
    {
        $user = User::find($id);
        if($user){
            $user->delete();
            return response()->json([
                "status" => "user successfully deleted",
            ]);
        }
        else{
            return response()->json([
                "status" => "user not found",
            ]);
        }
        
    }

    ///default JWT
    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['status' => 'Successfully logged out']);
    }

    // public function refresh()
    // {
    //     return $this->respondWithToken(auth()->refresh());
    // }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}