<?php

namespace Modules\Signup\Entities;

use Illuminate\Database\Eloquent\Model;

class Signup extends Model
{
    public $table = 'signups';
    const UPDATED_AT = null;
    protected $fillable = [];
}
