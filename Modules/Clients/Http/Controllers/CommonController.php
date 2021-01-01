<?php

namespace Modules\Clients\Http\Controllers;

use Kris\LaravelFormBuilder\FormBuilder;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Clients\Http\Forms\AddStoreForm;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class CommonController extends Controller
{   
    use FormBuilderTrait;

    protected $showFieldsStore = [

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
    public function contactcreate($id, FormBuilder $formBuilder){

        $form = $formBuilder->create(AddStoreForm::class, [
            'method' => 'POST',
            'url' => route('store-contacts.store'),
            'id' => 'module_form'
        ],['_id' => $id,'store_form' => false]);
        unset($this->showFieldsStore['basic_information']);
        unset($this->showFieldsStore['address']);
        return view('clients::create', compact('form'))
               ->with('show_fields', $this->showFieldsStore);
    }

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
    public function show($id)
    {
        return view('clients::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('clients::edit');
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
