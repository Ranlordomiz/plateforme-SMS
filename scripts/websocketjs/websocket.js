#!/usr/bin/env node
var WebSocketClient = require('websocket').client;


var client = new WebSocketClient();

var args = process.argv.slice(2);

client.on('connect', function(connection) {

    console.log('WebSocket Client Connected');

    connection.on('close', function() {
        console.log('echo-protocol Connection Closed');
    });

    connection.sendUTF(args[0]);
    connection.close();

});
 
client.connect('ws://localhost:10000/', 'echo-protocol');
