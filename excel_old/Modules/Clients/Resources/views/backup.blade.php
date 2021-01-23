@extends('layouts.app')

@section('content')

<div class="header">
                    <h2>
                        <div class="header-buttons">
                            
                        </div>

                        <div class="header-text">
                            Signup - Mail                            <small>Send Mail for user signup</small>
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
        <ul class="nav nav-tabs tab-nav-right tabs-left" role="tablist">
            <li role="presentation">
                <a href="#tab_details" data-toggle="tab" title="Details"> <i class="material-icons">folder</i> Details </a>
            </li>
            <li role="presentation" class="active">
                <a href="#tab_documents" data-toggle="tab" title="Store List"> <i class="material-icons">storage</i> Store List </a>
            </li>
            <li role="presentation">
                <a href="#tab_comments" data-toggle="tab" title="Comments"> <i class="material-icons">chat</i> Comments </a>
            </li>
            <li role="presentation">
                <a href="#tab_attachments" data-toggle="tab" title="Attachments"> <i class="material-icons">attach_file</i> Attachments </a>
            </li>
            <li role="presentation">
                <a href="#tab_updates" data-toggle="tab" title="Activity Log"> <i class="material-icons">change_history</i> Activity Log </a>
            </li>
        </ul>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-10">
        <div class="tab-content">

            <div role="tabpanel" class="tab-pane" id="tab_details">
                <div class="col-lg-12 col-md-12"> </div>

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

    <div role="tabpanel" class="tab-pane active" id="tab_documents">
        <div class="col-lg-12 col-md-12"> </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    store 
                </div>   
            list
    </div>

    <div role="tabpanel" class="tab-pane" id="tab_comments">
        <div class="related_module_wrapper">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    comment
                </div>   
            </div>
        </div>   
    </div>

    <div role="tabpanel" class="tab-pane" id="tab_attachments">
        <div class="related_module_wrapper">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    attach
                </div>   
            </div>
        </div>   
    </div>

    <div role="tabpanel" class="tab-pane" id="tab_updates">

        <div class="table-responsive col-lg-12 col-md-12">
            update
        </div>
    </div>



</div>

</div>   
</div>
@endsection
