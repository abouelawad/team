<?php 
namespace App\Http\Repositories;

use App\Models\User;
use App\Http\Traits\ApiDesignTrait;
use App\Http\Interfaces\StaffInterface;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StaffRepository implements StaffInterface
{
  use ApiDesignTrait;

  private $User;
  private $Role;

  public function __construct(User $User , Role $Role)
  {
     $this->User = $User;
     $this->Role = $Role;
  }

 //* =================== SECTION  addStaff ===================

  public function addStaff($request){
    
   $validation = Validator::make($request->all(),[
   'name'=>'required | min:3',
   'email'=>'required |email | unique:users,email',
   'password'=>'required | min:3',
   'role_id' =>'required |exists:roles,id',
   ]);

   if($validation->fails())
       {
           return $this->apiResponse(422,'validation Error', $validation->errors());
       }
    
      $this->User::create([
      'name'=> $request->name,
      'email'=> $request->email,
      'phone'=> $request->phone,
      'password'=> Hash::make($request->password),
      'role_id'=> $request->role_id,
      'status'=> 0
    ]);
   return $this->apiResponse(200, 'new staff added successfully' , null );
  }

 //* =================== SECTION  updateStaff ===================

  public function updateStaff($request){

     $checkStaff = $this->User::where('id',$request->staff_id)->whereHas('role' , function($query){
      return $query->where('is_staff' , 'staff');
    })->first(); 

// dd($checkStaff);

    if(! $checkStaff)
    {
      return $this->apiResponse(422 , 'Can not update this Item' , 'Id is not for a staff member');
    }

   

// dd($checkStaff->status);
// dd(request()->all());
    $validation = Validator::make($request->all(),[
      'staff_id' =>'required |exists:users,id',
      'email' => 'email | unique:users,email,'.$request->staff_id,
      'status' =>'integer |boolean',    # status value no OK in output
      'name' =>'string',
      'phone' =>'string',
      'role_id' =>'exists:roles,id',
    ]);

    // dd($validation->valid());
    // dd($validation->errors());
    if($validation->fails())
    {
      // dd('fails');
      return $this->apiResponse(422 , 'validation Error' , $validation->errors());
    }
    // dd('proceed to update');

    $staff = $this->User::where('id',$request->staff_id)->whereHas('role' , function($query){
      return $query->where('is_staff' , 'staff');
    })->first(); 

    // dd($staff);
    if(!$staff){
      dd('notstaff ');
      return $this->apiResponse(422 , 'Can not update this Item' , 'Id is not for a staff member');
    }
//! IN CASE OF PARTIAL UPDATE
    $staffEmail    = $this->User::where('id',$request->staff_id)->first()->email;
    $staffName     = $this->User::where('id',$request->staff_id)->first()->name;
    $staffPhone    = $this->User::where('id',$request->staff_id)->first()->phone;
    $staffStatus   = $this->User::where('id',$request->staff_id)->first()->status;
    $staffRole_id  = $this->User::where('id',$request->staff_id)->first()->role_id;

// dd($staffStatus , $request->status );

    $staff->update([
      'name'=> $request->name ??$staffName,
      'email'=> $request->email??$staffEmail,
      'phone'=> $request->phone??$staffPhone,
      'role_id'=> $request->role_id??$staffRole_id,
      'status'=> $request->status??$staffStatus
    ]);
    return $this->apiResponse(200 , 'Staff updated successfully' , null ,$staff );
  }



 //* =================== SECTION  deleteStaff ===================

  public function deleteStaff($request){
    $validation = Validator::make($request->all(),[
      'staff_id' =>'required |exists:users,id',
    ]);
    
    if($validation->fails())
    {
       return $this->apiResponse(422 , 'validation Error' , $validation->errors());
    }
    
    // dd($this->User::where('id',$request->staff_id)->first() , $this->User );

    $staff = $this->User::where('id',$request->staff_id)->whereHas('role' , function($query){
      return $query->where('is_staff' , 'staff');
    })->first(); 

    
    if(!$staff){
      return $this->apiResponse(422 , 'Can not delete this Item' , 'Id is not for a staff');
    }

    $staff->delete();
    return $this->apiResponse(200 , 'Staff was deleted');
  }

//* =================== SECTION allStaff ===================

  public function allStaff(){
      $roles = ['admin', 'secretary' , 'support'];
    # $staff = $this->Role::where('is_staff' , 'staff')->with('user')->get();
    // dd($staff);
    // $staff = $this->User::get();

    $staff = $this->User::whereHas('role' , Function($query){
      return $query->where('is_staff', 'staff');
    })->with('role')->get();
// dd($staff);


    return $this->apiResponse(200 , 'all stuff', null , $staff);

  }

//* =================== SECTION specificStaff ===================

  public function specificStaff($request)
  {
    // dd($request->all());
    $validation = Validator::make(request()->all(),[
      
      'staff_id'=>'required | exists:users,id',
    ]);
    
    if ($validation->fails()) {
      return $this->ApiResponse(422,'validation error', $validation->errors());
    }

    // dd($request->all());
    $staffMember = $this->User::where('id' , $request->staff_id )->whereHas('role', function($query){
      return $query->where('is_staff','staff');
    })->with('role')->first();
    
    if(! $staffMember){
      return $this->apiResponse(422 , 'Can not select this Item' , 'Id is not for a staff');
    }
    return $this->apiResponse(200 , 'done', null , $staffMember);
  }


}