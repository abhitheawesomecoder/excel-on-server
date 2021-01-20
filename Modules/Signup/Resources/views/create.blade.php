@extends('layouts.app')

@section('content')

<div class="header">
                    <h2>
                        <div class="header-buttons">
                            @if($title == 'core.user.view.title')
                            @if(Auth::user()->hasRole('Super Admin'))
                            <a href="{{route('users.index').'/'.$id.'/delete'}}" title="Delete" class="btn btn-primary btn-back btn-crud">Delete</a>
                            @endif
                            <a href="{{route('users.edit',$id)}}" title="Edit" class="btn btn-primary btn-back btn-crud">Edit</a>
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
	<div style="width:50%">
    {!! form($form) !!}
    </div>
</div>

    
@endsection
