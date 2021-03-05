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

  private $User;

  public function __construct(User $user)
  {
      return $this->User = $user;
  }

  public function login()
  {
    $credentials = request(['email', 'password']);
    $token = Auth::attempt($credentials);
    // dd($credentials);
          if (! $token ) {
          
            return $this->apiResponse(422,'unauthorized');
          }
          return $this->respondWithToken($token);
  }


  protected function respondWithToken($token)
  {
                                                      # $userData = User::findOrFail(Auth::user()->id);
    $userData = $this->User::findOrFail(Auth::user()->id);
    // dd(Auth::user()->role);
    $userRole=Auth::user()->role->name;
                                                      # $userRole=Auth::user()->role;
                                                      # dd($userData , $userRole);

                                                      //? another way as a query

                                                      // $user_data = User::where('id' , Auth::user()->id)->WhereHas('role', function($query){
                                                      //   return $query->where('name','admin'); 
                                                      // })->first() ;
    $data = [
      'name' => $userData->name,
      'email' => $userData->email,
      'phone' => $userData->phone,
      'Role' => $userRole,
      'access_token' => $token,
    ];
      return $this->apiResponse(200 , 'welcome' , null , $data);
  }


 
  public function addUserTester($request)
  {

    // dd($request);
      $validation = Validator::make(request()->all(),[
          'name' => 'required | min:3',
          'password' =>'required | min:3',
          'role_id' =>'required | numeric |max:5 |min:1',
          'email'=>'required | unique:users',
          
      ]);

      if ($validation->fails()) {
          return $this->ApiResponse(422,'validation error', $validation->errors());
      }

      $this->User::create([
          'name'=>$request->name,
          'email'=>$request->email,
          'password'=>Hash::make($request->password),
          'phone'=>$request->phone,
          'status'=>1,
          'role_id'=>$request->role_id,
          
      ]);

      return $this->login();

  }

}