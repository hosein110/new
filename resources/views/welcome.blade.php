<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>WebScockets 101</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.js"></script>
    <link href="{{url('styles.css')}}" rel="stylesheet"/>
</head>
<body>

<div id="mario-chat">
    <h2>Mario Chat</h2>
    <div id="chat-window">
        <div class="container clearfix">
            <div class="people-list" id="people-list">
                <div class="search">
                    <input type="text" placeholder="search"/>
                    <i class="fa fa-search"></i>
                </div>
                <ul class="list">
                    @foreach($users as $user)

                        <li class="clearfix" onclick="start_chat({{auth()->user()->id}},{{$user->id}})">
                            <img  width="30" src="{{$user->image_path}}"
                                 alt="avatar"/>
                            <div class="about">
                                <div class="name"> {{$user->fullname}}</div>
                                <div class="status">
                                    <i class="fa fa-circle online"></i> {{$user->last_seen}}
                                </div>
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>

            <div class="chat">
                <div class="chat-header clearfix">
                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/chat_avatar_01_green.jpg"
                         alt="avatar"/>

                    <div class="chat-about">
                        <div class="chat-with">Chat with Vincent Porter</div>
                        <div class="chat-num-messages">already 1 902 messages</div>
                    </div>
                    <i class="fa fa-star"></i>
                </div> <!-- end chat-header -->

                <div class="chat-history" id="chat_scroll">
                    <ul id="output">


                    </ul>

                </div> <!-- end chat-history -->

                <div class="chat-message clearfix">
                    <textarea name="message-to-send" id="message" placeholder="Type your message" rows="3"></textarea>

                    <i class="fa fa-file-o"></i> &nbsp;&nbsp;&nbsp;
                    <i class="fa fa-file-image-o"></i>



                </div> <!-- end chat-message -->

            </div> <!-- end chat -->

        </div> <!-- end container -->

        <script id="message-template" type="text/x-handlebars-template">
            <li class="clearfix">
                <div class="message-data align-right">
                    <span class="message-data-time">time, Today</span> &nbsp; &nbsp;
                    <span class="message-data-name">Olia</span> <i class="fa fa-circle me"></i>
                </div>
                <div class="message other-message float-right">
                    messageOutput
                </div>
            </li>
        </script>

        <script id="message-response-template" type="text/x-handlebars-template">
            <li>
                <div class="message-data">
                    <span class="message-data-name"><i class="fa fa-circle online"></i> Vincent</span>
                    <span class="message-data-time">time, Today</span>
                </div>
                <div class="message my-message">
                    response
                </div>
            </li>
        </script>

        <div id="feedback"></div>
    </div>
    <input id="from" type="text" placeholder="from" value="{{auth()->user()->id}}"/>
    <input id="to" type="text" placeholder="to" value=""/>
    <input id="message" type="text" placeholder="Message" value="{{auth()->user()->id}}"/>

</div>


</body>
<script src="{{url('chat.js')}}"></script>

</html>



