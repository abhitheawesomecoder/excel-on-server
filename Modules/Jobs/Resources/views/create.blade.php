@extends('layouts.app')

@section('content')
<div class="header">
                    <h2>
                        <div class="header-buttons">
                           @if($title == 'core.jobs.view.title')
                            @if(Auth::user()->hasRole('Super Admin'))
                            <a href="{{route('jobs.index').'/'.$id.'/delete'}}" title="Delete" class="btn btn-primary btn-back btn-crud">Delete</a>
                            @endif
                            <a href="{{route('jobs.edit',$id)}}" title="Edit" class="btn btn-primary btn-back btn-crud">Edit</a>
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
   @if(isset($appjs))
    <script type="text/javascript">
        $(document).ready(function () {
            
            $('#billing_address_same_as_company_address').change(function() {

            if($(this).is(":checked")) {
                
                $('#billing_address1').val($('#company_address1').val());
                $('#billing_address2').val($('#company_address2').val());
                $('#billing_city').val($('#company_city').val());
                $('#billing_postcode').val($('#company_postcode').val());
                
            }else{

                $('#billing_address1').val('');
                $('#billing_address2').val('');
                $('#billing_city').val('');
                $('#billing_postcode').val('');

            }
                    
        });

        });
    </script>
   @endif
@endpush