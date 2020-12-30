<?php

namespace Modules\Clients\Http\Controllers;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Clients\Http\Forms\AddStoreForm;
use Modules\Clients\DataTables\StorecontactDataTable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Clients\Entities\Store;
use Modules\Clients\Entities\Storecontact;
use Redirect;

class StoresController extends Controller
{
    use FormBuilderTrait;

        protected $showFields = [

        'basic_information' => [

            'store_id' => [
                'type' => 'text',
            ],

            'store_name' => [
                'type' => 'text'
            ],

            'address_same_as_client' => [
                'type' => 'checkbox'
            ]
        ],

        'address' => [

            'address1' => [
                'type' => 'text',
            ],


            'address2' => [
                'type' => 'text',
            ],


            'city' => [
                'type' => 'text',
            ],


            'postcode' => [
                'type' => 'text',
            ]

        ],


        'contact_information' => [

            'name' => [
                'type' => 'text',
            ],


            'title' => [
                'type' => 'text',
            ],


            'email' => [
                'type' => 'email',
            ],


            'phone_no' => [
                'type' => 'text',
            ]

        ]

    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(StoreDataTable $dataTable)
    {   
        return $dataTable->render('signup::index');
        //return view('clients::index');
    }
    public function contactcreate($id, FormBuilder $formBuilder){

        $form = $formBuilder->create(AddStoreForm::class, [
            'method' => 'POST',
            'url' => route('store-contacts.store'),
            'id' => 'module_form'
        ],['store_form' => false]);
        unset($this->showFields['basic_information']);
        unset($this->showFields['address']);
        return view('clients::create', compact('form'))
               ->with('show_fields', $this->showFields);
        //return redirect()->route('login');
        //return Redirect::to(route('stores.edit',$id).'#tab_contacts');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create($id, FormBuilder $formBuilder)
    {   
        $form = $formBuilder->create(AddStoreForm::class, [
            'method' => 'POST',
            'url' => route('stores.store'),
            'id' => 'module_form'
        ],['client_id' => $id, 'address_same_fill' => true , 'store_form' => true]);
        
        return view('clients::create', compact('form'))
               ->with('show_fields', $this->showFields)
               ->with('appjs',true);

        // first complete saving data
        // then route to Add contact 2, then 3, then 4 and so on 
        // create some records
        // list records
        // on clicking the record show details
        // on attachment tab upload and list files
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $form = $this->form(AddStoreForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $newStore = new Store;
        $newStore->store_id = $request->store_id;
        $newStore->store_name = $request->store_name;
        $newStore->address1 = $request->address1;
        $newStore->address2 = $request->address2;
        $newStore->city = $request->city;
        $newStore->postcode = $request->postcode;
        $newStore->client_id = $request->client_id;
        $newStore->save();

        $newContact = new Storecontact;
        $newContact->name = $request->name;
        $newContact->title = $request->title;
        $newContact->email = $request->email;
        $newContact->phone_no = $request->phone_no;
        $newContact->store_id = $newStore->id;
        $newContact->save();

        // list store - partially done
        // list client contact - partially done
        // list store contact - partially done
        // add client contact seperately - partially done
        // add store contact seperately - partially done

        // complete store contact completely - crud

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('clients::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id, FormBuilder $formBuilder, StorecontactDataTable $tableObj)
    {   if (request()->ajax()) {
            return $tableObj->render('core::datatable');
        }
        $store = Store::find($id);

        $form = $formBuilder->create(AddStoreForm::class, [
            'method' => 'POST',
            'url' => route('stores.store'),
            'id' => 'module_form'
        ],['address_same_fill' => false, 'store_form' => true ]);
        
        unset($this->showFields['basic_information']['address_same_as_client']);

        $dataTable = $tableObj->html();
        
        return view('clients::storeedit', compact('form'))
               ->with('show_fields', $this->showFields)
               ->with(compact('dataTable'));
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
}
