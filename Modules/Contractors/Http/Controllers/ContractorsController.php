<?php

namespace Modules\Contractors\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Kris\LaravelFormBuilder\FormBuilder;
use Modules\Jobs\DataTables\JobOnlyDataTable;
use Modules\Contractors\Entities\Contractor;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Contractors\Http\Forms\AddContractorForm;
use Modules\Contractors\DataTables\ContractorDataTable;

class ContractorsController extends Controller
{
    use FormBuilderTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(ContractorDataTable $dataTable)
    {
        //return view('contractors::index');
        return $dataTable->render('signup::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {   
        $title  = 'core.contractor.create.title';
        $subtitle = 'core.contractor.create.subtitle';
        $form = $formBuilder->create(AddContractorForm::class, [
            'method' => 'POST',
            'url' => route('contractors.store'),
            'id' => 'module_form'
        ],['create_form' => true]);

        return view('contractors::create', compact('form'))
               ->with('show_fields', $this->showFields)
               ->with(compact('title','subtitle'))
               ->with('appjs',true);
    }
    public function signup($token){

    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id, FormBuilder $formBuilder, JobOnlyDataTable $tableObj)
    {//http://localhost/excel/public/contractors/1
        if (request()->ajax()) {
            return $tableObj->with('contractor_id', $id)->render('core::datatable');
        }
        $contractor = Contractor::find($id);
        $title  = 'core.contractor.view.title';
        $subtitle = 'core.contractor.view.subtitle';
        $form = $formBuilder->create(AddContractorForm::class, [
            'method' => 'PATCH',
            'url' => route('contractors.update',$id),
            'id' => 'module_form',
            'model' => $contractor,
        ],['create_form' => false]);
        unset($this->showFields['basic_information']['password']);
        unset($this->showFields['basic_information']['password_confirmation']);
        unset($this->showFields['company_address']['billing_address_same_as_company_address']);

        $dataTable = $tableObj->html();
        
        return view('contractors::edit', compact('form'))
               ->with('show_fields', $this->showFields)
               ->with(compact('dataTable'))
               ->with(compact('title','subtitle','id'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id, FormBuilder $formBuilder, JobOnlyDataTable $tableObj)
    {   if (request()->ajax()) {
            return $tableObj->with('contractor_id', $id)->render('core::datatable');
        }
        $contractor = Contractor::find($id);
        $title  = 'core.contractor.edit.title';
        $subtitle = 'core.contractor.edit.subtitle';
        $form = $formBuilder->create(AddContractorForm::class, [
            'method' => 'PATCH',
            'url' => route('contractors.update',$contractor->id),
            'id' => 'module_form',
            'model' => $contractor,
        ],['create_form' => false,'edit_form' => true]);
        unset($this->showFields['basic_information']['password']);
        unset($this->showFields['basic_information']['password_confirmation']);
        unset($this->showFields['company_address']['billing_address_same_as_company_address']);

        $dataTable = $tableObj->html();
        
        return view('contractors::edit', compact('form'))
                ->with('show_fields', $this->showFields)
                ->with(compact('dataTable'))
                ->with(compact('title','subtitle','id'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $newContractor = Contractor::find($id);

        $newContractor->company_name = $request->company_name;
        $newContractor->contact_name = $request->contact_name;
        $newContractor->mobile_tel_no = $request->mobile_tel_no;
        $newContractor->main_office_tel_no = $request->main_office_tel_no;
        $newContractor->position = $request->position;
        $newContractor->company_address1 = $request->company_address1;
        $newContractor->company_address2 = $request->company_address2;
        $newContractor->company_city = $request->company_city;
        $newContractor->company_postcode = $request->company_postcode;
        $newContractor->company_email = $request->company_email;
        $newContractor->company_fax_no = $request->company_fax_no;
        $newContractor->company_vat_no = $request->company_vat_no;
        $newContractor->billing_address1 = $request->billing_address1;
        $newContractor->billing_address2 = $request->billing_address2;
        $newContractor->billing_city = $request->billing_city;
        $newContractor->billing_postcode = $request->billing_postcode;
        $newContractor->bank_ac_name = $request->bank_ac_name;
        $newContractor->ac_number = $request->ac_number;
        $newContractor->sort_code = $request->sort_code;
        $newContractor->company_reg_no = $request->company_reg_no;
        $newContractor->save();

        return redirect()->route('contractors.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
    protected $showFields = [

        'basic_information' => [

            'company_name' => [
                'type' => 'text',
            ],

            'contact_name' => [
                'type' => 'text'
            ],

            'mobile_tel_no' => [
                'type' => 'text',
            ],

            'main_office_tel_no' => [
                'type' => 'text',
            ],

            'password' => [
                'type' => 'password'
            ],

            'password_confirmation' => [
                'type' => 'password'
            ],

            'position' => [
                'type' => 'text',
            ],   

        ],
        'company_address' => [

            'company_address1' => [
                'type' => 'text',
            ],

            'company_address2' => [
                'type' => 'text'
            ],

            'company_city' => [
                'type' => 'text',
            ],

            'company_postcode' => [
                'type' => 'text',
            ],

            'company_email' => [
                'type' => 'text',
            ],

            'company_fax_no' => [
                'type' => 'text'
            ],

            'billing_address_same_as_company_address' => [
                'type' => 'select'
            ],

            'company_vat_no' => [
                'type' => 'text',
            ]
        ],
        'billing_address' => [

            'billing_address1' => [
                'type' => 'text',
            ],

            'billing_address2' => [
                'type' => 'text'
            ],
            'billing_city' => [
                'type' => 'text',
            ],

            'billing_postcode' => [
                'type' => 'text'
            ]
        ],
        'bank_details' => [

            'bank_ac_name' => [
                'type' => 'text',
            ],
            'ac_number' => [
                'type' => 'text',
            ],
            'sort_code' => [
                'type' => 'text',
            ],
            'company_reg_no' => [
                'type' => 'text',
            ]
        ]
    ];
}
