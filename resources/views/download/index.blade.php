@extends('template')

@section('title', 'Download')

@section('content')
<div class="row">
    <div class="small-12 columns">
        <a class="float-right logout" href="/logout/">Logout</a>
    </div>
</div>
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
        <span class="status"> </span> <span class="file"> </span><br />
        <input class="button disabled" id="start" disabled="disabled" type="button" name="name" value="Start Download" onclick="startDownload()">
        <input class="button disabled" id="location" disabled="disabled" type="button" name="name" value="Change Download Location" onclick="changeLocation()">
    </p>
</div>
@endsection


@section('scripts')
    <script language="javascript" type="text/javascript">
        var IP;
        var connected = false;
        var connectedNo = 1;
        var info = {!! json_encode($userInfo) !!};


        $(function() {
            $.getJSON("https://api.ipify.org?format=jsonp&callback=?",
            function(json) {
                IP = json.ip;
            }
        );
        });

        function startDownload() {
            doSend("Updater" + "|" + IP + "|" + "startDownload" + "|" + info.installDir);
            writeToScreen("Commencing Download");
            $('input#location').attr("disabled", "disabled");
            $('input').removeAttr("class");
            $('input').attr("class", "button disabled");
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
            updateStatus("Hello <span class='username'>" + info.username + "</span>");
            updateFile("Current Install Location is: " + info.installDir);
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
                    if(connectedNo < 20) {
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
                    else if(array[2] == "UpdateInstallLocation") {
                        updateInstallLocation(array[3]);
                        console.log(array[3]);
                    }
                    else if(array[2] == "UpdateStatus") {
                        updateStatus(array[3]);
                    }
                    else if(array[2] == "UpdateFile") {
                        updateFile(array[3]);
                    }
                    else if(array[2] == "UpdateProgress") {
                        updateProgress(array[3]);
                    }
                    else if(array[2] == "Completed") {
                        completed();
                    }
                }
            }
        }

        function onError(evt) {
            writeToScreen('<span style="color: red;">ERROR:</span> ' + "Unable to connect to Scarlet Servers");
        }

        function doSend(message) {
            console.log("SENT: " + message);
            websocket.send(message);
        }

        function updateFile(message) {
            $(".file").html(message);
        }

        function updateStatus(message) {
            $(".status").html(message);
        }

        function updateProgress(message) {
            var array = message.split("/");
            var percent = parseFloat(array[0]);
            $(".progress-meter").css("width", percent + "%");
        }

        function updateInstallLocation(message) {
            $.post( "/api/user/install/" +  info.key , { installDir: message })
                .done( function() {
                    $.get("/api/user/info/" + info.key, function( data ) {
                        info = data;
                        updateFile("Current Install Location is: " + info.installDir);
                    });

            } );
        }

        function completed() {
            updateFile("Start ARMA 3 using the Steam Launcher");
            writeToScreen("Download Complete");
        }

        function changeLocation() {
            doSend("Updater" + "|" + IP + "|" + "locationChange");
        }

        function writeToScreen(message) {
            var pre = document.createElement("p");
            pre.style.wordWrap = "break-word";

            output.innerHTML = message;
        }

        window.addEventListener("load", init, false);

    </script>
@endsection
