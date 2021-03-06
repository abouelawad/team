<?php 
namespace App\Http\Repositories;

use App\Models\User;
use App\Models\Role;
use App\Http\Traits\ApiDesignTrait;
use App\Http\Interfaces\StudentInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentRepository implements StudentInterface
{
  use ApiDesignTrait;

  private $User;
  private $Role;

  public function __construct(User $User , Role $Role)
  {
     $this->User = $User;
     $this->Role = $Role;
  }


//* =================== FUNCTION  addStudent ===================

  public function addStudent($request){
   $validation = Validator::make($request->all(),[
   'name'=>'required | min:3',
   'email'=>'required |email | unique:users,email',
   'password'=>'required | min:3',
   ]);

   if($validation->fails())
       {
           return $this->apiResponse(422,'validation Error', $validation->errors());
       }
    
       $studentRole = $this->Role::where([['is_staff', '0'],['is_teacher','0']])->first()->id;

      $this->User::create([
      'name'=> $request->name,
      'email'=> $request->email,
      'phone'=> $request->phone,
      'password'=> Hash::make($request->password),
      'role_id'=>$studentRole,
      'status'=> 0
    ]);
   return $this->apiResponse(200, 'new student added successfully' , null );
  }

//* ===================END FUNCTION  addStudent ===================

//* =================== FUNCTION  updateStudent ===================

  public function updateStudent($request){

  //? VAlidation

  $validation = Validator::make($request->all(),[
    'name'=>' min:3',
  'email'=>'email | unique:users,email,'.$request->student_id,
  'password'=>' min:3',
  ]);

  if($validation->fails())
  {
    // dd('fails');
    return $this->apiResponse(422 , 'validation Error' , $validation->errors());
  }
  //? Check Student existence

  $student = $this->User::where('id',$request->student_id)->whereHas('role' , function($query){
  return $query->where([['is_staff', '0'],['is_teacher','0']]);
  })->first(); 



  if(! $student)
  {
    return $this->apiResponse(422 , 'Can not update this Item' , 'Id is not for a teacher member');
  }

  //! IN CASE OF PARTIAL UPDATE
    $studentEmail    = $this->User::where('id',$request->student_id)->first()->email;
    $studentName     = $this->User::where('id',$request->student_id)->first()->name;
    $studentPhone    = $this->User::where('id',$request->student_id)->first()->phone;
    $studentStatus   = $this->User::where('id',$request->student_id)->first()->status;

    $student->update([
      'name'=> $request->name ??$studentEmail,
      'email'=> $request->email??$studentName,
      'phone'=> $request->phone??$studentPhone,
      // 'role_id'=> $request->role_id??$teacherRole_id,
      'status'=> $request->status??$studentStatus
    ]);
    return $this->apiResponse(200 , 'Student updated successfully' , null ,$student );
  }



//* ===================END FUNCTION  updateStudent ===================

//* =================== FUNCTION  deleteStudent ===================

  public function deleteStudent($request){

    $validation = Validator::make($request->all(),[
      'student_id' =>'required |exists:users,id',
    ]);
    
    if($validation->fails())
    {
       return $this->apiResponse(422 , 'validation Error' , $validation->errors());
    }
    
    // dd($this->User::where('id',$request->teacher_id)->first() , $this->User );

    $student = $this->User::where('id',$request->student_id)->whereHas('role' , function($query){
      return $query->where([['is_staff', '0'],['is_teacher','0']]);
      })->first(); 

    
    if(!$student){
      return $this->apiResponse(422 , 'Can not delete this Item' , 'Id is not for a student');
    }

    $student->delete();
    return $this->apiResponse(200 , 'Student was deleted');
  }
//* ===================END FUNCTION  deleteStudent ===================

//* =================== FUNCTION  allStudents ===================

  public function allStudents(){

  

    $students = $this->User::whereHas('role' , Function($query){
      return $query->where([['is_staff', '0'],['is_teacher',0]]);
    })->get();

    return $this->apiResponse(200 , 'all teachers', null , $students);

  }

//* ===================END FUNCTION allStudents ===================

//* =================== FUNCTION specificStudent ===================
  public function specificStudent($request)
  {

    $validation = Validator::make(request()->all(),[
      
      'student_id'=>'required | exists:users,id',
    ]);
    
    if ($validation->fails()) {
      return $this->ApiResponse(422,'validation error', $validation->errors());
    }

    // dd($request->all());
    $student = $this->User::where('id' , $request->student_id )->whereHas('role', function($query){
      return $query->where([['is_staff', '0'],['is_teacher',0]]);
    })->with('role')->first();

    if(! $student){
      return $this->apiResponse(422 , 'Can not select this Item' , 'Id is not for a student');
    }

    return $this->apiResponse(200 , 'done', null , $student);
  }
//* ===================END FUNCTION specificStudent ===================

}