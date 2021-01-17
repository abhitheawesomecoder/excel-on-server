<?php

namespace Modules\Contractorprofile\Http\Controllers;

use Illuminate\Http\Response;
use Modules\Jobs\Entities\Job;
use Modules\Jobs\Entities\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Modules\Clients\Entities\Store;
use Modules\Clients\Entities\Client;
use Modules\Jobs\Http\Forms\AddJobForm;
use Kris\LaravelFormBuilder\FormBuilder;
use Modules\Contractors\Entities\Contractor;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Contractorprofile\DataTables\JobDataTable;

class ContractorprofileController extends Controller
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
    public function index($status, JobDataTable $dataTable)
    {   
        //echo $status;
        //exit();
        return $dataTable->with('status', $status)->render('signup::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('contractorprofile::create');
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
    public function requested_confirmed($id, FormBuilder $formBuilder){
        echo $id;
        exit();
        // change status of job to confirmed
    }
    public function completed($id, FormBuilder $formBuilder)
    {
    }
    public function confirmed($id, FormBuilder $formBuilder)
    {
    }
    public function requested($requested, $id, FormBuilder $formBuilder)
    {   
        $title  = 'core.job.'.$requested.'.title';
        $subtitle = 'core.job.'.$requested.'.subtitle';
        $clients = Client::all();
        $client_arr = array();
        foreach($clients as $client) {
            $client_arr[$client->id] = $client->client_name;
        }

        $stores = Store::all();
        $store_arr = array();
        foreach($stores as $store) {
            $store_arr[$store->id] = $store->store_name;
        }
        $users = DB::table('users')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('model_has_roles.role_id', 2)
            ->select('users.id', 'users.first_name', 'users.last_name')
            ->get();
        $staff = array();
        foreach($users as $user) {
            $staff[$user->id] = $user->first_name." ".$user->last_name;
        }

        $contractors = Contractor::all();
        $contractor_arr = array();
        foreach($contractors as $contractor) {
            $contractor_arr[$contractor->id] = $contractor->company_name;
        }
        $job = Job::find($id);

        $form = $formBuilder->create(AddJobForm::class, [
            'method' => 'POST',
            'url' => route('jobs.store'),
            'model' => $job,
            'id' => 'module_form'
        ],['clients' => $client_arr, 'stores' => $store_arr, 'staff' => $staff, 'contractors' => $contractor_arr, 'create_form' => false]);

        $tasks = Task::where('job_id',$id)->get();
        $taskArr = array();
        foreach ($tasks as $task) {
            //$taskJson = { 'title': $task->task, 'done': $task->status};
            $taskJson = new \stdClass();
            $taskJson->title = $task->task;
            $taskJson->done = $task->status ? true : false;
            array_push($taskArr,$taskJson);
        }

        return view('contractorprofile::create', compact('form'))
               ->with('show_fields', $this->showFields)
               ->with(compact('title','subtitle','id'))
               ->with('appviewjs',json_encode($taskArr));
        //return view('contractorprofile::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('contractorprofile::edit');
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

            protected $showFields = [

        'basic_information' => [

            'excel_job_number' => [
                'type' => 'text'
            ],

            'client_id' => [
                'type' => 'select'
            ],

            'store_id' => [
                'type' => 'select'
            ],

            'due_date' => [
                'type' => 'text'
            ],

            'assigned_to' => [
                'type' => 'select'
            ],

            'priority' => [
                'type' => 'select'
            ],

            'status' => [
                'type' => 'select'
            ],
            'contractor_id' => [
                'type' => 'select'
            ],
            'job_type' => [
                'type' => 'select'
            ]
        ],
        'description' => [

            'description' => [
                'type' => 'text'
            ]
          ]
    ];
}
