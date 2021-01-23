@extends('layouts.app')

@section('content')
<div class="header">
                    <h2>
                        <div class="header-buttons">
                           @if($title == 'core.jobs.view.title')
                            @if(Auth::user()->hasRole('Super Admin'))
                            <a href="{{route('jobs.index').'/'.$id.'/delete'}}" title="Delete" class="btn btn-primary btn-back btn-crud">Delete</a>
                            @endif
                            @if($entity->status == 4)
                            <a id="sign" href="{{route('user.job.signature',$id)}}" title="Sign" class="btn btn-primary btn-back btn-crud">Sign</a>
                            <a id="job_done" href="" title="Job Done" class="btn btn-primary btn-back btn-crud">Job Done</a>
                            @endif
                            <a href="{{route('jobs.clone',$id)}}" title="Clone" class="btn btn-primary btn-back btn-crud">Clone</a>
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
   @if(isset($appviewjs))
    <script type="text/javascript">
        $(document).ready(function () {

        $("#sign").hide();
        $("#job_done").click(function(e) {
            e.preventDefault();
            $("#job_done").hide();
            $("#sign").show();
        }); 
            
        $('#description').replaceWith("<div id='description'></div>");
           
        $("#description").todoList({ title: "",items: JSON.parse('{!! $appviewjs !!}') });
            
        });
    </script>
   @endif
   @if(isset($appeditjs))
    <script type="text/javascript">
        $(document).ready(function () {
            
        $('#description').replaceWith("<div id='description'></div>");
           
        $("#description").todoList({ title: "",items: JSON.parse('{!! $appeditjs !!}') });
        $("#module_form").on("submit", function(event){
            

        if($('#excel_job_number').val() == '')
            alert("excel job number is required");
        else{
        $('input[name ="_todo"]').val(JSON.stringify($("#description").todoList("getSetup").items));
        $("#module_form").submit();  
        } 
              
        });

        $("#module_form").on("keypress", function(event){

          if(event.key == "Enter"){
            $(".jquery-todolist-add-action").first().click();
            event.preventDefault();
          }
        });
            
        });
    </script>
   @endif
   @if(isset($appjs))
    <script type="text/javascript">
        $(document).ready(function () {
           
        $('#description').replaceWith("<div id='description'></div>");
           
        $("#description").todoList({title: ""});
        $("#module_form").on("submit", function(event){
            

        if($('#excel_job_number').val() == '')
            alert("excel job number is required");
        else{
        $('input[name ="_todo"]').val(JSON.stringify($("#description").todoList("getSetup").items));
        $("#module_form").submit();  
        } 
              
        });

        $("#module_form").on("keypress", function(event){

          if(event.key == "Enter"){
            $(".jquery-todolist-add-action").first().click();
            event.preventDefault();
          }
        });

        });
    </script>
   @endif
@endpush