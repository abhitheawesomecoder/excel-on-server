@extends('layouts.app')

@section('content')
<div class="header">
                    <h2>
                        <div class="header-buttons">
                           @if($title == 'core.job.requested.title')
<a id="accept" href="" title="Accept" class="btn btn-primary btn-back btn-crud">Accept</a>
<a id="confirm" href="{{route('job.requested.confirmed',$id)}}" title="Confirm" class="btn btn-primary btn-back btn-crud">Confirm</a>
                           @elseif($title == 'core.job.confirmed.title')
<a id="sign" href="{{route('job.signature',$id)}}" title="Sign" class="btn btn-primary btn-back btn-crud">Sign</a>                    
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


    @if(isset($appconfirmedjs))
    <script type="text/javascript">
        $(document).ready(function () {

        $('#description').replaceWith("<div id='description'></div>");   
        $("#description").todoList({ title: "",items: JSON.parse('{!! $appconfirmedjs !!}') });

        });
    </script>
   @endif

   @if(isset($apprequestedjs))
    <script type="text/javascript">
        $(document).ready(function () {
        $('#confirm').hide();
        $('#due_date').on("dp.change", function (e) {console.log("change");});
        $('#due_date').on("dp.show", function (e) {
            console.log("show");
            $('#due_date').data("DateTimePicker").minDate(e.date);
        });
        $('#due_date').on("dp.hide", function (e) {
            console.log("hide");
            $('#confirm').show();
            $('#accept').hide();
        });
        $('#description').replaceWith("<div id='description'></div>");   
        $("#description").todoList({ title: "",items: JSON.parse('{!! $apprequestedjs !!}') });
        $("#accept").click(function(e) {
            e.preventDefault();
            $("#due_date").datetimepicker('show');
        });
        });
    </script>
   @endif

@endpush