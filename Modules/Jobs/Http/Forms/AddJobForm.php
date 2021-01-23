<?php

namespace Modules\Jobs\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class AddJobForm extends Form
{
    public function buildForm()
    {   
        $this->add('_todo', 'hidden', ['default_value' => '']);

        if($this->getData('create_form') == false)
        $this->add('job_number', 'static');

        $this->add('client_order_number', 'text');

    	$this->add('excel_job_number', 'text');

        $this->add('client_id', 'select', [
                'choices' => $this->getData('clients'),
                'attr' => ['class' => 'select2 pmd-select2 form-control'],
                'label' => 'Client Name'
            ]);

        $this->add('store_id', 'select', [
                'choices' => $this->getData('stores'),
                'attr' => ['class' => 'select2 pmd-select2 form-control'],
                'label' => 'Store Name'
            ]);

        $this->add('due_date', 'text', ['attr' => ['class' => 'form-control datepicker']]);

        $this->add('assigned_to', 'select', [
                'choices' => $this->getData('staff'),
                'attr' => ['class' => 'select2 pmd-select2 form-control']
            ]);

        $this->add('priority', 'select', [
            'choices' => ['1' => 'Low', '2' => 'Normal', '3' => 'High', '4' => 'Emergency'],
            'attr' => ['class' => 'select2 pmd-select2 form-control']
        ]);

        $this->add('status', 'select', [
            'choices' => ['1' => 'New', '2' => 'Confirmed by contractor', '3' => 'In progress', '4' => 'Waiting for response', '5' => 'Closed'],
            'attr' => ['class' => 'select2 pmd-select2 form-control']
        ]);

        $this->add('contractor_id', 'select', [
                'choices' => $this->getData('contractors'),
                'label' => 'Contractor',
                'attr' => ['class' => 'select2 pmd-select2 form-control']
            ]);

        $this->add('job_type', 'select', [
            'choices' => $this->getData('job_types'),
            'attr' => ['class' => 'select2 pmd-select2 form-control']
        ]);

        $this->add('description', 'text', ['label' => ' ']);

        $this->add('note', 'textarea',['label' => 'Add note']);

        //https://stackoverflow.com/questions/17083229/how-to-change-an-input-element-to-textarea-using-jquery
        if($this->getData('create_form'))
        $this->add('submit', 'submit', ['label' => 'Submit','attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']]);

    }
}
