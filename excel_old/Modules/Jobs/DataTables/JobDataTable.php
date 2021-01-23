<?php

namespace Modules\Jobs\DataTables;

use Modules\Jobs\Entities\Job;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Support\Facades\Auth;

class JobDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {   $editUrl = route('jobs.index');

    $optionstr = '<a class="btn btn-info waves-effect" href="'.$editUrl.'/{{$id}}">View</a>';

        return datatables()
            ->eloquent($query)
            ->addColumn('action', $optionstr)
            ->editColumn('priority', function($item) { 
            	switch ($item->priority) {
            		case '1':
            			return "Low";
            		case '2':
            			return "Normal";
            		case '3':
            			return "High";
            		case '4':
            			return "Urgent";
            	}
            })
            ->editColumn('status', function($item) { 
            	switch ($item->status) {
            		case '1':
            			return "New";
            		case '2':
            			return "Confirmed by contractor";
            		case '3':
            			return "In progress";
            		case '4':
            			return "Waiting for response";
            		case '5':
            			return "Closed";
            	}
            })
            ->editColumn('job_type', function($item) { 
            	switch ($item->job_type) {
            		case '1':
            			return "Maintenance";
            		case '2':
            			return "Minor issue";
            		case '3':
            			return "Major issue";
            	}
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Job $model)
    {
        //return $model->newQuery();

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
            //->leftJoin('contacts', 'contacts.client_id', '=', 'clients.id')
            //->leftjoin('contacts', 'contacts.assigned_to', '=', 'users.id')
            ->leftJoin('clients', 'clients.id', '=', 'jobs.client_id')
            ->leftjoin('contractors', 'contractors.id', '=', 'jobs.contractor_id');
            
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
                    ->setTableId('job-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create')
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
        return 'Job_' . date('YmdHis');
    }
}
