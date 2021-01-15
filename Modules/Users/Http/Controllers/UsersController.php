<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Users\DataTables\UsersDataTable;
use Illuminate\Contracts\Support\Renderable;
use Kris\LaravelFormBuilder\FormBuilder;
use Modules\Signup\Http\Forms\AddUserForm;
use Modules\Signup\Http\Forms\UserSignupForm;
use Modules\Signup\Emails\UserSignupEmail;
use Illuminate\Support\Facades\Mail;
use Modules\Signup\Entities\Signup;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Signup\DataTables\SignupDataTable;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;

class UsersController extends Controller
{   
    use FormBuilderTrait;
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('users::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {
      // add email field to UserSignupForm
      $title  = 'core.user.create.title';
      $subtitle = 'core.user.create.subtitle';
      $form = $formBuilder->create(UserSignupForm::class, [
                'method' => 'POST',
                'url' => route('users.store')
            ],['token' => 'notoken' ]);

      return view('signup::create',compact('form'))
                ->with(compact('title','subtitle'));
       
        //return view('users::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $form = $this->form(UserSignupForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $newUser = new User;
        $newUser->name = $request->first_name;
        $newUser->first_name = $request->first_name;
        $newUser->last_name = $request->last_name;
        $newUser->password = Hash::make($request->password);
        $newUser->email = $request->email;
        $newUser->save();

        $role = Role::find($request->Type);

        $newUser->assignRole($role->name);

        Auth::login($newUser);

        return redirect()->route('home');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id, FormBuilder $formBuilder)
    { 
      $user = User::find($id);
      $title  = 'core.user.view.title';
      $subtitle = 'core.user.view.subtitle';
      $form = $formBuilder->create(UserSignupForm::class, [
                'method' => 'GET',
                'id' => 'module_form',
                'model' => $user,
            ],['token' => 'notoken' ,'create_form' => false]);

      return view('signup::create',compact('form'))
                ->with(compact('title','subtitle','id'));
        //return view('users::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id, FormBuilder $formBuilder)
    {
      $user = User::find($id);
      $title  = 'core.user.update.title';
      $subtitle = 'core.user.update.subtitle';
      $form = $formBuilder->create(UserSignupForm::class, [
                'method' => 'PATCH',
                'url' => route('users.update',$id),
                'id' => 'module_form',
                'model' => $user,
            ],['token' => 'notoken' ,'create_form' => false,'edit_form' => true]);

      return view('signup::create',compact('form'))
                ->with(compact('title','subtitle','id'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $form = $this->form(UserSignupForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $oldUser = User::find($id);
        $oldUser->name = $request->first_name;
        $oldUser->first_name = $request->first_name;
        $oldUser->last_name = $request->last_name;
        $oldUser->email = $request->email;
        $oldUser->save();

        $role = Role::find($request->Type);

        $oldUser->assignRole($role->name);

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        // user with id 1 cannot be deleted
        if($id != 1){
            exit();
        }
        return redirect()->back();

    }
}
