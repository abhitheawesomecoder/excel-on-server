<?php

namespace Modules\Jobs\Entities;

use Illuminate\Database\Eloquent\Model;
use Bnb\Laravel\Attachments\HasAttachment;

class Job extends Model
{
	use HasAttachment;

    public $table = 'jobs';

    protected $fillable = [];
}
