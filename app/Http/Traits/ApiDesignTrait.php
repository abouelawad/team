<?php 

namespace App\Http\Traits;


trait ApiDesignTrait
{

  public function ApiResponse($status = 200,$message = null , $errors = null , $data=null)
  {
    $array = [
      'status' =>$status,
      'message' => $message,
    ];

    if(is_null($errors) && !is_null($data))
    {
      $array['data'] = $data ;
    }
    elseif (!is_null($errors) && is_null($data))
    {
      $array['errors'] = $errors ;
    }
    
    return response( $array , 200 );
  }

}