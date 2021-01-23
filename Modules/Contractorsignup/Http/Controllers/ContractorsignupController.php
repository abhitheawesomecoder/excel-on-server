<?php

namespace Modules\Contractorsignup\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Kris\LaravelFormBuilder\FormBuilder;
use Modules\Signup\Emails\UserSignupEmail;
use Modules\Contractors\Entities\Contractor;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Contractors\Http\Forms\AddContractorForm;
use Modules\Contractorsignup\Entities\Contractorsignup;
use Modules\Contractorsignup\DataTables\ContractorsignupDataTable;
use Modules\Contractorsignup\Http\Forms\AddContractorsignupForm;

class ContractorsignupController extends Controller
{   
    use FormBuilderTrait;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function save(Request $request)
    {
        $form = $this->form(AddContractorForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $contractor = Contractorsignup::where('token',$request->signup_token)->first();

        $newUser = new User;
        $newUser->name = $request->contact_name;
        $newUser->first_name = $request->contact_name;
        $newUser->password = Hash::make($request->password);
        $newUser->email = $contractor->email;
        $newUser->type = 'contractor';
        $newUser->save();

        $newContractor = new Contractor;
        $newContractor->next_job_number = $contractor->contractor_identifier.'1001';
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
        $newContractor->user_id = $newUser->id;
        $newContractor->save();

        Auth::login($newUser);

        Contractorsignup::where('token', $request->signup_token)->delete();

        return redirect()->route('home');

    }
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
            'url' => route('contractorsignup.save'),
            'id' => 'module_form'
        ],['token' => $signup->token, 'create_form' => true]);

        return view('contractors::create', compact('form'))
               ->with('show_fields', $this->showFields)
               ->with(compact('title','subtitle'))
               ->with('appjs',true);
        }
       else
        return redirect()->back()->withInput();
    }
    public function index(ContractorsignupDataTable $dataTable)
    {
        //return view('contractorsignup::index');
        return $dataTable->render('signup::index');
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
        $newSignupRequest->contractor_identifier = $request->contractor_identifier;
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

        return redirect()->route('contractorsignup.index');
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
