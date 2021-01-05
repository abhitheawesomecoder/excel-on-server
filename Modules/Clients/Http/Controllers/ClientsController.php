<?php

namespace Modules\Clients\Http\Controllers;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Clients\Http\Forms\AddClientForm;
use Modules\Clients\Http\Forms\ViewClientForm;
use Modules\Clients\DataTables\ClientDataTable;
use Modules\Clients\DataTables\StoreDataTable;
use Modules\Clients\DataTables\ContactDataTable;
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

        //return $model->newQuery();
        //$query = $model->newQuery();
        //$newQuery = $query->select([
        /*$query = Client::query()
                ->select([
                'clients.account_number as account_number',
                'clients.client_name as client_name',
                'users.name as assigned_to',
                'contacts.email as email',
                'contacts.phone_no as phone_no',
            ])
            ->leftJoin('users', 'clients.assigned_to', '=', 'users.id')
            ->leftjoin('contacts', 'contacts.client_id', '=', 'clients.id')
            ->get();

        echo $query;
        exit();*/
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
    public function contactcreate($id, FormBuilder $formBuilder){
//http://localhost/excel/public/clients/1/contacts/create
        $form = $formBuilder->create(AddClientForm::class, [
            'method' => 'POST',
            'url' => route('clients.store'),
            'id' => 'module_form'
        ],['client_form' => false, 'client_edit_form' => true ]);
        $title  = 'core.clientcontact.create.title';
        $subtitle = 'core.clientcontact.create.subtitle';
        unset($this->showFields['basic_information']);
        return view('clients::create', compact('form'))
               ->with('show_fields', $this->showFields)
               ->with(compact('title','subtitle'));
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
        $title  = 'core.client.create.title';
        $subtitle = 'core.client.create.subtitle';
        $form = $formBuilder->create(AddClientForm::class, [
            'method' => 'POST',
            'url' => route('clients.store'),
            'id' => 'module_form'
        ],['staff' => $staff,'client_form' => true, 'client_edit_form' => true ]);
        
        return view('clients::create', compact('form'))
               ->with('show_fields', $this->showFields)
               ->with(compact('title','subtitle'));

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
        //return redirect()->route('clients.index');
        return redirect()->route('contactscreate',$newClient->id);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id, FormBuilder $formBuilder, StoreDataTable $tableObj,ContactDataTable $contactTableObj){
        if (request()->ajax()) {
    
          switch (request()->columns[1]['data']) {
              case 'store_id':
                  return $tableObj->render('core::datatable');
              default:
                  return $contactTableObj->render('core::datatable');
          }
        }
        $entity = Client::find($id);

        $client = DB::table('clients')
            ->leftjoin('contacts', 'contacts.client_id', '=', 'clients.id')
        ->first();
// add where clause
        $title  = 'core.client.view.title';
        $subtitle = 'core.client.view.subtitle';
        $users = DB::table('users')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('model_has_roles.role_id', 2)
            ->select('users.id', 'users.first_name', 'users.last_name')
            ->get();
        $staff = array();
        foreach($users as $user) {
            $staff[$user->id] = $user->first_name." ".$user->last_name;
        }

        $form = $formBuilder->create(ViewClientForm::class, [
            'method' => 'PATCH',
            'url' => route('clients.update',$client->id),
            'id' => 'module_form',
            'model' => $client
        ],['staff' => $staff,'client_form' => true, 'client_edit_form' => true ]);

        //unset($this->showFields['contact_information']);

        $dataTable = $tableObj->html();

        $contactTable = $contactTableObj->html();
        
        return view('clients::view', compact('form'))
               ->with('show_fields', $this->showFields)
               ->with('entity', $entity)
               ->with(compact('dataTable'))
               ->with(compact('contactTable'))
               ->with(compact('title','subtitle'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id, FormBuilder $formBuilder, StoreDataTable $tableObj,ContactDataTable $contactTableObj)
    {   //http://localhost/excel/public/clients/1/edit
        if (request()->ajax()) {
    
          switch (request()->columns[1]['data']) {
              case 'store_id':
                  return $tableObj->render('core::datatable');
              default:
                  return $contactTableObj->render('core::datatable');
          }
        }

        $client = Client::find($id);
        $title  = 'core.client.update.title';
        $subtitle = 'core.client.update.subtitle';
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
            'method' => 'PATCH',
            'url' => route('clients.update',$client),
            'id' => 'module_form',
            'model' => $client
        ],['staff' => $staff,'client_form' => true, 'client_edit_form' => false ]);

        unset($this->showFields['contact_information']);

        $dataTable = $tableObj->html();

        $contactTable = $contactTableObj->html();
        
        return view('clients::show', compact('form'))
               ->with('show_fields', $this->showFields)
               ->with('entity', $client)
               ->with(compact('dataTable'))
               ->with(compact('contactTable'))
               ->with(compact('title','subtitle'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        $client->account_number = $request->account_number;
        $client->client_name= $request->client_name;
        $client->assigned_to = $request->assigned_to;
        $client->save();
        //return Redirect::to(route('clients.index'));
        return redirect()->route('clients.index');
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
