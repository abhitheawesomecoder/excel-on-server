<?php

namespace Modules\Clients\Http\Controllers;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Clients\Http\Forms\AddClientForm;
use Modules\Clients\DataTables\ClientDataTable;
use Modules\Clients\DataTables\StoreDataTable;
use DataTables;
use Modules\Clients\Entities\Store;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Clients\Entities\Client;
use Modules\Clients\Entities\Contact;

class ClientsController extends Controller
{
    use FormBuilderTrait;

        protected $showFields = [

        'basic_information' => [

            'account_number' => [
                'type' => 'text',
            ],

            'client_name' => [
                'type' => 'text'
            ],

            'assigned_to' => [
                'type' => 'select',
            ]
        ],


        'contact_information' => [

            'first_name' => [
                'type' => 'text',
            ],


            'last_name' => [
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
            ],

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
    public function index(ClientDataTable $dataTable)
    {   
        return $dataTable->render('signup::index');
        //return view('clients::index');
    }
    public function getaddress(Request $request)
    {
        $user = \Auth::user();

        $clientId = $request->get('clientId');

        $contact = Contact::where('client_id',$clientId)->first();



        /*$entityClass = $request->get('entityClass');
        $entityId = $request->get('entityId');

        $entityClass = str_replace('&quot;', '', $entityClass);


        $entity = app($entityClass)->find($entityId);


        $comments = $this->commentsRepository->findWhere([
            'commentable_type' => $entityClass,
            'commentable_id' => $entity->id
        ]);

        $resultComments = [];

        foreach ($comments as $comment) {
            $resultComments[] = $this->commentsRepository->convertCommentToPluginResult($comment);
        }*/

        return \Response::json($contact);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {   //return redirect()->route('clients..edit',1);
        $users = DB::table('users')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('model_has_roles.role_id', 2)
            ->select('users.id', 'users.first_name', 'users.last_name')
            ->get();
        $staff = array();
        foreach($users as $user) {
            $staff[$user->id] = $user->first_name." ".$user->last_name;
        }

        $form = $formBuilder->create(AddClientForm::class, [
            'method' => 'POST',
            'url' => route('clients.store'),
            'id' => 'module_form'
        ],['staff' => $staff ]);
        
        return view('clients::create', compact('form'))
               ->with('show_fields', $this->showFields);

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
        $form = $this->form(AddClientForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $newClient = new Client;
        $newClient->account_number = $request->account_number;
        $newClient->client_name = $request->client_name;
        $newClient->assigned_to = $request->assigned_to;
        $newClient->save();

        $newContact = new Contact;
        $newContact->first_name = $request->first_name;
        $newContact->last_name = $request->last_name;
        $newContact->title = $request->title;
        $newContact->email = $request->email;
        $newContact->phone_no = $request->phone_no;
        $newContact->address1 = $request->address1;
        $newContact->address2 = $request->address2;
        $newContact->city = $request->city;
        $newContact->postcode = $request->postcode;
        $newContact->client_id = $newClient->id;
        $newContact->save();
        
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
    public function edit($id, FormBuilder $formBuilder, StoreDataTable $tableObj)
    {   
        if (request()->ajax()) {
            return $tableObj->render('core::datatable');
        }

        $client = Client::find($id);
        
        $users = DB::table('users')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('model_has_roles.role_id', 2)
            ->select('users.id', 'users.first_name', 'users.last_name')
            ->get();
        $staff = array();
        foreach($users as $user) {
            $staff[$user->id] = $user->first_name." ".$user->last_name;
        }

        $form = $formBuilder->create(AddClientForm::class, [
            'method' => 'POST',
            'url' => route('clients.store'),
            'id' => 'module_form'
        ],['staff' => $staff ]);

        $dataTable = $tableObj->html();
        
        return view('clients::show', compact('form'))
               ->with('show_fields', $this->showFields)
               ->with('entity', $client)
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
