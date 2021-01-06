<?php

namespace Modules\Contractorsignup\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\Contractorsignup\Http\Forms\AddContractorsignupForm;
use Modules\Signup\Emails\UserSignupEmail;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Contractorsignup\Entities\Contractorsignup;
use Modules\Contractors\Http\Forms\AddContractorForm;

class ContractorsignupController extends Controller
{   
    use FormBuilderTrait;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function signup($token, FormBuilder $formBuilder){
      $link = url()->full();
      $link_array = explode('/',$link);
      $token = end($link_array);

      $signup = Contractorsignup::where('token',$token)->first();

      if($signup)
      {
        $title  = 'core.contractor.create.title';
        $subtitle = 'core.contractor.create.subtitle';
        $form = $formBuilder->create(AddContractorForm::class, [
            'method' => 'POST',
            'url' => route('contractors.store'),
            'id' => 'module_form'
        ],['token' => $signup->token ]);

        return view('contractors::create', compact('form'))
               ->with('show_fields', $this->showFields)
               ->with(compact('title','subtitle'));
        }
       else
        return redirect()->back()->withInput();
    }
    public function index()
    {
        return view('contractorsignup::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {
      
        $form = $formBuilder->create(AddContractorsignupForm::class, [
            'method' => 'POST',
            'url' => route('contractorsignup.store')
        ]);
        $title  = 'core.contractorsignup.create.title';
        $subtitle = 'core.contractorsignup.create.subtitle';

        return view('core::signupemailrequest', compact('form'))
                ->with(compact('title','subtitle'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $form = $this->form(AddContractorsignupForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $token = now()->timestamp;

        $newSignupRequest = new Contractorsignup;
        $newSignupRequest->email = $request->email;
        $newSignupRequest->token = $token;
        $newSignupRequest->save();

        $link = route('contractors.signup',$token);
        Mail::to($request->email)->send(new UserSignupEmail($link));

        // save it in database - done
        // signup form
        // crud of signup requests for super admin
        // do one user signup and disable main registration
        // closed system user registration should be there
        // link should expire after specific time
        // crud for all all users with role and permission
        //print_r($timestamp);

        return redirect()->route('contractors.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('contractorsignup::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('contractorsignup::edit');
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
