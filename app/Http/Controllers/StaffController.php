<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\ApiDesignTrait;
use App\Http\Interfaces\StaffInterface;

class StaffController extends Controller 
{
    use ApiDesignTrait;
    private $staffInterface;


public function __construct(StaffInterface $staffInterface )
{
     $this->staffInterface = $staffInterface;
}

public function addStaff(Request $request)
{
   return  $this->staffInterface->addStaff($request);
}

  public function updateStaff(Request $request){
      return $this->staffInterface->updateStaff($request);
  }
  public function deleteStaff(Request $request)
  {
    return  $this->staffInterface->deleteStaff($request);
  }

  public function allStaff(){
      return $this->staffInterface->allStaff() ;
  }

  public function specificStaff(Request $request){  
    return $this->staffInterface->specificStaff($request);
    }
}
