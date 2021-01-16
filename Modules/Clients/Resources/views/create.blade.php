@extends('layouts.app')

@section('content')

<div class="header">
                    <h2>
                        <div class="header-buttons">
                           @if($title == 'core.clientcontact.create.title')
                            <a href="{{route('clients.index')}}" title="Skip" class="btn btn-primary btn-back btn-crud">Skip</a>
                           @elseif($title == 'core.storecontact.create.title')
                            <a href="{{route('clients.edit',$id).'#tab_stores'}}" title="Skip" class="btn btn-primary btn-back btn-crud">Skip</a>
                           @elseif($title == 'core.storecontact.view.title')
                            @if(Auth::user()->hasRole('Super Admin'))
                            <a href="{{route('stores.index').'/'.$id.'/delete'}}" title="Delete" class="btn btn-primary btn-back btn-crud">Delete</a>
                            @endif
                            <a href="{{route('stores.edit',$id)}}" title="Edit" class="btn btn-primary btn-back btn-crud">Edit</a>
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
            //BAP_Platform.copyAddress('{{ asset("/") }}');
            //copy code below to above function
            const client_id = $("input[name='_id']").val();
            const entityUrl = '{{ asset("/") }}';
            $('#address_same_as_client').change(function() {


            if($(this).is(":checked")) {
                //var returnVal = confirm("Are you sure?");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // get information of address from client and populate 
                $.ajax({
                    type: 'POST',
                    url: entityUrl+'clients/api/getaddress',
                    data: {clientId: client_id},
                    success: function (contact) {
                        //success(commentsArray)
                         $('#address1').val(contact.address1);
                         $('#address2').val(contact.address2);
                         $('#city').val(contact.city);
                         $('#postcode').val(contact.postcode);
                    }
                });

                
            }else{

                $('#address1').val('');
                $('#address2').val('');
                $('#city').val('');
                $('#postcode').val('');
                //alert("unchecked");


            }
                    
        });

        });
    </script>
   @endif
@endpush
