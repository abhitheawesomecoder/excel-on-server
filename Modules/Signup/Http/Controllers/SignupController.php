<?php

namespace Modules\Signup\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Kris\LaravelFormBuilder\FormBuilder;
use Modules\Signup\Http\Forms\AddUserForm;
use Modules\Signup\Emails\UserSignupEmail;
use Illuminate\Support\Facades\Mail;
use Modules\Signup\Entities\Signup;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\PostForm;

class SignupController extends Controller
{   
    use FormBuilderTrait;

    public function signin()
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
    {   
        $form = $formBuilder->create(AddUserForm::class, [
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
        $form = $this->form(PostForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $token = now()->timestamp;

        $newSignupRequest = new Signup;
        $newSignupRequest->email = $request->email;
        $newSignupRequest->token = $token;
        $newSignupRequest->role_id = $request->Type;
        //$newSignupRequest->save();

        $link = route('signin',$token);
        Mail::to($request->email)->send(new UserSignupEmail($link));

        // save it in database - done
        // signup form
        // crud of signup requests for super admin
        // do one user signup and disable main registration
        // closed system user registration should be there
        // link should expire after specific time
        // crud for all all users with role and permission
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
