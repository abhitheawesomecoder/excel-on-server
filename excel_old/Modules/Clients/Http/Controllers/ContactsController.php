<?php

namespace Modules\Clients\Http\Controllers;

use Redirect;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Clients\Http\Forms\AddClientForm;
use Modules\Clients\Http\Forms\ViewClientForm;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Clients\Entities\Contact;

class ContactsController extends Controller
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
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('clients::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('clients::create');
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
    public function show($id, FormBuilder $formBuilder)
    {
        $contact = Contact::find($id);
        $title  = 'core.contact.view.title';
        $subtitle = 'core.contact.view.subtitle';

        $form = $formBuilder->create(ViewClientForm::class, [
            'method' => 'PATCH',
            'url' => route('contacts.update',$contact),
            'id' => 'module_form',
            'model' => $contact
        ],['client_form' => false, 'client_edit_form' => true ]);
        
        unset($this->showFields['basic_information']);

        return view('clients::contactedit', compact('form'))
               ->with('show_fields', $this->showFields)
               ->with(compact('title','subtitle','id'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id, FormBuilder $formBuilder)
    {   
        $contact = Contact::find($id);
        $title  = 'core.contact.update.title';
        $subtitle = 'core.contact.update.subtitle';

        $form = $formBuilder->create(AddClientForm::class, [
            'method' => 'PATCH',
            'url' => route('contacts.update',$contact),
            'id' => 'module_form',
            'model' => $contact
        ],['client_form' => false, 'client_edit_form' => true ]);
        
        unset($this->showFields['basic_information']);

        return view('clients::contactedit', compact('form'))
               ->with('show_fields', $this->showFields)
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
        $contact = Contact::find($id);
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->title = $request->title;
        $contact->email = $request->email;
        $contact->phone_no = $request->phone_no;
        $contact->address1 = $request->address1;
        $contact->address2 = $request->address2;
        $contact->city = $request->city;
        $contact->postcode = $request->postcode;
        $contact->save();
        return Redirect::to(route('contacts.edit',$id).'#tab_contacts');
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
