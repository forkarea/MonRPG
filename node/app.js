//port utilisé
var port_websocket = 8787;

var io = require('socket.io'),
app = require('http').createServer();

io = io.listen(app); 

io.set('log level', 1); // mettre en commentaire pour la dev

var user = new Object();

io.sockets.on('connection', function (socket) {
		socket.on('envois', function (mess) {
				user[socket.id] = mess;
				socket.broadcast.emit('message', mess);
				console.log(mess);
		});
		
		socket.on('disconnect', function () {
				user[socket.id].type = 'delete';
				io.sockets.emit('disconnected', user[socket.id]);
				delete user[socket.id];
		});
});

app.listen(port_websocket);