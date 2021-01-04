<?php

namespace Modules\Clients\Http\Controllers;

use Redirect;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Clients\Http\Forms\AddStoreForm;
use Modules\Clients\Http\Forms\ViewStoreForm;
use Modules\Clients\Entities\Storecontact;
use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class StorecontactsController extends Controller
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
        $form = $this->form(AddStoreForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $id = $request->_id;
        $newContact = new Storecontact;
        $newContact->name = $request->name;
        $newContact->title = $request->title;
        $newContact->email = $request->email;
        $newContact->phone_no = $request->phone_no;
        $newContact->store_id = $id;
        $newContact->save();

        return Redirect::to(route('stores.edit',$id).'#tab_contacts');

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id, FormBuilder $formBuilder)
    {
        $model = Storecontact::find($id);
        $title  = 'core.storecontact.update.title';
        $subtitle = 'core.storecontact.update.subtitle';
        $form = $formBuilder->create(ViewStoreForm::class, [
            'method' => 'PATCH',
            'url' => route('store-contacts.update',$model),
            'id' => 'module_form',
            'model' => $model,
        ],['_id' => $id,'store_form' => false, 'store_edit_form' => true ]);
        unset($this->showFields['basic_information']);
        unset($this->showFields['address']);
        return view('clients::create', compact('form'))
               ->with('show_fields', $this->showFields)
               ->with(compact('title','subtitle'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id, FormBuilder $formBuilder)
    {   $model = Storecontact::find($id);
        $title  = 'core.storecontact.update.title';
        $subtitle = 'core.storecontact.update.subtitle';
        $form = $formBuilder->create(AddStoreForm::class, [
            'method' => 'PATCH',
            'url' => route('store-contacts.update',$model),
            'id' => 'module_form',
            'model' => $model,
        ],['_id' => $id,'store_form' => false, 'store_edit_form' => true ]);
        unset($this->showFields['basic_information']);
        unset($this->showFields['address']);
        return view('clients::create', compact('form'))
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
        $storecontact = Storecontact::find($id);
        $storecontact->name = $request->name;
        $storecontact->title = $request->title;
        $storecontact->email = $request->email;
        $storecontact->phone_no = $request->phone_no;
        $storecontact->save();
        return Redirect::to(route('stores.edit',$storecontact->store_id).'#tab_contacts');
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
