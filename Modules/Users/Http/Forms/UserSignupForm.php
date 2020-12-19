<?php

namespace Modules\Signup\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class UserSignupForm extends Form
{
    public function buildForm()
    {
        $this->add('first_name', 'text', ['rules' => 'required']);

        $this->add('last_name', 'text', ['rules' => 'required']);

        $this->add('password', 'password', ['rules' => 'required|confirmed|min:8']);

        $this->add('password_confirmation', 'password');

        $this->add('submit', 'submit', ['label' => 'Submit']);

    }
}
