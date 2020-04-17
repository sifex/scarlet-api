@extends('template')

@section('title', 'Admin Panel')

@section('content')
	<div class="row">
	    <div id="coming-soon" class="small-12 small-centered columns">
			<div class="small-12 columns">
		        <div class="logo"></div>
		        <p>
		            <div id="output">
		                Connecting to Updater
		            </div>
				</p>
			</div>

            <div class="small-6 columns">
	            <input type="text" name="name" id="missionText" />
	            <input type="button" class="button" name="name" value="Send Message to all Clients" onclick="missionStarting()">
            </div>
			<div class="small-6 columns last">
	            <input style="margin-top: 0;" type="button" class="button secondary disabled" name="name" disabled="disabled" value="Quit All Clients">
	            <input style="margin-top: 0;" type="button" class="button warning" name="name" value="Restart All Clients" onclick="restartAllClients()">
	            <input style="margin-top: 0;" type="button" class="button alert" name="name" value="Force Verify All Clients" onclick="forceVerify()">
			</div>
	    </div>
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
            doSend("Updater" + "|" + "*" + "|" + "broadcast" + "|" + missionText);
        }
        function quitAllClients() {
            doSend("Updater" + "|" + "*" + "|" + "quit");
        }
        function restartAllClients() {
            doSend("Updater" + "|" + "*" + "|" + "restart");
        }

        function restartAllClients() {
            doSend("Updater" + "|" + "*" + "|" + "forceVerify");
        }

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
