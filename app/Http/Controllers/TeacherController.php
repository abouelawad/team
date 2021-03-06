<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\ApiDesignTrait;
use App\Http\Interfaces\TeacherInterface;

class TeacherController extends Controller 
{
    private $teacherInterface;


public function __construct(TeacherInterface $teacherInterface )
{
     $this->teacherInterface = $teacherInterface;
}

public function addTeacher(Request $request)
{
   return  $this->teacherInterface->addTeacher($request);
}

  public function updateTeacher(Request $request){
      return $this->teacherInterface->updateTeacher($request);
  }
  public function deleteTeacher(Request $request)
  {
    return  $this->teacherInterface->deleteTeacher($request);
  }

  public function allTeachers(){
      return $this->teacherInterface->allTeachers() ;
  }

  public function specificTeacher(Request $request){  
    return $this->teacherInterface->specificTeacher($request);
    }
}
