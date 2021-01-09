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

        $optionstr = '<a class="btn btn-info waves-effect" href="'.$editUrl.'/{{$id}}">View</a> <a class="btn btn-info waves-effect" href="'.$editUrl.'/{{$id}}/edit">Edit</a>';

        if(Auth::user()->hasRole('Super Admin'))
            $optionstr = '<a class="btn btn-info waves-effect" href="'.$editUrl.'/{{$id}}">View</a> <a class="btn btn-info waves-effect" href="'.$editUrl.'/{{$id}}/edit">Edit</a> <a class="btn btn-info waves-effect" href="'.$editUrl.'/{{$id}}/delete">Delete</a>';

        return datatables()
            ->eloquent($query)
            /*->addColumn('action', '<div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="'.$editUrl.'/{{$id}}/edit">Edit</a></li>
                                        <li><a href="'.$editUrl.'/{{$id}}/delete">Delete</a></li>
                                    </ul>
                                </div>');*/
            ->addColumn('action', $optionstr)
            ->editColumn('priority', function($item) { if($item->priority == 4) return "high"; });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Job $model)
    {
        return $model->newQuery();
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
            Column::make('priority')
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
