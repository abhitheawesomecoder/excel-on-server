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
use Spipu\Html2Pdf\Html2Pdf;

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
        ],['create_form' => true, 'clients' => $client_arr, 'stores' => $store_arr, 'staff' => $staff, 'contractors' => $contractor_arr]);

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
    public function show($id, FormBuilder $formBuilder)
    {	
    	$title  = 'core.jobs.view.title';
        $subtitle = 'core.jobs.view.subtitle';
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
		//print_r($taskArr);
		//exit();

        return view('jobs::create', compact('form'))
               ->with('show_fields', $this->showFields)
               ->with(compact('title','subtitle','id'))
               ->with('appviewjs',json_encode($taskArr));
        //return view('jobs::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id, FormBuilder $formBuilder)
    {	
        $title  = 'core.jobs.update.title';
        $subtitle = 'core.jobs.update.subtitle';
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
            'method' => 'PATCH',
            'url' => route('jobs.update',$id),
            'model' => $job,
            'id' => 'module_form'
        ],['clients' => $client_arr, 'stores' => $store_arr, 'staff' => $staff, 'contractors' => $contractor_arr, 'create_form' => true]);

        $tasks = Task::where('job_id',$id)->get();
        $taskArr = array();
        foreach ($tasks as $task) {
        	//$taskJson = { 'title': $task->task, 'done': $task->status};
        	$taskJson = new \stdClass();
        	$taskJson->title = $task->task;
        	$taskJson->done = $task->status ? true : false;
        	array_push($taskArr,$taskJson);
        }
		
        return view('jobs::create', compact('form'))
               ->with('show_fields', $this->showFields)
               ->with(compact('title','subtitle','id'))
               ->with('appeditjs',json_encode($taskArr));
      //return view('jobs::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $form = $this->form(AddJobForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $newJob = Job::find($id);
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
        Task::where('job_id',$id)->delete();
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

    public function signcontract(){
       $image = 'data:image/png;base64,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';

      $html2pdf = new Html2Pdf('P', 'A4', 'en');
      //$html2pdf->pdf->AddPage();
      $html2pdf->writeHTML('<h1>HelloWorld</h1>This is my first test');
      $html2pdf->writeHTML('<page_footer> <img src="'.$image.'" alt="Girl in a jacket" width="130" height="130"> </page_footer>');
      //$html2pdf->pdf->Image($image,150,40,40,40);
      //$html2pdf->writeHTML('<page_footer>'..'</page_footer>');
      $html2pdf->output();
      //echo $image;
      //return view('jobs::sign');
    }
}
