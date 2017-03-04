global.express = require('express')
      ,http    = require('http');
global.app = express();
global.server = http.createServer(app);
global.io = require('socket.io').listen(server);
global.Redis = require('ioredis'),
global.r = new Redis();
// global.kernel = require('./kernel.js')
// global.path = require('path')
// global.ejs = require('ejs')


// require('./kernel/init.js')
//
//
//
// r.on("error", function (err) {
//     console.log("Error " + err);
// });
//
//
//

io.set('transports', [ 'websocket', 'flashsocket', 'polling' ] );
// io.set('origins', '*:*');
        // io.set("polling duration", 10);



  io.sockets.on('connection', function(socket) {
    console.log('user connected');
    socket.on('drawClick', function(data) {
      console.log(data.color);
      socket.broadcast.emit(`draw:${data.channel}`, {
        x: data.x,
        y: data.y,
        type: data.type,
        color: data.color,
        size: data.size
      });
    });

    socket.on('save',function(data,url){
      r.hmset(`canvas:${url}`, {
          password: "letmein",
          data: data,
          // base64: data.replace(/^data:image\/(png|jpg);base64,/, ""),
      })
    })
  });




// var Redis = require('ioredis');
// var redis = new Redis();

Redis.Promise.onPossiblyUnhandledRejection((error) => {
  console.log("Redis unhandled error ", error);
});

r.on("error", (error) => {
  console.log("Redis connection error", error);
  process.exit(1);
});

process.on('exit', function (){
  console.log('Exiting...listener count', r.listenerCount('error'));
});


server.listen(8000);
// console.log('breakpoint');
