<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpDetail extends Model
{
    protected $guarded = [
        'id','created_at', 'updated_at'
    ];
}
