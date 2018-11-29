

// Make connection
var socket = io.connect('192.168.1.6:8001');
// Query DOM
var message = document.getElementById('message'),


      to = document.getElementById('to'),
      btn = document.getElementById('send'),

      output = document.getElementById('output'),
      feedback = document.getElementById('feedback');

var chat_scroll = document.getElementById('chat_scroll');


socket.on('connect', function(){
    // call the server-side function 'adduser' and send one parameter (value of prompt)

});


function start_chat(from,to)
{
    document.getElementById('to').value=to;
    socket.emit('login', from,to);
}
// Emit events
btn.addEventListener('click', function(){
    var d=new Date();
    socket.emit('chat', {
        message: message.value,
        from: from.value,
        to: to.value,
        created_at: d.toLocaleString(),
    });
    message.value = "";
});

message.addEventListener('keyup', function(){
   var str=message.value;
   if(str.length>0)
   {
       socket.emit('typing', from.value);
   }
   else
   {
      // socket.emit('typing', str.length);
      socket.emit('stop_typing');
   }
})

// Listen for events
socket.on('chat', function(data){
    feedback.innerHTML = '';


    if(data.from+''==from.value) {
    output.innerHTML += ' <li class="clearfix"> <div class="message-data align-right">  <span class="message-data-time" > ' + data.created_at + '</span> &nbsp; &nbsp;  <span class="message-data-name" >' + data.from + '</span> <i class="fa fa-circle me"></i>   </div> <div class="message other-message float-right" >   ' + data.message + '  </div>   </li>';
}
else
{
    output.innerHTML += ' <li class="clearfix"> <div class="message-data">  <span class="message-data-time" >' + data.created_at + '</span> &nbsp; &nbsp;  <span class="message-data-name" >'+ data.from +'</span> <i class="fa fa-circle me"></i>   </div> <div class="message my-message" >   ' + data.message + '  </div>   </li>';

}
    chat_scroll.scrollTop = chat_scroll.scrollHeight;
});

socket.on('typing', function(data){


    feedback.innerHTML = '<p><em>' + data + ' is typing a message...</em></p>';


});

socket.on('stop_typing', function(data){


    feedback.innerHTML = '<p></p>';


});



socket.on('chat_list', function(from,data){
      data= JSON.parse(data);
    output.innerHTML='';
    for (var i=0;i<data.length;i++) {
        if(from==''+data[i].fromname) {



            output.innerHTML += ' <li class="clearfix"> <div class="message-data align-right">  <span class="message-data-time" >'+ data[i].created_at +'</span> &nbsp; &nbsp;  <span class="message-data-name" >' + data[i].fromname +'</span> <i class="fa fa-circle me"></i>   </div> <div class="message other-message float-right" >   ' + data[i].message + '  </div>   </li>';
         }
        else
        {
            output.innerHTML += ' <li class="clearfix"> <div class="message-data">  <span class="message-data-time" >'+  data[i].created_at +'</span> &nbsp; &nbsp;  <span class="message-data-name" >'+ data[i].fromname +'</span> <i class="fa fa-circle me"></i>   </div> <div class="message my-message" >   ' + data[i].message + '  </div>   </li>';
        }

    }




});
