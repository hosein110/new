
var express = require('express');
var socket = require('socket.io');
http = require('http');
var request = require('request');
// App setup
var app = express();
var server = app.listen(8005, function(){
    console.log('listening for requests on port 8002,');







});


var mysql = require('mysql');

var con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "root",
    database: "marcopolo1",
    charset : 'utf8mb4'
});



// Static files
app.use(express.static('public'));

// Socket setup & pass server
var io = socket(server);





io.on('connection',function (socket)  {

   // socket.join('room');
    console.log('made socket connection', socket.id);

// Handle chat event
    socket.on('insert_chat', function(data){


        // we need this code  /////  var request = require('request');
        var headers = {
            'Authorization':data.Authorization
        }

        var options = {
            url: 'http://localhost/marcopolo/public/api/user/send_message',
            method: 'POST',
            headers: headers,
            form: data
        }

        request(options, function (error, response, body) {
            if (!error && response.statusCode == 200) {
                // Print out the response body
                console.log(body);

                io.sockets.emit('response_chat', data);
            }
        })

        //  console.log(data);
        // var d = new Date();
        //
        //
        // var sql = "INSERT INTO user_chats (sender_id,receiver_id,message,created_at) VALUES ('"+data.user_id+"','"+data.other_user_id+"','"+data.message+"','"+d.toLocaleString()+"')";
        // con.query(sql, function (err, result) {
        //     if (err) throw err;
        //
        //
        // });
        //
        // io.sockets.emit('response_chat', data);


    });

// Handle typing event
    socket.on('typing', function(data){
        socket.broadcast.emit('typing', data);
    });

    socket.on('stop_typing', function(data){
        socket.broadcast.emit('stop_typing');
    });


    socket.on('login', function(from,to){
        con.query("SELECT * FROM chat where (`other_user_id`='"+from+"' and `user_id`='"+to+"')or  (`user_id`='"+to+"' and `other_user_id`='"+from+"')   order by id ASC ", function (err, result, fields) {
            if (err) throw err;
            //  console.log(fromname);

            //  socket.emit('chat_list',from,JSON.stringify(result));
            var message = {"message":"sss",
                "senderNickname":"ddd"}
            console.log(JSON.stringify(result));


            var element = {};

            element.message = JSON.stringify(result);

            socket.emit('chat_list',element);

        });

    });



});




// app.get('/user_list', function (req, res) {
//
//     console.log(req.query.first_name);
//     res.end(req.query.first_name);
//
// })