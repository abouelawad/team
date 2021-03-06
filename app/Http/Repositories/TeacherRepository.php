<?php 
namespace App\Http\Repositories;

use App\Models\User;
use App\Models\Role;
use App\Http\Traits\ApiDesignTrait;
use App\Http\Interfaces\TeacherInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherRepository implements TeacherInterface
{
  use ApiDesignTrait;

  private $User;
  private $Role;

  public function __construct(User $User , Role $Role)
  {
     $this->User = $User;
     $this->Role = $Role;
  }


 //* =================== SECTION  addTeacher ===================

  public function addTeacher($request){
   $validation = Validator::make($request->all(),[
   'name'=>'required | min:3',
   'email'=>'required |email | unique:users,email',
   'password'=>'required | min:3',
   ]);

   if($validation->fails())
       {
           return $this->apiResponse(422,'validation Error', $validation->errors());
       }
    
       $teacherRole = $this->Role::where('is_teacher', 1)->first();

      $this->User::create([
      'name'=> $request->name,
      'email'=> $request->email,
      'phone'=> $request->phone,
      'password'=> Hash::make($request->password),
      'role_id'=>$teacherRole->id,
      'status'=> 0
    ]);
   return $this->apiResponse(200, 'new teacher added successfully' , null );
  }

 //* =================== SECTION  updateTeacher ===================

  public function updateTeacher($request){

     $checkTeacher = $this->User::where('id',$request->teacher_id)->whereHas('role' , function($query){
      return $query->where('is_teacher' , 1);
    })->first(); 

// dd($checkTeacher);

    if(! $checkTeacher)
    {
      return $this->apiResponse(422 , 'Can not update this Item' , 'Id is not for a teacher member');
    }

   

// dd($checkTeacher->status);
// dd(request()->all());
    $validation = Validator::make($request->all(),[
      'teacher_id' =>'required |exists:users,id',
      'email' => 'email | unique:users,email,'.$request->teacher_id,
      'status' =>'integer |boolean',    # status value no OK in output
      'name' =>'string',
      'phone' =>'string',
      // 'role_id' =>'exists:roles,id',
    ]);

    // dd($validation->valid());
    // dd($validation->errors());
    if($validation->fails())
    {
      // dd('fails');
      return $this->apiResponse(422 , 'validation Error' , $validation->errors());
    }
    // dd('proceed to update');

    $teacher = $this->User::where('id',$request->teacher_id)->whereHas('role' , function($query){
      return $query->where('is_teacher' , 1);
    })->first(); 

    // dd($teacher);
    if(!$teacher){
      dd('notteacher ');
      return $this->apiResponse(422 , 'Can not update this Item' , 'Id is not for a teacher member');
    }
//! IN CASE OF PARTIAL UPDATE
    $teacherEmail    = $this->User::where('id',$request->teacher_id)->first()->email;
    $teacherName     = $this->User::where('id',$request->teacher_id)->first()->name;
    $teacherPhone    = $this->User::where('id',$request->teacher_id)->first()->phone;
    $teacherStatus   = $this->User::where('id',$request->teacher_id)->first()->status;
    // $teacherRole_id  = $this->User::where('id',$request->teacher_id)->first()->role_id;
// dd($teacherStatus , $request->status );
    $teacher->update([
      'name'=> $request->name ??$teacherName,
      'email'=> $request->email??$teacherEmail,
      'phone'=> $request->phone??$teacherPhone,
      // 'role_id'=> $request->role_id??$teacherRole_id,
      'status'=> $request->status??$teacherStatus
    ]);
    return $this->apiResponse(200 , 'Teacher updated successfully' , null ,$teacher );
  }



 //* =================== SECTION  deleteTeacher ===================

  public function deleteTeacher($request){

    $validation = Validator::make($request->all(),[
      'teacher_id' =>'required |exists:users,id',
    ]);
    
    if($validation->fails())
    {
       return $this->apiResponse(422 , 'validation Error' , $validation->errors());
    }
    
    // dd($this->User::where('id',$request->teacher_id)->first() , $this->User );

    $teacher = $this->User::where('id',$request->teacher_id)->whereHas('role' , function($query){
      return $query->where('is_teacher' , 1);
    })->first(); 

    
    if(!$teacher){
      return $this->apiResponse(422 , 'Can not delete this Item' , 'Id is not for a teacher');
    }

    $teacher->delete();
    return $this->apiResponse(200 , 'Teacher was deleted');
  }

// * SECTION allTeacher

  public function allTeachers(){

    # $teacher = $this->Role::where('is_teacher' , 1)->with('user')->get();
    // dd($teacher);
    // $teacher = $this->User::get();

    $teacher = $this->User::whereHas('role' , Function($query){
      return $query->where('role_id', 2);
    })->with('role')->get();
// dd($teacher);

    return $this->apiResponse(200 , 'all teachers', null , $teacher);

  }

//* =================== SECTION specificTeacher ===================
  public function specificTeacher($request)
  {

    // dd($request->all());
    $validation = Validator::make(request()->all(),[
      
      'teacher_id'=>'required | exists:users,id',
    ]);
    
    if ($validation->fails()) {
      return $this->ApiResponse(422,'validation error', $validation->errors());
    }

    // dd($request->all());
    $teacherMember = $this->User::where('id' , $request->teacher_id )->whereHas('role', function($query){
      return $query->where('is_teacher','1');
    })->with('role')->first();

    if(! $teacherMember){
      return $this->apiResponse(422 , 'Can not select this Item' , 'Id is not for a teacher');
    }

    return $this->apiResponse(200 , 'done', null , $teacherMember);
  }
}