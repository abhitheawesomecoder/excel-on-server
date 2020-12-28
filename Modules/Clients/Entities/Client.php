<?php

namespace Modules\Clients\Entities;

use Illuminate\Database\Eloquent\Model;
use Bnb\Laravel\Attachments\HasAttachment;

class Client extends Model
{
	use HasAttachment;

    public $table = 'clients';

    protected $fillable = [];
}
