@extends('template')

@section('title', 'Enter Key')

@section('content')
<div id="coming-soon" class="small-10 small-centered columns text-center">
    <div class="logo"></div>
    <p>
        <div id="output" style="text-align: left; color: #EEE;">
			Please enter your Username
        </div>
        <form action="/auth" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input class="cleave" type="text" name="username" value="" style="border-radius: 4px;">
            <input class="button" type="submit" name="name" value="Login">
        </form>
    </p>
</div>
@stop


@section('scripts')
<script src="http://nosir.github.io/cleave.js/dist/cleave-0.4.7.min.js" charset="utf-8"></script>
<script type="text/javascript">

</script>
@stop
