<?php

namespace Modules\Signup\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
//use Yajra\DataTables\DataTables;
//use Modules\Signup\DataTables\UsersDataTable;
use App\User;

class SignupController extends Controller
{
    use FormBuilderTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['signin','save']]);
    }

    public function signin(FormBuilder $formBuilder)
    { 
      $link = url()->full();
      $link_array = explode('/',$link);
      $token = end($link_array);

      $signup = Signup::where('token',$token)->first();

      if($signup)
      {
          $form = $formBuilder->create(UserSignupForm::class, [
                'method' => 'POST',
                'url' => route('user.save')
            ],['token' => $signup->token ]);

            return view('signup::create',compact('form'));
       }
       else
        return redirect()->back()->withInput();
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(SignupDataTable $dataTable)
    {
        //print_r($dataTable);
        //exit();
        return $dataTable->render('signup::index');
    }
    public function index_(Request $request)
    {
            if ($request->ajax()) {

            $data = User::latest()->get();

            return Datatables::of($data)

                    ->addIndexColumn()

                    ->addColumn('action', function($row){



                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';



                            return $btn;

                    })

                    ->rawColumns(['action'])

                    ->make(true);

        }

        //return view('users');
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
    public function save(Request $request)
    {
        $form = $this->form(UserSignupForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $signup = Signup::where('token',$request->signup_token)->first();

        $newUser = new User;
        $newUser->name = $request->first_name;
        $newUser->first_name = $request->first_name;
        $newUser->last_name = $request->last_name;
        $newUser->password = Hash::make($request->password);
        $newUser->email = $signup->email;
        $newUser->save();

        $role = Role::find($signup->role_id);

        $newUser->assignRole($role->name);

        Auth::login($newUser);

        DB::table('signups')->where('token', $request->signup_token)->delete();

        return redirect()->route('home');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $form = $this->form(AddUserForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $token = now()->timestamp;

        $newSignupRequest = new Signup;
        $newSignupRequest->email = $request->email;
        $newSignupRequest->token = $token;
        $newSignupRequest->role_id = $request->Type;
        $newSignupRequest->save();

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

        return redirect()->route('index');
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
        //DB::table('signups')->where('token', $request->signup_token)->delete();
    }
}
