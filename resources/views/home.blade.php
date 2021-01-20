@extends('layouts.app')

@section('content')
<div style="padding:40px">
                <h3>Dashboard</h3>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
 </div>            
@endsection
