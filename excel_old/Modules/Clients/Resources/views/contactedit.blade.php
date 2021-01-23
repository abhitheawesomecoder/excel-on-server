@extends('layouts.app')

@section('content')

<div class="header">
                    <h2>
                        <div class="header-buttons">
                            @if($title == 'core.contact.view.title')
                            @if(Auth::user()->hasRole('Super Admin'))
                            <a href="{{route('contacts.index').'/'.$id.'/delete'}}" title="Delete" class="btn btn-primary btn-back btn-crud">Delete</a>
                            @endif
                            <a href="{{route('contacts.edit',$id)}}" title="Edit" class="btn btn-primary btn-back btn-crud">Edit</a>
                           @endif
                        </div>

                        <div class="header-text">
                            @lang($title)<small>@lang($subtitle)</small>
                        </div>
                    </h2>
                </div>
<div class="body">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="row">
                                        
{!! form_start($form) !!}    
@foreach($show_fields as $panelName => $panel)

    <div class="col-lg-12 col-md-12 col-sm-12">
                                    <h2 class="card-inside-title">
        {{ str_replace("_"," ",$panelName) }}
        <div class="section-buttons">
                                    </div>
    </h2> </div>


        @foreach ($panel as $fieldName => $options )
            @if($loop->iteration % 2 == 0)
            <div class="col-lg-6 col-md-6 col-sm-6">
            @else
            <div class="col-lg-6 col-md-6 col-sm-6 clear-left">
            @endif
                {!! form_row($form->{$fieldName}) !!}
            </div>   
        @endforeach
@endforeach
{!! form_end($form, $renderRest = true) !!}
                                                              

</div>     
</div>
@endsection

@push('scripts')
    <script type="text/javascript">
        (function ($, DataTable) {
            DataTable.ext.buttons.create = {
                className: 'buttons-create',

                text: function (dt) {
                    return '<i class="fa fa-plus"></i> ' + dt.i18n('buttons.create', 'Create');
                },

                action: function (e, dt, button, config) {
                    window.location = '{{ route("storecontacts.create",1) }}';
                }
            };
        })(jQuery, jQuery.fn.dataTable);
    </script>

@endpush
