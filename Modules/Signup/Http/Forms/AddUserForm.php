<?php

namespace Modules\Signup\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class AddUserForm extends Form
{
    public function buildForm()
    {
        $this->add('email', 'email');

        $this->add('User type', 'select', [
            'choices' => ['1' => 'Super Admin', '2' => 'Staff', '3' => 'Contractor'],
            'selected' => '1',
            'empty_value' => '=== Select type ==='
        ]);

        $this->add('submit', 'submit', ['label' => 'Send']);
    }
}
