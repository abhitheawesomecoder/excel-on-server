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
    public function show($id)
    {
        return view('contractorprofile::show');
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
}
