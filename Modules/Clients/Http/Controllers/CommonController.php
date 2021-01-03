<?php

namespace Modules\Clients\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Clients\Entities\Client; 
use Modules\Clients\Entities\Stores;
use Modules\Clients\Entities\Contact;
use Modules\Clients\Entities\Storecontact;

class CommonController extends Controller
{
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
    public function clients_destroy($id)
    {   //DB::table('signups')->where('token', $request->signup_token)->delete();
        Client::where('id', $id)->delete();
        return redirect()->route('clients.index');
    }
    public function stores_destroy($id)
    {   Store::where('id', $id)->delete();
        return Redirect::to(route('clients.edit',$id).'#tab_stores');
    }
    public function contacts_destroy($id)
    {   Contact::where('id', $id)->delete();
        return Redirect::to(route('clients.edit',$id).'#tab_contacts');
    }
    public function store_contacts_destroy($id)
    {   Storecontact::where('id', $id)->delete();
        return Redirect::to(route('stores.edit',$id).'#tab_contacts');
    }
}
