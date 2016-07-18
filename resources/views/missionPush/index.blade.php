@extends('template')

@section('title', 'Download')

@section('content')
    <div id="coming-soon" class="small-10 small-centered columns text-center">
        <div class="logo"></div>
        <p>
            <div id="output" style="color: #000;">
                Connecting to Updater
            </div>
            <input type="text" name="name" id="missionText" />
            <input type="button" class="button" name="name" value="Testing" onclick="missionStarting()">
            <br />
            <input type="button" class="button" name="name" value="QuitAllClients" onclick="quitAllClients()">
        </p>
    </div>
@stop


@section('scripts')
<script language="javascript" type="text/javascript">
        var IP;

        $(function() {
            $.getJSON("https://api.ipify.org?format=jsonp&callback=?",
              function(json) {
                IP = json.ip;
              }
            );
        });

        function missionStarting() {
            var missionText = $('#missionText').val();
            doSend("Updater" + "|" + "*" + "|" + "Broadcast" + "|" + missionText);
        }
        function quitAllClients() {
            doSend("Updater" + "|" + "*" + "|" + "Quit");
        }

       var wsUri = "{{ getenv('APP_SCARLET_WS') }}";
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
       }

       function onClose(evt)
       {
           testWebSocket();
       }

       function onMessage(evt)
       {
           console.log(evt.data)
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

            output.innerHTML = message;
       }

       window.addEventListener("load", init, false);

 </script>
@stop
