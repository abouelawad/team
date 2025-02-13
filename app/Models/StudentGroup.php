<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'group_id',
        'count',
        'price'
    ];
<<<<<<< HEAD

=======
>>>>>>> 3fac0a0b8cd313ab251d3a323528d983508adb76
}
