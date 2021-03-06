<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Interfaces\GroupInterface;

class GroupController extends Controller 
{
    private $groupInterface;


public function __construct(GroupInterface $groupInterface )
{
     $this->groupInterface = $groupInterface;
}

public function addGroup(Request $request)
{
   return  $this->groupInterface->addGroup($request);
}

  public function updateGroup(Request $request){
      return $this->groupInterface->updateGroup($request);
  }
  public function deleteGroup(Request $request)
  {
    return  $this->groupInterface->deleteGroup($request);
  }

  public function allGroups(){
      return $this->groupInterface->allGroups() ;
  }

  public function specificGroup(Request $request){  
    return $this->groupInterface->specificGroup($request);
    }
}
