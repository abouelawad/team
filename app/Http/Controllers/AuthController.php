<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Traits\ApiDesignTrait;
use Illuminate\Support\Facades\Hash;
use App\Http\Interfaces\AuthInterface;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class AuthController extends Controller
{
    use ApiDesignTrait;
    private $authInterface;
  
    public function __construct(AuthInterface $authInterface)
    {
        // $this->middleware('auth:api', ['except' => ['login' ,'addUserTester' ]]);/

       return $this->authInterface = $authInterface;
    }

    public function login()
    {
       return $this->authInterface->login();
    }

   

    public function addUserTester(Request $request)
    {
        return $this->authInterface->addUserTester($request);
    }

    // public function addUserTester(Request $request)
    // {
    // $validation = Validator::make($request->all(),[
    //     'name' => 'required | min:3',
    //     'password' =>'required | min:3',
    //     'email'=>'required | unique:users',
        
    // ]);

    // if ($validation->fails()) {
    //     return $this->ApiResponse(422,'validation error', $validation->errors());
    // }

    // User::create([
    //     'name'=>$request->name,
    //     'email'=>$request->email,
    //     'password'=>Hash::make($request->password),
    //     'phone'=>$request->phone,
    //     'status'=>1,
    //     'role_id '=>1,
        
    // ]);

    // return $this->login();

    // }



    // protected function respondWithToken($token)
    // {
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => $this->guard()->factory()->getTTL() * 60
    //     ]);
    // }

    // public function guard()
    // {
    //     return Auth::guard();
    // }

}

