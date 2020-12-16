<?php

namespace Modules\Signup\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Kris\LaravelFormBuilder\FormBuilder;
use Modules\Signup\Http\Forms\AddUserForm;
use Modules\Signup\Emails\UserSignupEmail;
use Illuminate\Support\Facades\Mail;
use App\User;

class SignupController extends Controller
{
    public function accountsignup()
    {
      return "test";
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('signup::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(FormBuilder $formBuilder)
    {   $form = $formBuilder->create(AddUserForm::class, [
            'method' => 'POST',
            'url' => route('store')
        ]);

        return view('signup::create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $token = now()->timestamp;
        $link = route('account.signup',$token);
        Mail::to("iswitchremote@gmail.com")->send(new UserSignupEmail($link));

        // save it in database
        // 
        //print_r($timestamp);

        print_r($link);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('signup::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('signup::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
