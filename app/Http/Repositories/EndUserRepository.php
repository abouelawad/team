<?php 
namespace App\Http\Repositories;

use App\Models\User;
use App\Models\Group;
use App\Models\StudentGroup;
use App\Http\Traits\ApiDesignTrait;
use App\Http\Interfaces\EndUserInterface;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class EndUserRepository implements EndUserInterface
{
  use ApiDesignTrait;

  private $User, $StudentGroup;
  private $Group;

  public function __construct(User $User , Group $Group , StudentGroup $StudentGroup)
  {
     $this->User = $User;
     $this->Group = $Group;
     $this->StudentGroup = $StudentGroup;
  }


//  select Student

  public function endUserGroups()
  {
    $userId = auth()->user()->id;
    // dd($userId);
    // dd(
    //   $this->Group::whereHas('studentGroups', function ($query) use ($userId) {
    //     return $query->where('student_id', $userId);
    //   })->get())
    // ;        

    $data = $this->Group::whereHas('studentGroups', function($query) use($userId) {
      return $query->where('student_id', $userId);
    })->withCount('studentGroups')
    ->get();

    return $this->apiResponse(200,'done',null,$data);
  }

}