@extends('layouts.app')

@section('content')

<div class="header">
                    <h2>
                        <div class="header-buttons">
                            
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
            <li role="presentation"><a href="#tab_contacts" data-toggle="tab"><i class="material-icons">contacts</i>Contacts</a></li>
            <li role="presentation"><a href="#tab_comments" data-toggle="tab"><i class="material-icons">chat</i>Comments</a></li>
            <li role="presentation"><a href="#profile" data-toggle="tab"><i class="material-icons">attach_file</i>Attachments</a></li>
            <li role="presentation"><a href="#tab_stores" data-toggle="tab"><i class="material-icons">store</i>Stores</a></li>
            
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
                                <div role="tabpanel" class="tab-pane fade" id="tab_contacts">
                                     <div class="col-lg-12 col-md-12">
                                            @include('core::datatable',['datatable' => $contactTable,'view' => 'contact'])
                                     </div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="tab_comments">
                                     <div class="col-lg-12 col-md-12">
                                            @include('core::comments')
                                     </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="profile">
                                     <div class="col-lg-12 col-md-12">
                                            @include('attachments')
                                     </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab_stores">
                                    <div class="col-lg-12 col-md-12">
                                            @include('core::datatable',['datatable' => $dataTable,'view' => 'store'])
                                     </div>
                                </div>
                                
                            </div>
                            </div>
                        

</div>     
</div>
@endsection
