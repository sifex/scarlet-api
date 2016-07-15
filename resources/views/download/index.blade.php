@extends('template')

@section('title', 'Download')

@section('content')
    <div id="coming-soon" class="small-10 small-centered columns text-center">
        <div class="logo"></div>
        <p>
            <div id="output">
                Connecting to Updater
            </div>
            <input type="button" name="name" value="Testing" onclick="doSend('Sending Test Message')">
        </p>
    </div>
@endsection


@section('scripts')
<script language="javascript" type="text/javascript">

       var wsUri = "ws://scarlet.australianarmedforces.org:8080";
       var output;

       function init()
       {
       output = document.getElementById("output");
       testWebSocket();
       }

       function testWebSocket()
       {
       websocket = new WebSocket(wsUri);
       websocket.onopen = function(evt) { onOpen(evt) };
       websocket.onclose = function(evt) { onClose(evt) };
       websocket.onmessage = function(evt) { onMessage(evt) };
       websocket.onerror = function(evt) { onError(evt) };
       }

       function onOpen(evt)
       {
       writeToScreen("CONNECTED");
       }

       function onClose(evt)
       {
       writeToScreen("DISCONNECTED");
       }

       function onMessage(evt)
       {
       writeToScreen('<span style="color: blue;">RESPONSE: ' + evt.data+'</span>');
       }

       function onError(evt)
       {
       writeToScreen('<span style="color: red;">ERROR:</span> ' + evt.data);
       }

       function doSend(message)
       {
       writeToScreen("SENT: " + message);
       websocket.send(message);
       }

       function writeToScreen(message)
       {
       var pre = document.createElement("p");
       pre.style.wordWrap = "break-word";
       pre.innerHTML = message;
       output.innerHTML = message;
       }

       window.addEventListener("load", init, false);

 </script>
@endsection
