<?php

namespace Modules\JObs\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class AddJobtypeForm extends Form
{
    public function buildForm()
    {
    	  $this->add('job_type', 'text',['rules' => 'required']);

        $this->add('submit', 'submit', ['label' => 'Submit','attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']]);

    }
}
