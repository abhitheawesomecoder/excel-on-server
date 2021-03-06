<?php

namespace Modules\Contractorsignup\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class AddContractorsignupForm extends Form
{
    public function buildForm()
    {   
    	$this->add('email', 'email',['rules' => 'required|email']);

    	$this->add('contractor_identifier', 'text',['rules' => 'required|max:3']);

        $this->add('submit', 'submit', ['label' => 'Submit','attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']]);

    }
}
