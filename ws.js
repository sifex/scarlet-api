var WebSocketServer = require('ws').Server,
    wss = new WebSocketServer({
        port: 8080
    });

    wss.broadcast = function broadcast(data) {
      wss.clients.forEach(function each(client) {
        client.send(data);
      });
    };


wss.on('connection', function connection(ws) {
    console.log('Connected from ' + ws.upgradeReq.connection.remoteAddress);

    ws.on('message', function incoming(message) {
        wss.broadcast(message);
    });
});
