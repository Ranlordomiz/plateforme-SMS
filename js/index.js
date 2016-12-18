// Websocket server
var ws = require("nodejs-websocket");
var WebSocketServer = require('ws').Server;
var clients = [];

// Waiting for communication on the port 10000
var wss = new WebSocketServer({ port: 10000 });


/*
 *
 *  When having a new client
 *
 */
wss.on('connection', function connection(ws) {

  console.log("New connection from : " + ws.upgradeReq.connection.remoteAddress);
  var id = clients.length;
  clients.push(ws);

  /*
   *
   *  When receiving data
   *
   */
  ws.onmessage = function(msg){

    var message = JSON.parse(msg.data);


    console.log("Message received, type : " + message.type);
    
    if(message.type == "sended"){

      var exec = require('child_process').exec, child;
      child = exec('bash /home/lordroke/www/sms/scripts/smsWebToPhone.bash "' + message.contenu + '" ' + message.id + ' ' + message.registeredId,
          function (error, stdout, stderr) {
              console.log('stdout: ' + stdout);
              console.log('stderr: ' + stderr);
              if (error !== null) {
                   console.log('exec error: ' + error);
              }
          });

      var reponse = {
        type: "sended",
        contenu: message.contenu
      };

    }
    else if(message.type == "homeSended"){

      var reponse = {
        type: "homeSended",
        contenu: message.contenu,
	userId: message.userId
      };

    }
    else{

      var reponse = {
        type: "received",
        contenu: message.contenu,
        id: message.userId
      };

    }

    send(ws, JSON.stringify(reponse));

  }


  /*
   *
   *  On closing state
   *
   */
  ws.on('close', function() {

    console.log('Connection closed from : ' + ws.upgradeReq.connection.remoteAddress);
    clients.splice(id, 1);

  });

});


/*
 *
 *  Send data to the client
 *
 */
function send(ws, str){

  // Check the state of the websocket
  // If the socket isn't open
  if(ws.readyState != ws.OPEN){

    console.error('Client state is ' + ws.readyState);

  }
  // Otherwise, the send the data
  else{

    for(var i = 0 ; i < clients.length ; i++){
      clients[i].send(str);
    }

  }
}
