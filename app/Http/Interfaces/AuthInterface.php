<?php 
namespace App\Http\Interfaces;

interface AuthInterface
{
  public function login();

  public function addUserTester($request);
  
}