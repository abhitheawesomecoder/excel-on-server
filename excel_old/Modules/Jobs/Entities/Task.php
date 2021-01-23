<?php

namespace Modules\Jobs\Entities;

use Illuminate\Database\Eloquent\Model;
use Bnb\Laravel\Attachments\HasAttachment;

class Task extends Model
{
	use HasAttachment;

    public $table = 'tasks';

    protected $fillable = [];
}
