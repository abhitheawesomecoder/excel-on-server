<?php

namespace Modules\Jobs\DataTables;

use Modules\Jobs\Entities\Job;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Support\Facades\Auth;

class JobOnlyDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {   $editUrl = route('jobs.index');

    //$optionstr = '<a class="btn btn-info waves-effect" href="'.$editUrl.'/{{$id}}">View</a>';
        $optionstr = '<input style="opacity:1" class="invoice_rec" type="checkbox" id="job{{$id}}" name="job{{$id}}" value="{{$id}}" {{ $invoice_received }} >';
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
    {
        //return $model->newQuery();

        $query = $model->newQuery();
        $newQuery = $query->select([
                'jobs.id as id',
                'jobs.invoice_received as invoice_received',
                'jobs.job_number as job_number',
                'jobs.excel_job_number as excel_job_number',
                'jobs.due_date as due_date',
                'clients.client_name as client_name',
                'jobs.status as status',
                'jobtypes.job_type as job_type',
                'jobs.priority as priority',
                'contractors.company_name as contractor',
            ])
            //->leftJoin('contacts', 'contacts.client_id', '=', 'clients.id')
            //->leftjoin('contacts', 'contacts.assigned_to', '=', 'users.id')
            ->leftJoin('jobtypes', 'jobtypes.id', '=', 'jobs.job_type')
            ->leftJoin('clients', 'clients.id', '=', 'jobs.client_id')
            ->leftjoin('contractors', 'contractors.id', '=', 'jobs.contractor_id')
            ->where('contractor_id',$this->contractor_id);
            
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
            Column::computed('action','Invoice Rec.')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60),
            Column::make('job_number'),
            Column::make('excel_job_number')
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
