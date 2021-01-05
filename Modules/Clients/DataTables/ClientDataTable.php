<?php

namespace Modules\Clients\DataTables;


use Modules\Clients\Entities\Client;
use Modules\Clients\Entities\Contact;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;

class ClientDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {   $editUrl = route('clients.index');
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
            ->addColumn('action', '<a class="btn btn-info waves-effect" href="'.$editUrl.'/{{$id}}">View</a> <a class="btn btn-info waves-effect" href="'.$editUrl.'/{{$id}}/edit">Edit</a>');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Client $model)
    {
        //return $model->newQuery();
        $query = $model->newQuery();
        $newQuery = $query->select([
                'clients.id as id',
                'clients.account_number as account_number',
                'clients.client_name as client_name',
                'users.name as assigned_to',
                'contacts.email as email',
                'contacts.phone_no as phone_no',
            ])
            //->leftJoin('contacts', 'contacts.client_id', '=', 'clients.id')
            //->leftjoin('contacts', 'contacts.assigned_to', '=', 'users.id')
            ->leftJoin('users', 'clients.assigned_to', '=', 'users.id')
            ->leftjoin('contacts', 'contacts.client_id', '=', 'clients.id');
            
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
                    ->setTableId('client-table')
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
            Column::make('account_number'),
            Column::make('client_name'),
            Column::make('email','contacts.email'),
            Column::make('phone_no','contacts.phone_no'),
            Column::make('assigned_to','users.name')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Client_' . date('YmdHis');
    }
}
