@if(session()->has('flash_message'))
    <script>
        swal({
            title: "{{session('flash_message.title')}}",
            text: "{{session('flash_message.message')}}",
            icon: "{{session('flash_message.level')}}",
            button: "{{session('flash_message.button')}}",
            timer:"{{session('flash_message.timer')}}",
            showConfirmButton:false,
        });
    </script>

@endif

@if(session()->has('flash_message_overlay'))
    <script>
        swal({
            title: "{{session('flash_message_overlay.title')}}",
            text: "{{session('flash_message_overlay.message')}}",
            icon: "{{session('flash_message_overlay.level')}}",
            button: "{{session('flash_message_overlay.button')}}",

           ConfirmButtonText:'Okay',
        });
    </script>

@endif

