<?php

namespace Modules\Jobs\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Jobs\Entities\Jobtype;
use Kris\LaravelFormBuilder\FormBuilder;
use Modules\Jobs\Http\Forms\AddJobtypeForm;
use Modules\Jobs\DataTables\JobtypeDataTable;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class JobtypeController extends Controller
{
    use FormBuilderTrait;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(JobtypeDataTable $dataTable)
    {
        return $dataTable->render('signup::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {
      
        $form = $formBuilder->create(AddJobtypeForm::class, [
            'method' => 'POST',
            'url' => route('jobtypes.store')
        ]);
        $title  = 'core.jobtype.create.title';
        $subtitle = 'core.jobtype.create.subtitle';

        return view('core::signupemailrequest', compact('form'))
                ->with(compact('title','subtitle'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $form = $this->form(AddJobtypeForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $newJobtype = new Jobtype;
        $newJobtype->job_type = $request->job_type;
        $newJobtype->save();

        return redirect()->route('jobtypes.index');
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
}
