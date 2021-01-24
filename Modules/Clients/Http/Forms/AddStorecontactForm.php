<?php

namespace Modules\Clients\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class AddStorecontactForm extends Form
{
    public function buildForm()
    {   
        $this->add('name', 'text', ['rules' => 'required']);

        $this->add('title', 'text', ['rules' => 'required']);

        $this->add('email', 'email', ['rules' => 'required']);

        $this->add('phone_no', 'text', ['rules' => 'required|min:11|numeric']);
        
        $this->add('submit', 'submit', ['label' => 'Submit','attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']]);

    }
}
