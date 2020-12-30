<?php

namespace Modules\Clients\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class AddStoreForm extends Form
{
    public function buildForm()
    {   
        $this->add('client_id', 'hidden', ['default_value' => $this->getData('client_id')]);

    	$this->add('store_id', 'text', ['rules' => 'required']);

    	$this->add('store_name', 'text', ['rules' => 'required']);
        
        if($this->getData('address_same_fill'))
        $this->add('address_same_as_client', 'checkbox', [
            'value' => 0,
            'checked' => false
        ]);

        $this->add('address1', 'text', ['rules' => 'required']);

        $this->add('address2', 'text', ['rules' => 'required']);

        $this->add('city', 'text', ['rules' => 'required']);

        $this->add('postcode', 'text', ['rules' => 'required|min:6|numeric']);

        $this->add('name', 'text', ['rules' => 'required']);

        $this->add('title', 'text', ['rules' => 'required']);

        $this->add('email', 'email', ['rules' => 'required']);

        $this->add('phone_no', 'text', ['rules' => 'required|min:11|numeric']);

        $this->add('submit', 'submit', ['label' => 'Submit','attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']]);

    }
}
