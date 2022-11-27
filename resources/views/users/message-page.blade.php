
@inject('listingController', 'App\Http\Controllers\ListingController')
<link rel="stylesheet" type="text/css" href="/css/listing.css">

<x-layout>
    <section class = "product-details-container message-container">
        <div class = "card-wrapper-selected">

            {{-- back button --}}
            <div class="back-button">
                <a href="javascript:history.back()" class="button1 b-button">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
            </div> 

            {{-- main show area --}}
            <div class = "card-selected">
                <div class="selected-row selected-row-message">
                    <div class="chat-container">

                        {{-- if I am the listing owner show user panel --}}
                        @if($listing->user_id == $currentUser)
                            <div class="user-wrapper">
                                <ul class="users">
                                    @if(count($allUsers) >= 1)
                                        @foreach($allUsers as $user)
                                            <li class="user" id="{{ $user->id }}">

                                                @if($user->unread)
                                                    <span class="pending">{{ $user->unread }}</span>
                                                @endif

                                                
                                                <div class="media-left">
                                                    <img src="{{ $user->avatar }}" alt="" class="media-object">
                                                </div>

                                                <div class="media-body">
                                                    <p class="name">{{ $user->first_name }} {{$user->last_name }} | ID: {{$user->id}} </p>
                                                    <p class='email'>{{$user ->email}} </p>   
                                                </div>
                                            </li>
                                        @endforeach
                                    @else
                                        <li class="no-messages"><span>You have no messages</span></li>
                                    @endif
                                </ul>
                            </div>
                        @endif

                        {{-- if I am not the listing owner --}}
                        <div id="scroll-to-bottom" class="messages-container active">

                            {{-- if I am the listing owner, display back button --}}
                            @if($listing->user_id == $currentUser)
                                <a class="message-back">
                                    <i class="fa-solid fa-arrow-left"></i>
                                </a>
                            @else
                            {{-- if i am not listing owner, just continue chatting | display name of person I am chatting with--}}
                                <a class="back-placeholder">
                                    Chat with {{$listingOwner->first_name}} {{$listingOwner->last_name}}
                                </a>
                            @endif

                            <ul class="messages" id='messages'>
                                
                            </ul>

                            <div id = "input-text" class=input-text>
                                <input type="text" name="message" placeholder="Message Seller" class="submit">
                            </div>
                        </div> 
                    </div>
                    <div class="product-showcase">
                        <div class = "main-image-area">
                            <div class = "main-image">
                                @if($listing->status =='Available')
                                    <div class="stat-container">
                                        <div class="stat green">
                                        </div>
                                    </div>
                                @elseif($listing->status=='Pending')
                                    <div class="stat-container">
                                        <div class="stat yellow">
                                        </div>
                                    </div>
                                @else
                                    <div class="stat-container">
                                        <div class="stat">
                                        </div>
                                    </div>
                                @endif 
                                @php
                                    if(isset($listing->image_uploads)){
                                        //decode the json object
                                        $imgLinks = json_decode($listing->image_uploads);
                                        $titleImage = null;
                                        if(is_array($imgLinks)){
                                            $titleImage = $imgLinks[0];
                                        }
                                    }
                                @endphp
                                <a href="/listings/{{$listing->id}}">
                                    <img src={{$listing->image_uploads ? Storage::disk('s3')->url($titleImage) : Storage::disk('s3')->url('devimages/rotunda.jpg')}}" id = "expandedImg" alt="image doesnt exist">
                                </a>
                            </div>
                        </div>

                        <div class = "product-content">
                            <div class="product-details message-product-details">
                                <div class="price-favorite">
                                    <h1>${{$listing->price}}</h1>
                                </div>
                                <div class="product-header">
                                    <h1>{{$listing->item_name}}</h1>
                                </div>
                                <div class="product-extra">
                                    <div>
                                        <p>Price:</p> 
                                        <span>{{$listing->negotiable}}</span>
                                    </div>
                                    <div>
                                        <p>Condition:</p>
                                        <span>{{$listing->condition}}</span>
                                    </div>
                                    <p><i class="fa-solid fa-eye"></i><span>{{$listing->view_count}}</span></p>
                                    <p><i class="fa-solid fa-location-dot"></i><span>{{$listing->city}}, {{$listing->state}}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>    

    {{-- for pusher real time messages --}}
    <script src="https://js.pusher.com/7.1/pusher.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
    integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
    crossorigin=""></script>
   
    <script>

        function isEmpty(input){
            if(input === '' || input === null || input === undefined || input == null){
                return true;
            }return false;
        }  

        var listing_id = "{{$listing->id}}"
        var listingOwner = "{{$listing->user_id}}";
        var userLoggedIn = "{{$currentUser}}";
        var receiverSelected = null;
        
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Pusher.logToConsole = true;
            var pusher = new Pusher('5b40ba1f12ea9bf24b29', {
                cluster: 'us2'
            });
            var channel = pusher.subscribe('my-channel');

            // 2 cases
            // if I am not the listing owner, show me messages that have been sent to me instantly
            // if I am the listing owner -> get selected user and update their information or display a pending symbol
            channel.bind('my-event', function(data) {
                console.log(data);
                console.log("this does work");
                if (userLoggedIn == data.from) {
                    // if I am not the listing owner and I am sending a message
                    if(userLoggedIn != listingOwner){
                        loadConversation(listingOwner, userLoggedIn);
                    }else{ //if I am the listing owner and I am sending the message
                        //  need to have an option for a user selected or pending
                        if(receiverSelected != null){ // if the receiver is selected
                            $('#'+receiverSelected).click();
                        }
                    }
                }else if (userLoggedIn == data.to) {
                    if(userLoggedIn != listingOwner){
                        loadConversation(listingOwner, userLoggedIn);
                    }else{ //if the listing owner is the user logged in
                        if(receiverSelected != null){ // if the receiver is selected
                            $('#'+receiverSelected).click();
                        }else{
                            console.log(data);
                            if(data.for_listing == listing_id){
                                var pending = parseInt($('#' + data.from).find('.pending').html());
                                if (pending) {
                                    $('#' + data.from).find('.pending').html(pending + 1);
                                } else {
                                    $('#' + data.from).append('<span class="pending">1</span>');
                                }
                            }
                        }
                    }
                }
            });
            // if I am the listing owner, I want to see all the users that have contacted me
            if(listingOwner == userLoggedIn){
                $('.messages-container').removeClass('active');
                $('.user-wrapper').addClass('active');
            }
            // back button to switch from messages container to users list container
            $('.message-back').click(function(){
                $('.messages-container').removeClass('active');
                $('.user-wrapper').addClass('active');
                receiverSelected = null;
            });
            
            // if the listing is not mine, load all messages from the listing owner, to me the current user logged in
            if("{{!auth()->guest()}}"){
                loadConversation(listingOwner, userLoggedIn);
            }
            function loadConversation(UserSending, UserReceiving ){
                if("{{$listing->user_id}}" != userLoggedIn){
                    var ul = document.getElementById("messages");
                    ul.innerHTML = null;
                    
                    $.ajax({
                        type: "GET",
                        url: "/messages?from=" + UserSending + "&to=" + UserReceiving + "&listing_id=" + listing_id, // need to create this route
                        data: "JSON",
                        cache: false,
                        success: function (data) {
                            // console.log(data);
                            if(data != null){
                                
                                var ul = document.getElementById("messages");
                                for(var i = 0; i< data.length; i++){
                                    // console.log(data[i]);
                                    var li = document.createElement("li");
                                    li.className = 'message clearfix'
                                    
                                    var div = document.createElement('div');
                                    if(data[i].from == userLoggedIn){
                                        div.className="sent"
                                    }else{
                                        div.className="received"
                                    }
                                    var message = document.createElement('p');
                                    message.innerHTML = data[i].message;
                                    div.appendChild(message);
                                    var date = document.createElement('p');
                                    date.innerHTML = "{{date('d M y, h:i a', strtotime(" + data[i].created_at + "))}}";
                                    date.className='date';
                                    div.appendChild(date);
                                    li.appendChild(div);
                                    ul.appendChild(li);
                                    scrollToBottomFunc();
                                }
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) { 
                            alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                        }
                    });
                }
            }


            // code for getting initial messages when a user profile is clicked or when I click contact seller for the first time
            // if I am the listing owner, I want to click on a user and get all the messages from me to them or them to me
            $('.user').click(function(){
                var ul = document.getElementById("messages");
                ul.innerHTML = null;
                

                // make the user class inactive and show the messages
                $('.user-wrapper').removeClass('active');
                $('.messages-container').addClass('active');

                // the receiver selected is the person we clicked on
                // we use that person's id to send messages
                receiverSelected = $(this).attr('id');

                // remove pending symbol since we have seen messages
                $(this).find('.pending').remove();

                // perform an ajax request to get all messages to and from that specific user we clicked on
                $.ajax({
                    type: "GET",
                    url: "/messages?from=" + receiverSelected + "&to=" + listingOwner + "&listing_id=" + listing_id, 
                    data: "JSON",
                    cache: false,
                    success: function (data) {
                        if(data != null){
                            
                            // once we obtain all the messages
                            //we put them in an unordered list and display them

                            console.log('received messages successfully!');
                            var ul = document.getElementById("messages");
                            for(var i = 0; i< data.length; i++){
                                var li = document.createElement("li");
                                li.className = 'message clearfix'
                                
                                var div = document.createElement('div');
                                if(data[i].from == listingOwner){
                                    div.className="sent"
                                }else{
                                    div.className="received"
                                }
                                var message = document.createElement('p');
                                message.innerHTML = data[i].message;
                                div.appendChild(message);
                                var date = document.createElement('p');
                                //date.innerHTML = "{{date('d M y, h:i a', strtotime(" + data[i].created_at + "))}}";
                                console.log(data[i].created_at);
                                date.innerHTML = data[i].created_at;
                                date.className='date';
                                div.appendChild(date);
                                li.appendChild(div);
                                ul.appendChild(li);

                                // scroll to the bottom of all the displayed messages
                                scrollToBottomFunc();
                            }
                        }
                    },

                    // post error if there is any
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                    }
                });
            });



            // take to take in to account two different scenarios
            //1) if the listing is not mine, i wanna be able to message the listing owner
            //2) if the listing is mine, select a specifc user, then get their id and sent them the message
            //code for sending messages
            if("{{!auth()->guest()}}"){
                $(document).on('keyup', 'input', function(e){
                    var msg = $(this).val();
                    var datastr = null;
                    // if I am the listing owner, then i need a receiver id which should be the person I have selected form the users list
                    if(listingOwner == userLoggedIn){
                        // if it is my ownlisting, use receiver id, instead of listing owner id
                        datastr = "receiver_id=" + receiverSelected + "&message=" + msg + "&for_listing=" + listing_id;
                            // console.log(datastr);
                    }else{ //else send a message to the listing owner from me thats default
                        // console.log("bottom branch");
                        datastr = "receiver_id=" + listingOwner + "&message=" + msg + "&for_listing=" + listing_id;
                    }

                    if(e.keyCode == 13 && msg != '' && listingOwner != ''){
                        $(this).val(''); // while pressed enter text box will be empty
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            url: "/sendmessage", 
                            type: 'POST',
                            data: datastr,
                            dataType: 'JSON',
                            _token: CSRF_TOKEN,
                            cache: false,
                            success: function (data) {
                                console.log(data);
                            },
                            error: function (jqXHR, status, err) {
                                console.log(err);
                            },
                            complete: function () {
                                // scrollToBottomFunc();
                            }
                        })
                    }
                });
            }
        });

         // make a function to scroll down auto
        function scrollToBottomFunc() {
           let scroll_to_bottom = document.getElementById('messages');
            scrollBottom(scroll_to_bottom);
        }

        function scrollBottom(element) {
            element.scroll({ top: element.scrollHeight, behavior: "smooth"})
        }
    </script>
</x-layout>