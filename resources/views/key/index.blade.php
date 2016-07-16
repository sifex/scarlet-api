@extends('template')

@section('title', 'Enter Key')

@section('content')
<div id="coming-soon" class="small-10 small-centered columns text-center">
    <div class="logo"></div>
    <p>
        <div id="output" style="text-align: left; color: #EEE;">
			Please enter your Scarlet Key
        </div>
		<input class="cleave" type="text" name="key" value="" style="border-radius: 4px;">
    </p>
</div>
<div class="small-10 small-centered columns">
    <p>
        <input class="button" type="button" name="name" value="Submit Key" onclick="submitKey()">
        <div class="result"></div>
    </p>
</div>
@endsection


@section('scripts')
<script src="http://nosir.github.io/cleave.js/dist/cleave-0.4.7.min.js" charset="utf-8"></script>
<script type="text/javascript">
    function submitKey() {
        $.get( "http://scarlet.australianarmedforces.org/api/user/info/" + $(".cleave").val(), function( data ) {
            $( ".result" ).html( data );
            var keyConfirm = jQuery.parseJSON(data);
            if(keyConfirm.key == $(".cleave").val()) {
                window.location.replace("http://scarlet.australianarmedforces.org/download/");
            }
            alert( "Load was performed." );
        });
    }

</script>
@endsection
