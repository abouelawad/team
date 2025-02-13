<?php

namespace App\Models;

use App\Models\StudentGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;
    protected $fillable = [ 'name',
                            'body',
                            'image',
                            'teacher_id' ,
                            'created_by'];

protected $hidden = ['created_at','updated_at'];

    public function studentGroups(){
        
        return $this->hasMany(StudentGroup::class ,'group_id','id');
    }
}


