@extends('layouts.app')

@section('content')


    <div class="row">

        <div id="calendar-container" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        	{!! $calendar->calendar() !!}
        </div>

    </div>
@endsection

@push('css-up')

   <link href="{{ asset('css/fullcalendar.print.css') }}" rel="stylesheet" media="print">
   <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">

@endpush

@push('scripts')

<script src="{{ asset('js/fullcalendar.js') }}"></script>
<script src="{{ asset('js/locale-all.js') }}"></script>
{!! $calendar->script() !!}

@endpush