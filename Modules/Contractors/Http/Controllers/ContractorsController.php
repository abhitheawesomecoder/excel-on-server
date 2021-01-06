<?php

namespace Modules\Contractors\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Contractors\Http\Forms\AddContractorForm;

class ContractorsController extends Controller
{
    use FormBuilderTrait;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['create']]);
    }
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('contractors::index');
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
        ]);

        return view('contractors::create', compact('form'))
               ->with('show_fields', $this->showFields)
               ->with(compact('title','subtitle'));
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
    public function show($id)
    {
        return view('contractors::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('contractors::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
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

            'position' => [
                'type' => 'text',
            ],

            'email' => [
                'type' => 'email'
            ],

            'password' => [
                'type' => 'password'
            ],

            'password_confirmation' => [
                'type' => 'password'
            ]

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
