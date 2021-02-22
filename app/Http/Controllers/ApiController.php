<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiDesignTrait;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use ApiDesignTrait;

    public function testApi($name)
    {
      if ($name == 'ahmed') {
        return $this->ApiResponse(200 , 'done',null,$name);
      }else{
        return $this->ApiResponse(422 , 'validation error','not  a user',null);
      }
    }


    public function testApirequest(Request $request)
    {
        
        return $request->name;
    }

}
