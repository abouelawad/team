<?php 
namespace App\Http\Repositories;

use App\Models\Role;
use App\Models\User;
use App\Models\Group;
use App\Http\Traits\ApiDesignTrait;
use App\Http\Interfaces\GroupInterface;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class GroupRepository implements GroupInterface
{
  use ApiDesignTrait;

  private $User;
  private $Group;

  public function __construct(User $User , Group $Group)
  {
     $this->User = $User;
     $this->Group = $Group;
  }


 //* =================== Function addGroup ===================

  public function addGroup($request){
   $validation = Validator::make($request->all(),[
   'name'=>'required | min:3',
   'body'=>'required ',
   'image'=>'required ',
   'teacher_id'=>'required | exists:users,id',
 
   ]);

   if($validation->fails())
       {
           return $this->apiResponse(422,'validation Error', $validation->errors());
       }

       $teacher = $this->User->where('id', $request->teacher_id)->whereHas('role' , function($query){
         return $query->where([['is_staff','0'], ['is_teacher' , 1]]);
       })->first();

       if(!$teacher){
      return $this->apiResponse(422,'Can not Assign this member', 'Id is not for a teacher ');
       };


   if(!auth()->user()){
      return $this->apiResponse(422, 'login message', 'please login first');
   }
    
      $this->Group::create([
      'name'=> $request->name,
      'body'=> $request->body,
      'image'=> $request->image,
      'teacher_id'=> $request->teacher_id,
      'created_by'=>auth()->user()->id,
    ]);

   return $this->apiResponse(200, 'new group added successfully' , null );
  }

//* ===================END Function addGroup ===================
//* =================== Function updateGroup ===================

  public function updateGroup($request){


    $validation = Validator::make($request->all(),[
    'group_id'=>'required | exists:groups,id'
    ]);

    
    if($validation->fails())
    {
      return $this->apiResponse(422 , 'validation Error' , $validation->errors());
    }
    

    $group = $this->Group::find($request->group_id); 

    if(!$group){

      return $this->apiResponse(422 , 'Can not update this Item' , 'Id is not for group');
    }

//! IN CASE OF PARTIAL UPDATE
    $groupName        = $this->Group::where('id',$request->group_id)->first()->name;
    $groupBody        = $this->Group::where('id',$request->group_id)->first()->body;
    $groupImage       = $this->Group::where('id',$request->group_id)->first()->image;
    $groupTeacher_id  = $this->Group::where('id',$request->group_id)->first()->teacher_id;

    $group->update([
      'name'=> $request->name ??$groupName,
      'body'=> $request->body??$groupBody,
      'image'=> $request->image??$groupImage,
      'teacher_id'=> $request->teacher_id??$groupTeacher_id,
      'created_by'=> auth()->user()->id,
    ]);
    return $this->apiResponse(200 , 'Group updated successfully' , null ,$group );
  }


//* ===================END Function  updateGroup ===================
//* =================== Function  deleteGroup ===================

  public function deleteGroup($request){

    $validation = Validator::make($request->all(),[
      'group_id' =>'required |exists:groups,id',
    ]);
    
    if($validation->fails())
    {
       return $this->apiResponse(422 , 'validation Error' , $validation->errors());
    }
    

    $group = $this->Group::find($request->group_id); 

    
    if(! $group){
      return $this->apiResponse(422 , 'Can not delete this Item' , 'Id is not for a group');
    }

    $group->delete();
    return $this->apiResponse(200 , 'Group was deleted');
  }

//* ===================End Function deleteGroup =================== 
//* =================== Function allGroups ===================

  public function allGroups(){



    $groups = $this->Group::get();

    return $this->apiResponse(200 , 'all Groups', null , $groups);
 
  }
//* ===================END Function allGroups ===================
//* =================== Function specificGroup ===================
  public function specificGroup($request)
  {

    $validation = Validator::make(request()->all(),[
      
      'group_id'=>'required | exists:groups,id',
    ]);
    
    if ($validation->fails()) {
      return $this->ApiResponse(422,'validation error', $validation->errors());
    }

    $group = $this->Group::find($request->group_id );

    if(! $group){
      return $this->apiResponse(422 , 'Can not select this Item' , 'Id is not for a group');
    }

    return $this->apiResponse(200 , 'done', null , $group);
  }
//* =================== END Function specificGroup ===================

}