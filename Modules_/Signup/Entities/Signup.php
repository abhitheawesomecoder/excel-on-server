<?php

namespace Modules\Signup\Entities;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Factories\HasFactory;

class Signup extends Model
{
    //use HasFactory;

    public $table = 'signups';

    //protected $fillable = ['email','token','role_id']; 5.1
    protected $fillable = [];

    /*protected static function newFactory()
    {
        //return \Modules\Signup\Database\factories\SignupFactory::new();
    }*/
}
