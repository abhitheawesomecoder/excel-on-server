<?php

namespace Modules\Clients\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class ViewStoreForm extends Form
{
    public function buildForm()
    {   
        $this->add('_id', 'hidden', ['default_value' => $this->getData('_id')]);
        
        if($this->getData('store_form')){
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
        }
        if($this->getData('store_edit_form')){
        $this->add('name', 'text', ['rules' => 'required']);

        $this->add('title', 'text', ['rules' => 'required']);

        $this->add('email', 'email', ['rules' => 'required']);

        $this->add('phone_no', 'text', ['rules' => 'required|min:11|numeric']);
        }

    }
}
