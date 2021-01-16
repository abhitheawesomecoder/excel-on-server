<?php

namespace Modules\Clients\DataTables;


use Modules\Clients\Entities\Store;
use Modules\Clients\Entities\Storecontact;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Support\Facades\Auth;

class StoreDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {   $editUrl = route('stores.index');

    $optionstr = '<a class="btn btn-info waves-effect" href="'.$editUrl.'/{{$id}}">View</a>';

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
    public function query(Store $model)
    {
        $query = $model->newQuery();
        $newQuery = $query->select([
                'stores.id as id',
                'stores.store_name as store_name',
                'stores.address1 as address1',
                'stores.city as city',
                'stores.postcode as postcode',
                'storecontacts.phone_no as phone_no',
                'storecontacts.email as email',
                'stores.store_id as store_id',
                'storecontacts.store_id as storeid'
            ])
            ->leftjoin('storecontacts', 'storecontacts.store_id', '=', 'stores.id');
            
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
                    ->setTableId('store-table')
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
            Column::make('store_id'),
            Column::make('store_name'),
            Column::make('address1'),
            Column::make('city'),
            Column::make('postcode'),
            Column::make('phone_no','storecontacts.phone_no'),
            Column::make('email','storecontacts.email')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Store_' . date('YmdHis');
    }
}
