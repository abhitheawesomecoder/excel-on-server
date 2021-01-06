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
	<div style="width:50%">
    {!! form($form) !!}
    </div>
</div>

    
@endsection
