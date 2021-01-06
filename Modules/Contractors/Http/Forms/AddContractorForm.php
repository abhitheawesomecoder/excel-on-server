<?php

namespace Modules\Contractors\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class AddContractorForm extends Form
{
    public function buildForm()
    {   
    	$this->add('company_name', 'text', ['rules' => 'required']);

    	$this->add('contact_name', 'text', ['rules' => 'required']);

    	$this->add('mobile_tel_no', 'text', ['rules' => 'required']);

    	$this->add('main_office_tel_no', 'text', ['rules' => 'required']);

    	$this->add('position', 'text', ['rules' => 'required']);

    	$this->add('email', 'text', ['rules' => 'required']);

    	$this->add('password', 'text', ['rules' => 'required']);

    	$this->add('password_confirmation', 'text', ['rules' => 'required']);

        $this->add('submit', 'submit', ['label' => 'Submit','attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']]);

    }
}
