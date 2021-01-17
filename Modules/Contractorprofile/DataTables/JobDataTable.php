<?php

namespace Modules\Contractorprofile\DataTables;

use Modules\Jobs\Entities\Job;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Support\Facades\Auth;
//use Modules\Contractors\Entities\Contractor;

class JobDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $editUrl = route('job.requested',0);

        $editUrl = rtrim($editUrl,'/0');

        return datatables()
            ->eloquent($query)
            ->addColumn('action', '<a class="btn btn-info waves-effect" href="'.$editUrl.'/{{$id}}">View</a>');

        return datatables()
            ->eloquent($query)
            ->addColumn('action', $optionstr);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Job $model)
    {   $id = Auth::user()->id;
        //$cid = Contractor::where('user_id',$id)->first();


        $query = $model->newQuery();
        $newQuery = $query->select([
                'jobs.id as id',
                'jobs.excel_job_number as excel_job_number',
                'jobs.due_date as due_date',
                'clients.client_name as client_name',
                'jobs.status as status',
                'jobs.job_type as job_type',
                'jobs.priority as priority',
                'contractors.company_name as contractor',
            ])
            ->leftJoin('clients', 'clients.id', '=', 'jobs.client_id')
            ->leftjoin('contractors', 'contractors.id', '=', 'jobs.contractor_id')
            ->where(function ($q) {
                if($this->status == 'requested')
                  $q->where('jobs.status', 1);
                elseif($this->status == 'confirmed')
                  $q->whereBetween('jobs.status', [2,4]);
                elseif($this->status == 'completed')
                  $q->where('jobs.status', 5);
            });
            //->where('jobs.status',$this->status)
            
            
        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('job-requested-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('excel_job_number'),
            Column::make('due_date'),
            Column::make('client_name'),
            Column::make('status'),
            Column::make('job_type'),
            Column::make('priority'),
            Column::make('contractor')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'JobRequested_' . date('YmdHis');
    }
}
