<?php

namespace App\Http\Controllers;


use App\Http\Requests\LoginRequest;
use App\Http\Requests\OtpRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Responses\Response;
use App\Mail\OtpMail;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    protected $AuthServices;
    public function index(Request $request)
    {
        $user=$request->user();

        return response()->json([

            "data"=>$user,
            'message' => 'User data retrieved successfully'
        ],200);
    }

     public function register(RegisterRequest $request)
    {
               $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'phone_number'=>$request->phone_number,
            'is_verified' => false,
        ]);
        $user->assignRole('user');
        $otp=$user->GenerateOtp();

        Mail::to($user->email)->send(new OtpMail($otp));
        return response()->json( ['message'=>'User registered. Please verify OTP sent to your email.'],
        201);
        
    }
    public function verifyOtp(OtpRequest $request)
{

    $user = User::where('email', $request->email)->where('otp', $request->otp)->first();

    if (!$user) {
        return response()->json(
            ['message'=>'Invalid OTP'],
            422);
    }

    if (Carbon::now()->gt($user->otp_expiry))
     {
        return response()->json(
            ['message'=>'OTP expired'],
            422);
        }
      

    $user->update([
        'otp' => null,
        'otp_expiry' => null,
        'is_verified' => true,
    ]);
    
    return response()->json(["data"=>$user,
        'message'=>'verified successfully'],
        200);

}

    public function login(LoginRequest $request)
    {
      

        $user = User::where('email', $request->identifier)
        ->orWhere('phone_number' , $request->identifier)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
            'message'=>'Invalid credentials'],
            401);
           
        }

        if (!$user->is_verified) {
            return response()->json([
                'message'=>'Please verify your email first.'],
                403);
    
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Logged in successfully',
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message'=>'Logged out successfully'],
            200);
       
    }


    public function forgetPassword(Request $request)
    {
        
        $val=$request->validate([
            'email' => 'required|email',
        ]);

        
        $user=User::where('email' , $val['email'])->first();
        if(!$user)
        {
            return response()->json([
                'message'=>'the email is not found'],
                404);
           
        }
        
        $otp=$user->GenerateOtp();

        Mail::to($user->email)->send(new OtpMail($otp));
        return response()->json([
            'message'=>'Please verify OTP sent to your email.'],
            201);
       
        
        
    }

    public function resetPassword(Request $request)
{
    

    $user = User::where('email', $request->email)->where('otp', $request->otp)->first();

    if (!$user) {
        return response()->json([
           'message'=>'Invalid OTP'],
            422);
    }

    if (Carbon::now()->gt($user->otp_expiry)) {
        return response()->json([
            'message' => 'OTP expired'],
            422);
    }

    $user->update([
        'password' => Hash::make($request->password),
        'otp' => null, 
        'otp_expiry' => null,
        'is_verified' => true,
    ]);

    return response()->json([
        'message' => 'password has been reset successfully'],
        200);
}


public function deleteAccount(Request $request)
{
        $user = User::where('email', $request->identifier)
        ->orWhere('phone_number' , $request->identifier)->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
            'message'=>'Invalid credentials'],
            401);
           
        }

        else{    
        $user->delete();
        return response()->json([

            'message'=>'deleted successfully',

        ],200);

    }

    
}



}
