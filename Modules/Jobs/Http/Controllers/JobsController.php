<?php

namespace Modules\Jobs\Http\Controllers;

use Calendar;
use App\User;
use Carbon\Carbon;
use Spipu\Html2Pdf\Html2Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Jobs\Entities\Job;
use Modules\Jobs\Entities\Task;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Jobs\Entities\Jobtype;
use Modules\Clients\Entities\Store;
use Modules\Clients\Entities\Client;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Modules\Jobs\Entities\Signature;
use Modules\Clients\Entities\Contact;
use Modules\Jobs\Http\Forms\AddJobForm;
use Kris\LaravelFormBuilder\FormBuilder;
use Modules\Jobs\DataTables\JobDataTable;
use Modules\Core\Emails\NotificationEmail;
use Modules\Contractors\Entities\Contractor;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Contractorprofile\Http\Forms\AddSignatureForm;

class JobsController extends Controller
{
    use FormBuilderTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function clone($id)
    {
        $job = Job::find($id);
        $newJob = $job->replicate();
        $job_number_arr = explode("-", $job->job_number);
        if(count($job_number_arr) == 1){
            $newJob->job_number= $job->job_number.'-02';
        }else{
            $suffixNo = intval($job_number_arr[1]);
            if($suffixNo < 10){
               $suffixNo++;
               $suffixNo = '0'.$suffixNo;
            }else
               $suffixNo++;
            $newJob->job_number= $job_number_arr[0].'-'.$suffixNo;
        }
        $newJob->save();
        return redirect()->route('jobs.index'); 
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function invoice_received(Request $request)
    {
        $job = Job::find($request->job_id);
        $job->invoice_received = $request->status;
        $job->save();

        return response()->json(array('success' => true), 200);

    }
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
    public function signature($id, FormBuilder $formBuilder)
    {   $form = $formBuilder->create(AddSignatureForm::class, [
            'method' => 'POST',
            'url' => route('user.signature.save'),
            'id' => 'module_form'
        ],['job_id' => $id]);
        return view('jobs::sign',compact('form'));
    }
    public function signaturesave(Request $request)
    {   
        $userId = Auth::user()->id;
        $job = Job::find($request->_id);
        $user = User::find($job->assigned_to);
        $contractor = Contractor::find($job->contractor_id);
        //$sign = Signature::where('job_id',$request->_id)->where('staff_id',$userId)->first();
        $sign = Signature::where('job_id',$request->_id)->first();
        $sign->staffcode = $request->_signature; 
        $sign->staff_date = Carbon::today()->toDateString();
        $sign->staff_id = $userId;
        $sign->save();

        
        $client = Client::find($job->client_id);
        $store = Store::find($job->store_id);
        $contact = Contact::where('client_id', $client->id)->first();
        $tasks = Task::where('job_id',$request->_id)->get();

        $content = view('contractorprofile::test',['path' => $sign->staffcode, 'contractor' => $contractor, 'job' => $job, 'client' => $client, 'store' => $store, 'contact' => $contact, 'tasks' => $tasks])->render();

       $content2 = view('contractorprofile::test3',['sign' => $sign])->render();
       //$content = ob_get_clean(); 
       $html2pdf = new Html2Pdf('P', 'A4', 'en');
       $html2pdf->pdf->SetDisplayMode('fullpage');
       $html2pdf->writeHTML($content);
       $html2pdf->writeHTML($content2);
       $html2pdf->output();

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

        $jobtypes = Jobtype::all();
        $jobtype_arr = array();
        foreach($jobtypes as $jobtype) {
            $jobtype_arr[$jobtype->id] = $jobtype->job_type;
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
        ],['create_form' => true, 'clients' => $client_arr, 'stores' => $store_arr, 'staff' => $staff, 'contractors' => $contractor_arr, 'job_types' => $jobtype_arr]);

        unset($this->showFields['basic_information']['job_number']);

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

        $contractor = Contractor::find($request->contractor_id);

        $user = User::find($contractor->user_id);

        $newJob = new Job;
        $newJob->job_number = $contractor->next_job_number;
        $newJob->client_order_number = $request->client_order_number;
        $newJob->excel_job_number = $request->excel_job_number;
        $newJob->client_id = $request->client_id;
        $newJob->store_id = $request->store_id;
        $newJob->due_date = $request->due_date;
        $newJob->assigned_to = $request->assigned_to;
        $newJob->priority = $request->priority;
        $newJob->status = $request->status;
        $newJob->contractor_id = $request->contractor_id;
        $newJob->job_type = $request->job_type;
        $newJob->note = $request->note;
        $newJob->save();

        $job_number_prefix = substr($contractor->next_job_number, 0, 3);
        $next_job_number = substr($contractor->next_job_number, 3);
        $next_job_number = intval($next_job_number) + 1;
        $contractor->next_job_number = $job_number_prefix.$next_job_number;
        $contractor->save();

        $taskArr = json_decode($request->_todo);
        //Array ( [0] => stdClass Object ( [done] => 1 [title] => kkk ) [1] => stdClass Object ( [done] => [title] => iii ) )

            foreach($taskArr as $task) {
                $newTask = new Task;
                $newTask->task = $task->title;
                $newTask->status = $task->done ? 1 : 0;
                $newTask->job_id = $newJob->id;
                $newTask->save();
            }

        // send notification to contractor
        $link = route('job.detail',['requested' => 'requested', 'id' => $newJob->id]);
        Mail::to($user->email)->send(new NotificationEmail("A job has been created for you.",$link));

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

        $jobtypes = Jobtype::all();
        $jobtype_arr = array();
        foreach($jobtypes as $jobtype) {
            $jobtype_arr[$jobtype->id] = $jobtype->job_type;
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
        ],['clients' => $client_arr, 'stores' => $store_arr, 'staff' => $staff, 'contractors' => $contractor_arr, 'create_form' => false, 'job_types' => $jobtype_arr]);

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

        return view('jobs::edit', compact('form'))
               ->with('entity', $job)
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

        $jobtypes = Jobtype::all();
        $jobtype_arr = array();
        foreach($jobtypes as $jobtype) {
            $jobtype_arr[$jobtype->id] = $jobtype->job_type;
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
        ],['clients' => $client_arr, 'stores' => $store_arr, 'staff' => $staff, 'contractors' => $contractor_arr, 'create_form' => true, 'job_types' => $jobtype_arr]);

        $tasks = Task::where('job_id',$id)->get();
        $taskArr = array();
        foreach ($tasks as $task) {
        	//$taskJson = { 'title': $task->task, 'done': $task->status};
        	$taskJson = new \stdClass();
        	$taskJson->title = $task->task;
        	$taskJson->done = $task->status ? true : false;
        	array_push($taskArr,$taskJson);
        }
		unset($this->showFields['basic_information']['job_number']);
        return view('jobs::edit', compact('form'))
               ->with('entity', $job)
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
        $newJob->client_order_number = $request->client_order_number;
        $newJob->excel_job_number = $request->excel_job_number;
        $newJob->client_id = $request->client_id;
        $newJob->store_id = $request->store_id;
        $newJob->due_date = $request->due_date;
        $newJob->assigned_to = $request->assigned_to;
        $newJob->priority = $request->priority;
        $newJob->status = $request->status;
        $newJob->contractor_id = $request->contractor_id;
        $newJob->job_type = $request->job_type;
        $newJob->note = $request->note;
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

            'job_number' => [
                'type' => 'static'
            ],
            'client_order_number' => [
                'type' => 'text'
            ],
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
          ],
        'note' => [

            'note' => [
                'type' => 'text'
            ]
          ]
    ];

    public function signcontract(){
       $image = '';

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
