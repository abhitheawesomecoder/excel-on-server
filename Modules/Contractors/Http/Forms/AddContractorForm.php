<?php

namespace Modules\Contractors\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class AddContractorForm extends Form
{
    public function buildForm()
    {   
        $this->add('signup_token', 'hidden', ['default_value' => $this->getData('token')]);

    	$this->add('company_name', 'text', ['rules' => 'required']);

    	$this->add('contact_name', 'text', ['rules' => 'required']);

    	$this->add('mobile_tel_no', 'text', ['rules' => 'required']);

    	$this->add('main_office_tel_no', 'text', ['rules' => 'required']);

    	$this->add('position', 'text', ['rules' => 'required']);

    	$this->add('password', 'password', ['rules' => 'required|confirmed|min:8']);

    	$this->add('password_confirmation', 'password', ['rules' => 'required']);

    	$this->add('company_address1', 'text', ['rules' => 'required']);

    	$this->add('company_address2', 'text', ['rules' => 'required']);

    	$this->add('company_city', 'text', ['rules' => 'required']);

    	$this->add('company_postcode', 'text', ['rules' => 'required']);

    	$this->add('company_email', 'text', ['rules' => 'required']);

    	$this->add('company_fax_no', 'text', ['rules' => 'required']);

    	$this->add('company_vat_no', 'text', ['rules' => 'required']);

        $this->add('billing_address_same_as_company_address', 'checkbox', [
            'value' => 0,
            'checked' => false
        ]);

    	$this->add('billing_address1', 'text', ['rules' => 'required']);

    	$this->add('billing_address2', 'text', ['rules' => 'required']);

    	$this->add('billing_city', 'text', ['rules' => 'required']);

    	$this->add('billing_postcode', 'text', ['rules' => 'required']);

    	$this->add('bank_ac_name', 'text', ['rules' => 'required']);

    	$this->add('ac_number', 'text', ['rules' => 'required']);

    	$this->add('sort_code', 'text', ['rules' => 'required']);

    	$this->add('company_reg_no', 'text', ['rules' => 'required']);

        $this->add('submit', 'submit', ['label' => 'Submit','attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']]);

    }
}
