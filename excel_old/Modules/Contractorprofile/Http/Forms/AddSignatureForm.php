<?php

namespace Modules\Contractorprofile\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class AddSignatureForm extends Form
{
    public function buildForm()
    {   
        $this->add('_id', 'hidden', ['default_value' => $this->getData('job_id')]);

        $this->add('_signature', 'hidden');

    }
}
