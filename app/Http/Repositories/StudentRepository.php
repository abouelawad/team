<?php

namespace App\Http\Repositories;

use App\Models\Role;
use App\Models\User;
<<<<<<< HEAD
use App\Models\Group;
=======
>>>>>>> 3fac0a0b8cd313ab251d3a323528d983508adb76
use App\Models\StudentGroup;
use App\Http\Traits\ApiDesignTrait;
use Illuminate\Support\Facades\Hash;
use App\Http\Interfaces\StudentInterface;
use Illuminate\Support\Facades\Validator;

class StudentRepository implements StudentInterface
{
  use ApiDesignTrait;

  private $User;
  private $Role;
  private $StudentGroup;

  public function __construct(User $User, Role $Role , StudentGroup $StudentGroup)
  {
    $this->User = $User;
    $this->Role = $Role;
    $this->StudentGroup = $StudentGroup;
  }


<<<<<<< HEAD

//* =================== FUNCTION  addStudent with group array ===================

=======
//* =================== first  FUNCTION  addStudent ===================

  // public function addStudent($request)
  // {
  //   $validation = Validator::make($request->all(), [
  //     'name' => 'required | min:3',
  //     'email' => 'required |email | unique:users,email',
  //     'password' => 'required | min:3',
  //   ]);

  //   if ($validation->fails()) {
  //     return $this->apiResponse(422, 'validation Error', $validation->errors());
  //   }

  //   $studentRole = $this->Role::where([['is_staff', '0'], ['is_teacher', '0']])->first()->id;

  //   $this->User::create([
  //     'name' => $request->name,
  //     'email' => $request->email,
  //     'phone' => $request->phone,
  //     'password' => Hash::make($request->password),
  //     'role_id' => $studentRole,
  //     'status' => 0
  //   ]);
  //   return $this->apiResponse(200, 'new student added successfully', null);
  // }

//* =================== firstEND FUNCTION  addStudent ===================

  //* =================== FUNCTION  addStudent with group ===================

>>>>>>> 3fac0a0b8cd313ab251d3a323528d983508adb76
  public function addStudent($request)
  {
    $validation = Validator::make($request->all(), [
      'name' => 'required | min:3',
<<<<<<< HEAD
      'email' => 'required |email | unique:users,email,column',
      'password' => 'required | min:3',
      'groups.*'=> 'required '
    ]);


  if ($validation->fails()) {
    return $this->apiResponse(422, 'validation Error', $validation->errors());
  }
  
  $groups = $request->groups;
  $groupCount=count($groups);
  
  // dd($groups);
  foreach ($groups as $group) {
    //check formatting of group
      if (count($group) != 3) {
        return $this->apiResponse(422, 'group data is missing');
      }
    // check existing of the group in database
      $checkGroup = Group::find($group[0]);
      if (! $checkGroup) {
        return $this->apiResponse(422, 'group is not exist');
      }
      
  }  


    for ($i=0; $i < $groupCount-1; $i++) {
      $array[] = ($groups[$i][0]);

      // NOTE $i+1 start count from index 1 (the second item) to compare 
      if (in_array($groups[$i + 1][0], $array)) {
        return $this->apiResponse(422, 'group is repeated' );
      } 
    }

  $studentRole = $this->Role::where([['is_staff', '0'], ['is_teacher', '0']])->first();
  
  if(! $studentRole){
    return $this->apiResponse(422,'Can not Assign this member', 'Id is not for a student check database');
  }

  $student = $this->User::create([
    'name' => $request->name,
    'email' => $request->email,
    'phone' => $request->phone,
    'password' => Hash::make($request->password),
    'role_id' => $studentRole->id,
    'status' => 0
  ]);

  
  foreach($groups as $group)
  {

      $this->StudentGroup::create([
      'group_id'    => $group[0],
      'student_id'  =>$student->id,
      'count'       => $group[1],
      'price'       => $group[2]
        ]);
  }

      return $this->apiResponse(200, 'new student added successfully' , null , $student);
}

//* ===================  END FUNCTION  addStudent with group (array) ===================

//* =================== FUNCTION  updateStudent ===================
  public function updateStudent($request)
  {
    //? VALIDATION

    $validation = Validator::make($request->all(), [
      'name' => ' min:3',
      'email' => 'email | unique:users,email,' . $request->student_id,
      'password' => ' min:3',
    ]);

    if ($validation->fails()) {
      return $this->apiResponse(422, 'validation Error', $validation->errors());
    }

    //? Check Student existence

=======
      'email' => 'required |email | unique:users,email',
      'password' => 'required | min:3',
    ]);



    if ($validation->fails()) {
      return $this->apiResponse(422, 'validation Error', $validation->errors());
    }

    if (! $request->has('groups')) {
     
      return $this->apiResponse(422, 'No Groups Found You need To Join At Least one Group');
    }

    $studentRole = $this->Role::where([['is_staff', '0'], ['is_teacher', '0']])->first()->id;

    $student = $this->User::create([
      'name' => $request->name,
      'email' => $request->email,
      'phone' => $request->phone,
      'password' => Hash::make($request->password),
      'role_id' => $studentRole,
      'status' => 0
    ]);



      foreach ($request->groups as $group){
        $requestedGroup = explode(",", $group);

        $this->StudentGroup::create([
          'student_id'=> $student->id,
          'group_id' => $requestedGroup[0],
          'count' => $requestedGroup[1],
          'price' => $requestedGroup[2]
        ]);
      }



    return $this->apiResponse(200, 'new student added successfully', null);
  }

  //* ===================  END FUNCTION  addStudent ===================
// // =================== OLD FUNCTION  updateStudent ===================
  // public function updateStudent($request)
  // {

  //   //? VAlidation

  //   $validation = Validator::make($request->all(), [
  //     'name' => ' min:3',
  //     'email' => 'email | unique:users,email,' . $request->student_id,
  //     'password' => ' min:3',
  //   ]);

  //   if ($validation->fails()) {
  //     return $this->apiResponse(422, 'validation Error', $validation->errors());
  //   }

  //   //? Check Student existence

  //   $student = $this->User::where('id', $request->student_id)->whereHas('role', function ($query) {
  //     return $query->where([['is_staff', '0'], ['is_teacher', '0']]);
  //   })->first();

  //   if (!$student) {
  //     return $this->apiResponse(422, 'Can not update this Item', 'Id is not for a teacher member');
  //   }

  //   //! IN CASE OF PARTIAL UPDATE
  //   $studentEmail    = $this->User::where('id', $request->student_id)->first()->email;
  //   $studentName     = $this->User::where('id', $request->student_id)->first()->name;
  //   $studentPhone    = $this->User::where('id', $request->student_id)->first()->phone;
  //   $studentStatus   = $this->User::where('id', $request->student_id)->first()->status;

  //   $student->update([
  //     'name' => $request->name ?? $studentEmail,
  //     'email' => $request->email ?? $studentName,
  //     'phone' => $request->phone ?? $studentPhone,
     // 'role_id'=> $request->role_id??$teacherRole_id,
  //     'status' => $request->status ?? $studentStatus
  //   ]);
  //   return $this->apiResponse(200, 'Student updated successfully', null, $student);
  // }
// // =================== OLD END FUNCTION  updateStudent ===================
  //* =================== FUNCTION  updateStudent ===================
  public function updateStudent($request)
  {

    //? VALIDATION

    $validation = Validator::make($request->all(), [
      'name' => ' min:3',
      'email' => 'email | unique:users,email,' . $request->student_id,
      'password' => ' min:3',
    ]);

    if ($validation->fails()) {
      // dd('fails');
      return $this->apiResponse(422, 'validation Error', $validation->errors());
    }

    //? Check Student existence

>>>>>>> 3fac0a0b8cd313ab251d3a323528d983508adb76
    $student = $this->User::where('id', $request->student_id)->whereHas('role', function ($query) {
      return $query->where([['is_staff', '0'], ['is_teacher', '0']]);
    })->first();

    if (!$student) {
      return $this->apiResponse(422, 'Can not update this Item', 'Id is not for a student');
    }

    //! IN CASE OF PARTIAL UPDATE
    $studentEmail    = $this->User::where('id', $request->student_id)->first()->email;
    $studentName     = $this->User::where('id', $request->student_id)->first()->name;
    $studentPhone    = $this->User::where('id', $request->student_id)->first()->phone;
    $studentStatus   = $this->User::where('id', $request->student_id)->first()->status;

    $student->update([
      'name' => $request->name ?? $studentEmail,
      'email' => $request->email ?? $studentName,
      'phone' => $request->phone ?? $studentPhone,
      'status' => $request->status ?? $studentStatus
    ]);

    if ($request->has('groups')) {
      foreach ($request->groups as $group) {
        $requestedGroup = explode(",", $group);

        $this->StudentGroup::create([
          'student_id' => $student->id,
          'group_id' => $requestedGroup[0],
          'count' => $requestedGroup[1],
          'price' => $requestedGroup[2]
        ]);
      }
      
    }
<<<<<<< HEAD

    return $this->apiResponse(200, 'Student updated successfully', null, $student);
  }
  //* ===================END FUNCTION  updateStudent ===================

  //* =================== FUNCTION  deleteStudent ===================

  public function deleteStudent($request)
  {

    $validation = Validator::make($request->all(), [
      'student_id' => 'required |exists:users,id',
    ]);

    if ($validation->fails()) {
      return $this->apiResponse(422, 'validation Error', $validation->errors());
    }



    $student = $this->User::where('id', $request->student_id)->whereHas('role', function ($query) {
      return $query->where([['is_staff', '0'], ['is_teacher', '0']]);
    })->first();

=======

    return $this->apiResponse(200, 'Student updated successfully', null, $student);
  }
  //* ===================END FUNCTION  updateStudent ===================

  //* =================== FUNCTION  deleteStudent ===================

  public function deleteStudent($request)
  {

    $validation = Validator::make($request->all(), [
      'student_id' => 'required |exists:users,id',
    ]);

    if ($validation->fails()) {
      return $this->apiResponse(422, 'validation Error', $validation->errors());
    }

    // dd($this->User::where('id',$request->teacher_id)->first() , $this->User );

    $student = $this->User::where('id', $request->student_id)->whereHas('role', function ($query) {
      return $query->where([['is_staff', '0'], ['is_teacher', '0']]);
    })->first();

>>>>>>> 3fac0a0b8cd313ab251d3a323528d983508adb76

    if (!$student) {
      return $this->apiResponse(422, 'Can not delete this Item', 'Id is not for a student');
    }

    $student->delete();
    return $this->apiResponse(200, 'Student was deleted');
  }
  //* ===================END FUNCTION  deleteStudent ===================

  //* =================== FUNCTION  allStudents ===================

  public function allStudents()
  {

<<<<<<< HEAD
=======


>>>>>>> 3fac0a0b8cd313ab251d3a323528d983508adb76
    $students = $this->User::whereHas('role', function ($query) {
      return $query->where([['is_staff', '0'], ['is_teacher', 0]]);
    })->withCount('studentGroups')->get();

<<<<<<< HEAD
    return $this->apiResponse(200, 'all students', null, $students);
=======
    return $this->apiResponse(200, 'all teachers', null, $students);
>>>>>>> 3fac0a0b8cd313ab251d3a323528d983508adb76
  }

  //* ===================END FUNCTION allStudents ===================

  //* =================== FUNCTION specificStudent ===================
  public function specificStudent($request)
  {

    $validation = Validator::make(request()->all(), [

      'student_id' => 'required | exists:users,id',
    ]);

    if ($validation->fails()) {
      return $this->ApiResponse(422, 'validation error', $validation->errors());
    }

    // dd($request->all());
    $student = $this->User::where('id', $request->student_id)->whereHas('role', function ($query) {
      return $query->where([['is_staff', '0'], ['is_teacher', 0]]);
    })->with('role')->first();

    if (!$student) {
      return $this->apiResponse(422, 'Can not select this Item', 'Id is not for a student');
    }

    return $this->apiResponse(200, 'done', null, $student);
  }
<<<<<<< HEAD
//* ===================END FUNCTION specificStudent ================

//* =================== FUNCTION updateStudentGroup ===================
=======
  //* ===================END FUNCTION specificStudent ================

  //* =================== FUNCTION updateStudentGroup ===================
>>>>>>> 3fac0a0b8cd313ab251d3a323528d983508adb76
  public function updateStudentGroup($request)
  {
  }

<<<<<<< HEAD
//* =================== END FUNCTION updateStudentGroup ===================

//* =================== FUNCTION deleteStudentGroup ===================
=======
  //* =================== END FUNCTION updateStudentGroup ===================

  //* =================== FUNCTION deleteStudentGroup ===================
>>>>>>> 3fac0a0b8cd313ab251d3a323528d983508adb76
  public function deleteStudentGroup($request)
  {
  }

  //* ===================END FUNCTION deleteStudentGroup ===================
}
