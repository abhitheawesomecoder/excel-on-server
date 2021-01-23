<?php

namespace Modules\Contractorprofile\Http\Controllers;

use Spipu\Html2Pdf\Html2Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Jobs\Entities\Job;
use Modules\Jobs\Entities\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Modules\Clients\Entities\Store;
use Modules\Clients\Entities\Client;
use Modules\Clients\Entities\Contact;
use Illuminate\Support\Facades\Auth;
use Modules\Jobs\Http\Forms\AddJobForm;
use Kris\LaravelFormBuilder\FormBuilder;
use Modules\Contractors\Entities\Contractor;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Contractorprofile\DataTables\JobDataTable;
use Modules\Contractorprofile\Http\Forms\AddSignatureForm;

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
    public function requested_confirmed(Request $request, $id){
        //echo $id;
        //echo $request->due_date;
        $job = Job::find($request->_todo);
        $job->status = 2;
        $job->due_date = $request->due_date;
        $job->save();

        return redirect()->route('job.status','confirmed');
        // change status of job to confirmed
    }
    public function save(Request $request)
    {  $userId = Auth::user()->id;
       $contractor = Contractor::where('user_id',$userId)->first();
       $job = Job::find($request->_id);
       $client = Client::find($job->client_id);
       $store = Store::find($job->store_id);
       $contact = Contact::where('client_id', $client->id)->first();

       $content = view('contractorprofile::test',['path' => $request->_signature, 'contractor' => $contractor, 'job' => $job, 'client' => $client, 'store' => $store, 'contact' => $contact])->render();

       $content2 = view('contractorprofile::test2',['path' => $request->_signature])->render();
       //$content = ob_get_clean(); 
       $html2pdf = new Html2Pdf('P', 'A4', 'en');
       $html2pdf->pdf->SetDisplayMode('fullpage');
       $html2pdf->writeHTML($content);
       $html2pdf->writeHTML($content2);
      //$html2pdf->pdf->AddPage();
      /*$job = Job::find($request->_id);
      $html2pdf->writeHTML("<h5>Job Number : ".$job->excel_job_number."</h5>");
      $html2pdf->writeHTML("<h5>Task</h5>");
      $tasks = Task::where('job_id',$request->_id)->get();
      $count = 25;
      $html2pdf->pdf->Line(5,$count, 40, $count);
      $count = $count+5;
      foreach ($tasks as $task) {
          //$html2pdf->writeHTML($task->task);
          //$html2pdf->writeHTML('<br>');
          $html2pdf->pdf->Text(5, $count, $task->task);
          $count = $count+5;
      }
      $html2pdf->writeHTML('<page_footer> <img src="'.$request->_signature.'" alt="signature" width="130" height="130"> </page_footer>');*/
      //$html2pdf->pdf->Image($image,150,40,40,40);
      //$html2pdf->writeHTML('<page_footer>'..'</page_footer>');
      $html2pdf->output();
    }
    public function signature($id, FormBuilder $formBuilder)
    {   $form = $formBuilder->create(AddSignatureForm::class, [
            'method' => 'POST',
            'url' => route('signature.save'),
            'id' => 'module_form'
        ],['job_id' => $id]);
        return view('jobs::sign',compact('form'));
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
            'method' => 'PATCH',
            'url' => route('job.requested.confirmed',$id),
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
        if ($requested == "confirmed") {
            return view('contractorprofile::create', compact('form'))
               ->with('show_fields', $this->showFields)
               ->with(compact('title','subtitle','id'))
               ->with('appconfirmedjs',json_encode($taskArr));
        }
        return view('contractorprofile::create', compact('form'))
               ->with('show_fields', $this->showFields)
               ->with(compact('title','subtitle','id'))
               ->with('apprequestedjs',json_encode($taskArr));
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
