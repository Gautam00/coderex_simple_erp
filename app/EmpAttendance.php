<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpAttendance extends Model
{
    protected $fillable = ['user_id', 'present_date'];
}
