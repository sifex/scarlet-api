@extends('template')

@section('title', 'Download')

@section('content')
    <div id="coming-soon" class="small-10 small-centered columns text-center">
        <div class="logo"></div>
        <p>
            <div class="data">
                Connecting to Updater
            </div>
        </p>
    </div>
@endsection


@section('scripts')
<script>
    $.get( "//download.australianarmedforces.org:9000/", function( data ) {
        $( ".data" ).html( data );
        alert( "Load was performed." );
    });
</script>
@endsection
