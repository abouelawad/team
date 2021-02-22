<?php 
namespace App\Http\Interfaces;
use Illuminate\Http\Request;



interface AuthInterface
{
  public function login();

  public function addUserTester($request);
  
}