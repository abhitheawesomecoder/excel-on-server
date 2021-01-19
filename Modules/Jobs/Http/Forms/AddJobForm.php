<?php

namespace Modules\Jobs\Http\Forms;

use Kris\LaravelFormBuilder\Form;

class AddJobForm extends Form
{
    public function buildForm()
    {   
        $this->add('_todo', 'hidden', ['default_value' => '']);

    	$this->add('excel_job_number', 'text');

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

        $this->add('assigned_to', 'select', [
                'choices' => $this->getData('staff'),
                'attr' => ['class' => 'select2 pmd-select2 form-control'],
                'selected' => '1'
            ]);

        $this->add('priority', 'select', [
            'choices' => ['1' => 'Low', '2' => 'Normal', '3' => 'High', '4' => 'Urgent'],
            'attr' => ['class' => 'select2 pmd-select2 form-control'],
            'selected' => '4'
        ]);

        $this->add('status', 'select', [
            'choices' => ['1' => 'New', '2' => 'Confirmed by contractor', '3' => 'In progress', '4' => 'Waiting for response', '5' => 'Closed'],
            'attr' => ['class' => 'select2 pmd-select2 form-control'],
            'selected' => '1'
        ]);

        $this->add('contractor_id', 'select', [
                'choices' => $this->getData('contractors'),
                'label' => 'Contractor',
                'attr' => ['class' => 'select2 pmd-select2 form-control'],
                'selected' => '1'
            ]);

        $this->add('job_type', 'select', [
            'choices' => ['1' => 'maintenance', '2' => 'minor issue', '3' => 'major issue'],
            'attr' => ['class' => 'select2 pmd-select2 form-control'],
            'selected' => '1'
        ]);

        $this->add('description', 'text', ['label' => ' ']);

        //https://stackoverflow.com/questions/17083229/how-to-change-an-input-element-to-textarea-using-jquery
        if($this->getData('create_form'))
        $this->add('submit', 'submit', ['label' => 'Submit','attr' => ['class' => 'btn btn-primary m-t-15 waves-effect']]);

    }
}
