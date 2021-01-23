
{{ $datatable->table(['width' => '100%']) }}

@push('scripts')

{!! $datatable->scripts() !!}

@endpush
@if(isset($view))
@push('scripts')
    <script type="text/javascript">
        if('{{$view}}' == 'jobs'){
            $(document).ready(function () {
                $(document).on('change', '.invoice_rec', function() {
                status = '';
                if($(this).is(":checked")) 
                    status = 'checked';

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: "{{route('invoice.received')}}",
                        data: {status: status, job_id: $(this).val() },
                        success: function (commentsArray) {
                            //success(commentsArray)
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                
                }); 
           }); 
        }
    	else if('{{$view}}' == 'contact'){
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
@endif
