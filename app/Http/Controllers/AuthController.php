<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\ApiDesignTrait;
use Illuminate\Support\Facades\Hash;
use App\Http\Interfaces\AuthInterface;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class AuthController extends Controller
{
    
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

}

