@extends('template')

@section('title', 'Download')

@section('content')
<div id="coming-soon" class="small-10 small-centered columns text-center">
    <div class="logo"></div>
    <p>
        <div id="output">
            Connecting to Updater
        </div>
        <div class="progress" role="progressbar" tabindex="0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-meter"></div>
        </div>
    </p>
</div>
<div class="small-10 small-centered columns">
    <p>
        <span class="status"> </span> - <span class="file"> </span><br />
        <input class="button disabled" disabled="disabled" type="button" name="name" value="Start Download" onclick="startDownload()">
    </p>
</div>
@endsection


@section('scripts')
    <script language="javascript" type="text/javascript">
        var IP;
        var connected = false;
        var connectedNo = 1;

        $(function() {
            $.getJSON("https://api.ipify.org?format=jsonp&callback=?",
            function(json) {
                IP = json.ip;
            }
        );
        });

        var downloadLocation = "C:/Users/Alex/Desktop";

        function startDownload() {
            doSend("Updater" + "|" + IP + "|" + "startDownload" + "|" + downloadLocation);
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
            writeToScreen("Connected to Scarlet Servers");
            browserConnect();
        }

        function onClose(evt)
        {
            testWebSocket();
        }

        function browserConnect() {
            setTimeout(function () {
                        doSend("Updater" + "|" + IP + "|" + "browserConnect");
                connectedNo++;
                if (connected == false) {
                    if(connectedNo < 50) {
                        browserConnect();
                        console.log("Updater Ping - Not Connected");
                    }
                    else {
                        writeToScreen("Could not Connect to Updater");
                    }
                }
                else {
                    writeToScreen("Connected to Updater");
                    console.log("Updater Ping - Connected");
                    $('input').removeAttr("disabled");
                    $('input').removeAttr("class");
                    $('input').attr("class", "button");
                }
            }, 2000);
        }

        function onMessage(evt)
        {
            var array = evt.data.split("|");
            if(array[0] == "Browser") {
                if(array[1] == IP) {
                    if(array[2] == "browserConfirmation") {
                        connected = true;
                    }
                    if(array[2] == "UpdateInstallLocation") {
                        updateInstallLocation(array[3]);
                    }
                    if(array[2] == "UpdateStatus") {
                        updateStatus(array[3]);
                    }
                    if(array[2] == "UpdateFile") {
                        updateFile(array[3]);
                    }
                    if(array[2] == "UpdateProgress") {
                        updateProgress(array[3]);
                    }
                }
            }
        }

        function onError(evt)
        {
            writeToScreen('<span style="color: red;">ERROR:</span> ' + "Unable to connect to Scarlet Servers");
        }

        function doSend(message)
        {
            console.log("SENT: " + message);
            websocket.send(message);
        }

        function updateInstallLocation(location) {
            $
        }

        function updateFile(message) {
            $(".file").html(message);
        }

        function updateStatus(message) {
            $(".status").html(message);
        }

        function updateProgress(message) {
            var array = message.split("/");
            console.log(array[0]);
            var percent = parseFloat(array[0]);
            $(".progress-meter").css("width", percent + "%");

        }

        function writeToScreen(message)
        {
            var pre = document.createElement("p");
            pre.style.wordWrap = "break-word";

            output.innerHTML = message;
        }

        window.addEventListener("load", init, false);

    </script>
@endsection
