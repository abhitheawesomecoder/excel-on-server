<?php

namespace Modules\Jobs\Http\Controllers;

use Calendar;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Jobs\Entities\Job;
use Modules\Jobs\Entities\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Modules\Clients\Entities\Store;
use Modules\Clients\Entities\Client;
use Modules\Jobs\Http\Forms\AddJobForm;
use Kris\LaravelFormBuilder\FormBuilder;
use Modules\Jobs\DataTables\JobDataTable;
use Modules\Contractors\Entities\Contractor;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class JobsController extends Controller
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
    public function calendar()
    {
        $events = [];
        $data = Job::all();
        if($data->count()) {
                    foreach ($data as $key => $value) {
                    $events[] = Calendar::event(
                    $value->excel_job_number,
                    true,
                    new \DateTime($value->due_date),
                    new \DateTime($value->due_date.' +1 day'),
                    null,
                    // Add color and link on event
                    [
                        'color' => '#f05050',
                        'url' => 'https://www.google.com',
                    ]
                );
            }
        }
        $calendar = Calendar::addEvents($events);
        return view('jobs::calendar', compact('calendar'));
    }
    public function index(JobDataTable $dataTable)
    {
        //return view('jobs::index');
        return $dataTable->render('signup::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {   
 /*       $newQuery = new Job;
        $query = $newQuery->newQuery();
        //$query->get();
        $result = $query->get()->map(function($q){
           if($q->priority == 4)
             $q->priority = 'high';
         return $q;
        });
        print_r($result);
        exit();
*/
        $title  = 'core.jobs.create.title';
        $subtitle = 'core.jobs.create.subtitle';
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

        $form = $formBuilder->create(AddJobForm::class, [
            'method' => 'POST',
            'url' => route('jobs.store'),
            'id' => 'module_form'
        ],['clients' => $client_arr, 'stores' => $store_arr, 'staff' => $staff, 'contractors' => $contractor_arr]);

        return view('jobs::create', compact('form'))
               ->with('show_fields', $this->showFields)
               ->with(compact('title','subtitle'))
               ->with('appjs',true);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $form = $this->form(AddJobForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $newJob = new Job;
        $newJob->excel_job_number = $request->excel_job_number;
        $newJob->client_id = $request->client_id;
        $newJob->store_id = $request->store_id;
        $newJob->due_date = $request->due_date;
        $newJob->assigned_to = $request->assigned_to;
        $newJob->priority = $request->priority;
        $newJob->status = $request->status;
        $newJob->contractor_id = $request->contractor_id;
        $newJob->job_type = $request->job_type;
        $newJob->save();

        $taskArr = json_decode($request->_todo);
        //Array ( [0] => stdClass Object ( [done] => 1 [title] => kkk ) [1] => stdClass Object ( [done] => [title] => iii ) ) 

            foreach($taskArr as $task) {
                $newTask = new Task;
                $newTask->task = $task->title;
                $newTask->status = $task->done ? 1 : 0;
                $newTask->job_id = $newJob->id;
                $newTask->save();
            }

        return redirect()->route('jobs.index');
        
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('jobs::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('jobs::edit');
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
