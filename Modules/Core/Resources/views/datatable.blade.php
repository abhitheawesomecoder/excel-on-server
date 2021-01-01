
{{ $datatable->table(['width' => '100%']) }}

@push('scripts')

{!! $datatable->scripts() !!}

@endpush

@push('scripts')
    <script type="text/javascript">
    	if('{{$view}}' == 'contact'){
        (function ($, DataTable,view) {
            DataTable.ext.buttons.create = {
                className: 'buttons-create',

                text: function (dt) {
                    return '<i class="fa fa-plus"></i> ' + dt.i18n('buttons.create', 'Create');
                },

                action: function (e, dt, button, config) {
                    window.location = '{{ route("contactscreate",1) }}';
                }
            };
        })(jQuery, jQuery.fn.dataTable);
    }else{
    	(function ($, DataTable,view) {
            DataTable.ext.buttons.reload = {
                className: 'buttons-reload',

                text: function (dt) {
                    return '<i class="fa fa-plus"></i> ' + dt.i18n('buttons.reload', 'Create');
                },

                action: function (e, dt, button, config) {
                    window.location = '{{ route("storescreate",1) }}';
                }
            };
        })(jQuery, jQuery.fn.dataTable);
    }
    </script>
@endpush
