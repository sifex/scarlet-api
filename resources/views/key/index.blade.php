@extends('template')

@section('title', 'Enter Key')

@section('content')
<div id="coming-soon" class="small-10 small-centered columns text-center">
    <p>
        <div id="output" style="text-align: left; color: #EEE;">
			Please enter your Scarlet Key
        </div>
        <form class="" action="/auth" method="post">

           <input type="hidden" name="_token" value="{{ csrf_token() }}">
    		<input class="cleave" type="text" name="key" value="" style="border-radius: 4px;">
            <input class="button" type="submit" name="name" value="Submit Key">
        </form>
    </p>
</div>
@endsection


@section('scripts')

@endsection
