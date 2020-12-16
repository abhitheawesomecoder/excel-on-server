<?php

namespace Modules\Signup\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class AddUserForm extends Form
{
    public function buildForm()
    {
        $this->add('email', 'email');
    }
}
