<?php

namespace Modules\Jobs\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class AddJobForm extends Form
{
    public function buildForm()
    {   
    	$this->add('excel_job_number', 'text', ['rules' => 'required']);

        $this->add('client_id', 'select', [
                'choices' => $this->getData('clients'),
                'attr' => ['class' => 'select2 pmd-select2 form-control'],
                'selected' => '1', 'label' => 'Client Name'
            ]);

        $this->add('store_id', 'select', [
                'choices' => $this->getData('stores'),
                'attr' => ['class' => 'select2 pmd-select2 form-control'],
                'selected' => '1', 'label' => 'Store Name'
            ]);

        $this->add('due_date', 'text', ['attr' => ['class' => 'form-control datepicker']]);

        //https://github.com/kristijanhusak/laravel-form-builder/issues/41 also check bapcrm
        
        $this->add('submit', 'submit', ['label' => 'Submit','attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']]);

    }
}
