@extends('layouts.app')

@section('content')
<div class="header">
                    <h2>
                        <div class="header-buttons">
                           @if($title == 'core.job.requested.title')
<a id="accept" href="" title="Accept" class="btn btn-primary btn-back btn-crud">Accept</a>
<a id="confirm" href="" title="Confirm" class="btn btn-primary btn-back btn-crud">Confirm</a>
                           @elseif($title == 'core.job.confirmed.title')
                               
<a id="sign" href="{{route('job.signature',$id)}}" title="Sign" class="btn btn-primary btn-back btn-crud">Sign</a>
<a id="job_done" href="" title="Job Done" class="btn btn-primary btn-back btn-crud">Job Done</a>                               
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
    
    <div class="col-lg-2 col-md-2 col-sm-2">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs tab-nav-right tabs-left" role="tablist">
            <li role="presentation" class="active"><a href="#tab_details" data-toggle="tab"><i class="material-icons">folder</i>Details</a></li>
            <li role="presentation"><a href="#profile" data-toggle="tab"><i class="material-icons">attach_file</i>Attachments</a></li>
            
        </ul>
    </div>
                            <div class="col-lg-10 col-md-10 col-sm-10">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="tab_details">

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
                                <div role="tabpanel" class="tab-pane fade" id="profile">
                                     <div class="col-lg-12 col-md-12">
                                            @include('attachments')
                                     </div>
                                </div>
                                
                            </div>
                            </div>
</div>   
</div>
@endsection

@push('scripts')


    @if(isset($appconfirmedjs))
    <script type="text/javascript">
        $(document).ready(function () {
        $("#sign").hide();
        $("#job_done").click(function(e) {
            e.preventDefault();
            $("#job_done").hide();
            $("#sign").show();
        }); 

        $('#description').replaceWith("<div id='description'></div>");   
        $("#description").todoList({ title: "",items: JSON.parse('{!! $appconfirmedjs !!}') });
        $(".jquery-todolist-footer").hide();
        $(".jquery-todolist-item-action-remove").hide();
        $("#description").on("todolist-change", function(ev, options, $ui){
            /*console.log(JSON.stringify($.extend(true, options.items, $("#description").todoList("getSetup").items )))*/
            //console.log(options.items);
            _dataData = JSON.stringify($.extend(true, options.items, $("#description").todoList("getSetup").items ));

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{route('task.done')}}",
                data: {taskData : _dataData },
                success: function (commentsArray) {
                    //success(commentsArray)
                },
                error: function (e) {
                    console.log(e);
                }
            });

        });

        /*
        user clicks "Job Done" which hides "Job Done" button and shows sign button
        on clicking sign button sign screen comes
        once signature is done and saved then signature is saved with job id
        and job done notification is sent
        job status changes to waiting for response
        user gets option to sign and mark job complete
        user gets job done button and then sign button


        $("#accept").click(function(e) {
            e.preventDefault();
            console.log($("#due_date").datetimepicker());
        });*/

        });
    </script>
   @endif

   @if(isset($apprequestedjs))
    <script type="text/javascript">
        $(document).ready(function () {
        //$("input[name=_todo]").val("{{$id}}");
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
        $("#confirm").click(function(e) {
            e.preventDefault();
            $("#module_form").submit();
        });
        });
    </script>
   @endif

@endpush