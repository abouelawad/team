<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Interfaces\StudentInterface;

class StudentController extends Controller 
{
    private $studentInterface;


public function __construct(StudentInterface $studentInterface )
{
     $this->studentInterface = $studentInterface;
}

public function addStudent(Request $request)
{
   return  $this->studentInterface->addStudent($request);
}

  public function updateStudent(Request $request){
      return $this->studentInterface->updateStudent($request);
  }
  public function deleteStudent(Request $request)
  {
    return  $this->studentInterface->deleteStudent($request);
  }

  public function allStudents(){
      return $this->studentInterface->allStudents() ;
  }

  public function specificStudent(Request $request){  
    return $this->studentInterface->specificStudent($request);
    }
}
