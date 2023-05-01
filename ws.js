var WebSocketServer = require('ws').Server,
    wss = new WebSocketServer({
        port: 9090
    });


wss.on('connection', function connection(ws) {
    console.log('Connected from ' + ws.upgradeReq.connection.remoteAddress);
});

wss.on('message', function message(ws) {
    console.log(ws.type + ": " + ws.message);
});
