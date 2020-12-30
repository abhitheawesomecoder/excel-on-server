<?php

namespace Modules\Clients\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class AddClientForm extends Form
{
    public function buildForm()
    {   if($this->getData('client_form')){
        	//'attr' => ['class' => 'select2 pmd-select2 form-control'],
        	$this->add('account_number', 'text', ['rules' => 'required']);

        	$this->add('client_name', 'text', ['rules' => 'required']);

        	$this->add('assigned_to', 'select', [
                'choices' => $this->getData('staff'),
                'attr' => ['class' => 'select2 pmd-select2 form-control'],
                'selected' => '1'
            ]);
        }

    	$this->add('first_name', 'text', ['rules' => 'required']);

        $this->add('last_name', 'text', ['rules' => 'required']);

        $this->add('title', 'text', ['rules' => 'required']);

        $this->add('email', 'email', ['rules' => 'required']);

        $this->add('phone_no', 'text', ['rules' => 'required|min:11|numeric']);

        $this->add('address1', 'text', ['rules' => 'required']);

        $this->add('address2', 'text', ['rules' => 'required']);

        $this->add('city', 'text', ['rules' => 'required']);

        $this->add('postcode', 'text', ['rules' => 'required|min:6|numeric']);

        $this->add('submit', 'submit', ['label' => 'Submit','attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']]);

    }
}
