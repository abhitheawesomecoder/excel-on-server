@extends('layouts.app')

@section('content')
<div style="padding:40px">
    {{$dataTable->table()}}
</div>
@endsection

@push('scripts')
    {{$dataTable->scripts()}}
@endpush