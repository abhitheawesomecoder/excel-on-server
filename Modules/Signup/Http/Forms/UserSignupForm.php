<?php

namespace Modules\Signup\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class UserSignupForm extends Form
{
    public function buildForm()
    {   
    	$this->add('signup_token', 'hidden', ['default_value' => $this->getData('token')]);

        $this->add('first_name', 'text', ['rules' => 'required']);

        $this->add('last_name', 'text', ['rules' => 'required']);

        if(1){

        $this->add('Type', 'select', [
            'choices' => ['1' => 'Super Admin', '2' => 'Staff'],
            'selected' => '1'
        ]);

        $this->add('email', 'email', ['rules' => 'required']);
    }

        $this->add('password', 'password', ['rules' => 'required|confirmed|min:8']);

        $this->add('password_confirmation', 'password');

        $this->add('submit', 'submit', ['label' => 'Submit','attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']]);

    }
}
