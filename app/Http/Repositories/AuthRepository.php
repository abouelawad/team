<?php 
namespace App\Http\Repositories;


use App\Models\User;
use App\Http\Traits\ApiDesignTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Interfaces\AuthInterface;
use Illuminate\Support\Facades\Validator;

class AuthRepository implements AuthInterface
{
  use ApiDesignTrait;

  public function login()
  {
    $credentials = request(['email', 'password']);
    // dd($credentials);
          if (! $token = auth()->attempt($credentials)) {
          
            return $this->ApiResponse(422,'unauthorized');
          }
          return $this->respondWithToken($token);
  }


  protected function respondWithToken($token)
  {
      return response()->json([
          'access_token' => $token
      ]);
  }


  // public function addUserTester(Request $request)
  public function addUserTester($request)
  {

    // dd($request);
      $validation = Validator::make(request()->all(),[
          'name' => 'required | min:3',
          'password' =>'required | min:3',
          'email'=>'required | unique:users',
          
      ]);

      if ($validation->fails()) {
          return $this->ApiResponse(422,'validation error', $validation->errors());
      }

      User::create([
          'name'=>$request->name,
          'email'=>$request->email,
          'password'=>Hash::make($request->password),
          'phone'=>$request->phone,
          'status'=>1,
          'role_id '=>1,
          
      ]);

      return $this->login();

  }

}