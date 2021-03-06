<?php 
namespace App\Http\Interfaces;

interface StudentInterface
{
  public function addStudent($request);
  public function updateStudent($request);
  public function deleteStudent($request);
  public function allStudents();
  public function specificStudent($request);
  
}