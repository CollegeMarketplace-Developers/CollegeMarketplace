{{-- @extends('layout') --}}

{{-- @section('content') --}}

{{-- css for individual user leaseItem --}}
@inject('subleaseController', 'App\Http\Controllers\SubleaseController')
<link rel="stylesheet" type="text/css" href="/css/listing.css">

<x-layout>
    <section class = "product-details-container">
        <div class = "card-wrapper-selected">

            {{-- back button --}}
            <div class="back-button">
                <a href="javascript:history.back()" class="button1 b-button">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
            </div> 

            {{-- main show area --}}
            <div class = "card-selected">
                <div class="selected-row">
                    <!-- card left -->
                    <div class = "product-imgs">
                        <div class = "img-display">
                            @if($leaseItem->status =='Available')
                                <div class="stat-container">
                                    <div class="stat green">
                                    </div>
                                </div>
                            @elseif($leaseItem->status=='Pending')
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
                            <div class = "share-container">
                            <form><button class="share-button" type="button"><i class="fa-solid fa-arrow-up-from-bracket"></i></button></form>
                            </div>
                            <script>
                                const shareButton = document.querySelector('.share-button');

                                shareButton.addEventListener('click', event => {
                                if (navigator.share) { 
                                navigator.share({
                                    title: 'College Marketplace',
                                    url: '',
                                    text: 'Check out this leaseItem!'
                                    }).then(() => {
                                        console.log('Thanks for sharing!');
                                    })
                                    .catch(console.error);
                                } 
                                else {
                                        // Fallback
                                        shareDialog.classList.add('is-open');
                                }
                                });
                        </script>
                            @php
                                if(isset($leaseItem->image_uploads)){
                                    //decode the json object
                                    $imgLinks = json_decode($leaseItem->image_uploads);
                                    $titleImage = null;
                                    if(is_array($imgLinks)){
                                        $titleImage = $imgLinks[0];
                                    }
                                }
                            @endphp
                            <img src={{$leaseItem->image_uploads ? Storage::disk('s3')->url($titleImage) : Storage::disk('s3')->url('devimages/rotunda.jpg')}} id = "expandedImg" alt="image doesnt exist">
                        </div>
                        <div class = "img-showcase">
                            @if(is_array(json_decode($leaseItem->image_uploads)))
                                @foreach(json_decode($leaseItem->image_uploads) as $link)
                                    <img src={{$leaseItem->image_uploads ? Storage::disk('s3')->url($link) : Storage::disk('s3')->url('devimages/rotunda.jpg')}} alt = "shoe image" onclick="myFunction(this);">
                                @endforeach
                            @else
                                @php
                                    $site = 'https://picsum.photos/300/200?sig='. rand(0,100);
                                @endphp
                                <img src="{{$site}}" alt="" onclick="myFunction(this);">
                                <img src="{{$site}}" alt="" onclick="myFunction(this);">
                                <img src="{{$site}}" alt="" onclick="myFunction(this);"> 
                                <img src="{{$site}}" alt="" onclick="myFunction(this);">
                                <img src="{{$site}}" alt="" onclick="myFunction(this);">
                            @endif
                        </div>
                    </div>
                    <!-- card right -->
                    <div class = "product-content">
                        <div class="product-details">
                            <div class="price-favorite">
                                <h1>${{$leaseItem->rent}}</h1>
                                    @if($currentUser != null and $currentUser->leaseFavorites != null and in_array($leaseItem->id, explode(", " , $currentUser->leaseFavorites)))
                                        <form action="/users/removefavorite" method="GET">
                                            @csrf
                                            <input type="hidden" name="type" value="leaseItem">
                                            <input type="hidden" name="id" value="{{$leaseItem->id}}">
                                            <button><i class="fa-solid fa-heart saved"></i></button>
                                        </form>
                                    @else
                                        <form action="/users/addfavorite" method="GET">
                                            @csrf
                                            <input type="hidden" name="type" value="leaseItem">
                                            <input type="hidden" name="id" value="{{$leaseItem->id}}">
                                            <button><i class="fa-solid fa-heart bouncy"></i></button>
                                        </form>
                                    @endif
                
                            </div>
                            <div class="product-header">
                                <h1>{{$leaseItem->sublease_title}}</h1>
                            </div>
                            <div class="product-extra">
                                <div>
                                    <p>Price:</p> 
                                    <span>{{$leaseItem->negotiable}}</span>
                                </div>
                                <div>
                                    <p>Condition:</p>
                                    <span>{{$leaseItem->condition}}</span>
                                </div>
                            </div>
                            <div class="product-extra">
                                @php
                                    $subleaseController::updateViewCount($leaseItem);
                                @endphp
                                <p><i class="fa-solid fa-eye"></i><span>{{$leaseItem->view_count}}</span></p>
                                <p><i class="fa-solid fa-location-dot"></i><span>{{$leaseItem->city}}, {{$leaseItem->state}}</span></p>
                            </div>
                            <div class="product-category">
                                @php
                                    $utilities = explode(", ", $leaseItem->utilities);
                                    $date = $leaseItem->created_at ->format('Y-m-d');
                                @endphp
                                <div class="categories-container">
                                    <p>Utilities Included:</p>
                                    <div class="categories">
                                        @foreach($utilities as $utility)
                                            <a href="/shop/all?type=all&utilities={{$utility}}">{{$utility}}</a>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- Added to differentiate listing types -->
                                <div class="categories-container">
                                    <p>Listing Type:</p>
                                    <div class="categories-subleases">
                                    <a href="#" onclick="return false;">For Lease</a>
                                    </div>
                                </div>
                            </div>
                            <div class = "date-posted">
                                <p>Date Posted:</p>
                                <span>{{$date}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="selected-row">
                    <div class ="description-chat">
                        <div class="product-description-area">
                            <div class="controls">
                                {{-- edit --}}
                                {{-- delete --}}
                                {{-- share --}}
                                {{-- chat with owner --}}
                                @if($currentUser != null and $leaseItem->user_id == $currentUser->id)
                                    <form method="POST" action="/leaseItems/{{$leaseItem->id}}/update">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" id="status" style = " font-size: 17px; text-align:center;" onchange="this.form.submit()">
                                            <option style = "text-align:center;">Status</option>
                                            <option style = "text-align:center;" value="Available">Available</option>
                                            <option style = "text-align:center;" value="Pending">Pending</option>
                                            <option style = "text-align:center;" value="Sold">Sold</option>  
                                        </select>
                                    </form>
                                    
                                
                                    <form class = "editForm" action="/leaseItems/{{$leaseItem->id}}/edit" method = "GET">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$leaseItem->id}}">
                                        <button><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                    </form>

                                    <span id="delete-modal-trigger">
                                        <i class="fa fa-trash" ></i>
                                    </span>
                                @endif
                                
                            </div>
                            <h1>Description</h1>
                            <p>{{$leaseItem->description}}</p>
                        </div>
                        <div class="chat-container">
                            {{-- if I am the leaseItem owner show user panel --}}
                            @if($currentUser != null && $leaseItem->user_id == $currentUser->id)
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

                            {{-- if I am not the leaseItem owner --}}
                            <div id="scroll-to-bottom" class="messages-container active">

                                {{-- if I am the leaseItem owner, display back button --}}
                                @if($currentUser != null && $leaseItem->user_id == $currentUser->id)
                                    <a class="message-back">
                                        <i class="fa-solid fa-arrow-left"></i>
                                    </a>
                                @else
                                {{-- if i am not leaseItem owner, just continue chatting | display name of person I am chatting with--}}
                                    <a class="back-placeholder">
                                        Chat with {{$listingOwner->first_name}} {{$listingOwner->last_name}}
                                    </a>
                                @endif

                                <ul class="messages" id='messages'>
                                    @if(auth()->guest())
                                        <li class="message clearfix">
                                            <div class="sent">
                                                <p>Please log in to begin chat</p>
                                                <p class='date'>-System</p>
                                            </div>
                                        </li>
                                    @endif
                                </ul>

                                @if(auth()->guest()) 
                                    <div id = "input-text" class=input-text>
                                        <input type="text" name="message" placeholder="Please Login to begin chat." class="submit" disabled>
                                    </div>
                                @else
                                    <div id = "input-text" class=input-text>
                                        <input type="text" name="message" placeholder="Message Seller" class="submit">
                                    </div>   
                                @endif
                            </div> 
                        </div>
                    </div>
                    <div class="about-seller-and-chat">
                        <div class="map-container" id = "map-container">
                        </div>
                        <div class="about-seller">
                            <i class="fa-solid fa-user"></i>
                            <div>
                                <p>Name</p>
                                <p>Joined: <span>2001-14-16</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="map-container-mobile" id="map-container-mobile">
                    {{--this mobile map is only shown on small screens  --}}
                </div>
                <div>
                    {{-- community thread goes here --}}
                </div>
            </div>
        </div>
        <div class="modal" id="delete-modal">
            <div class="modal-content">
                <div class="sad-dog-container">
                    <img src="https://cmimagestoragebucket.s3.amazonaws.com/devimages/sad-dog.png" alt="">
                </div>
                <span class="close">&times;</span>
                <h1>Delete Sublease</h1>
                <p>Are you sure you want to delete this leaseItem?</p>

                <div class="clearfix">
                    <input type="button" class="button1" class="cancelbtn" id="cancelbtn" value="Cancel" />
                    <form method="POST" action="/leaseItems/{{$leaseItem->id}}">
                        @csrf
                        @method('DELETE')
                        <input type="submit" class="deletebtn button1" value="Delete"/>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <section class = "listings-parent-container">
         @include('partials._subleaseCarousel', ['subleases' => $subleaseQuery, 'message' => 'Places for Leasing', 'carouselClass'=>'slider3','carouselControls' => 'controls3', 'carouselP' =>'previous previous3', 'carouselN' => 'next next3', 'currentUser'=>$currentUser])
    </section>

    {{-- for pusher real time messages --}}
    <script src="https://js.pusher.com/7.1/pusher.min.js"></script>

    <script>
        function isEmpty(input){
            if(input === '' || input === null || input === undefined || input == null){
                return true;
            }return false;
        }  

        //
        //----------------------------- Change Main Image View Code -------------------------
        //

        function myFunction(imgs) {
            var expandImg = document.getElementById("expandedImg");
            expandImg.src = imgs.src;
        }

        //
        //----------------------------- Show Map Code -------------------------
        //

        /*let address = ['{{$leaseItem->street}}', '{{$leaseItem->city}}', '{{$leaseItem->state}}', '{{$leaseItem->postcode}}', '{{$leaseItem->country}}'];
        getGoogleMapsImage(address);
        function getGoogleMapsImage(addressElements) {
            var image = document.createElement('img');
            var joined = addressElements.join(',');
            var params = new URLSearchParams();
            params.append('center', joined);
            params.append('zoom', '15');
            params.append('size', '500x240');
            params.append('maptype', 'roadmap');
            params.append('markers', 'color:red|label:C|' + joined);
            params.append('key', 'AIzaSyA2Umn-3TUxP23ok373mWr0U4CHQDItcEk');
            //params.append('signature','smZ85pItXiH894n1c2ElR0RY-HQ=');
            var url = 'https://maps.googleapis.com/maps/api/staticmap?' + params.toString();
            //console.log(url);
            image.src = url;
            var image2 = document.createElement('img');
            image2.src = url;
            document.getElementById('map-container').appendChild(image);
            document.getElementById('map-container-mobile').appendChild(image2);

            return url;
        }*/

        GMapCircle('{{$leaseItem->latitude}}','{{$leaseItem->longitude}}',200);

        function GMapCircle(lat,lng,rad,detail=8){
            var image = document.createElement('img');
            var uri = 'https://maps.googleapis.com/maps/api/staticmap?';
            var staticMapSrc = 'center=' + lat + ',' + lng;
            staticMapSrc += '&size=500x240';
            staticMapSrc += '&zoom=15';
            staticMapSrc += '&maptype=roadmap';
            staticMapSrc += '&key=AIzaSyA2Umn-3TUxP23ok373mWr0U4CHQDItcEk';
            staticMapSrc += '&path=color:0x0000ff|fillcolor:0x0000ff'; 

            console.log(staticMapSrc);
            var r    = 6371;
            var pi   = Math.PI;
            var _lat  = (parseFloat(lat) * pi) / 180;
            //console.log(_lat);
            var _lng  = (parseFloat(lng) * pi) / 180;
            //console.log(_lng);
            var d    = (rad/1000) / r;

            var i = 0;
            for(i = 0; i <= 360; i+=detail) {
                var brng = i * pi / 180;

                var pLat = Math.asin(Math.sin(_lat) * Math.cos(d) + Math.cos(_lat) * Math.sin(d) * Math.cos(brng));
                var pLng = ((_lng + Math.atan2(Math.sin(brng) * Math.sin(d) * Math.cos(_lat), Math.cos(d) - Math.sin(_lat) * Math.sin(pLat))) * 180) / pi;
                pLat = (pLat * 180) / pi;

                //console.log(pLat);

                staticMapSrc += "|" + pLat + "," + pLng;
            }
            var url = uri + encodeURI(staticMapSrc);

            image.src = url;
            var image2 = document.createElement('img');
            image2.src = url;
            document.getElementById('map-container').appendChild(image);
            document.getElementById('map-container-mobile').appendChild(image2);

            return url;
        }
        
        // 
        // ----------------------- Messaging Feature Code -----------------------------
        // 

        var leaseItem_id = "{{$leaseItem->id}}"
        var leaseItemOwner = "{{$leaseItem->user_id}}";
        var userLoggedIn = "{{$currentUser ? $currentUser->id : -1}}";
        var receiverSelected = null; //the person whose chat we have open

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
            // if I am not the leaseItem owner, show me messages that have been sent to me instantly
            // if I am the leaseItem owner -> get selected user and update their information or display a pending symbol
            channel.bind('my-event', function(data) {
                console.log(data);
                console.log("this doesnt work");
                if (userLoggedIn == data.from) {
                    // if I am not the leaseItem owner and I am sending a message
                    if(userLoggedIn != leaseItemOwner){
                        loadConversation(leaseItemOwner, userLoggedIn);
                    }else{ //if I am the leaseItem owner and I am sending the message
                        //  need to have an option for a user selected or pending
                        if(receiverSelected != null){ // if the receiver is selected
                            $('#'+receiverSelected).click();
                        }
                    }
                }else if (userLoggedIn == data.to) {
                    if(userLoggedIn != leaseItemOwner){
                        loadConversation(leaseItemOwner, userLoggedIn);
                    }else{ //if the leaseItem owner is the user logged in
                        if(receiverSelected != null){ // if the receiver is selected
                            $('#'+receiverSelected).click();
                        }else{
                            console.log(data);
                            if(data.for_leaseItem == leaseItem_id){
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
            // if I am the leaseItem owner, I want to see all the users that have contacted me
            if(leaseItemOwner == userLoggedIn){
                $('.messages-container').removeClass('active');
                $('.user-wrapper').addClass('active');
            }
            // back button to switch from messages container to users list container
            $('.message-back').click(function(){
                $('.messages-container').removeClass('active');
                $('.user-wrapper').addClass('active');
                receiverSelected = null;
            });
            
            // if the leaseItem is not mine, load all messages from the leaseItem owner, to me the current user logged in
            if("{{!auth()->guest()}}"){
                loadConversation(leaseItemOwner, userLoggedIn);
            }

            // load the initial conversation
            function loadConversation(UserSending, UserReceiving ){
                if("{{$leaseItem->user_id}}" != userLoggedIn){
                    var ul = document.getElementById("messages");
                    ul.innerHTML = null;
                    
                    $.ajax({
                        type: "GET",
                        url: "/messages?from=" + UserSending + "&to=" + UserReceiving + "&leaseItem_id=" + leaseItem_id, // need to create this route
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
                                    var formatDate = data[i].created_at.split("-");
                                    var fullTime = formatDate[2].split("T");
                                    var splitTime = fullTime[1].split(":");
                                    date.innerHTML = formatDate[1] + "/" + fullTime[0] + "/" + formatDate[0] + " "+ splitTime[0] + ":" + splitTime[1] +" UTC"; 
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
            // if I am the leaseItem owner, I want to click on a user and get all the messages from me to them or them to me
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

                // console.log("from: " + receiverSelected + " to: " +leaseItemOwner)
                $.ajax({
                    type: "GET",
                    url: "/messages?from=" + receiverSelected + "&to=" + leaseItemOwner + "&leaseItem_id=" + leaseItem_id, 
                    data: "JSON",
                    cache: false,
                    success: function (data) {
                        if(data != null){
                            
                            // once we obtain all the messages
                            //we put them in an unordered list and display them

                            console.log('Received Messages Successfully For User: ' + receiverSelected);
                            var ul = document.getElementById("messages");
                            for(var i = 0; i< data.length; i++){
                                var li = document.createElement("li");
                                li.className = 'message clearfix'
                                
                                var div = document.createElement('div');
                                if(data[i].from == leaseItemOwner){
                                    div.className="sent"
                                }else{
                                    div.className="received"
                                }
                                var message = document.createElement('p');
                                message.innerHTML = data[i].message;
                                div.appendChild(message);
                                var date = document.createElement('p');
                                var formatDate = data[i].created_at.split("-");
                                var fullTime = formatDate[2].split("T");
                                var splitTime = fullTime[1].split(":");
                                date.innerHTML = formatDate[1] + "/" + fullTime[0] + "/" + formatDate[0] + " "+ splitTime[0] + ":" + splitTime[1] +" UTC"; 
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
            //1) if the leaseItem is not mine, i wanna be able to message the leaseItem owner
            //2) if the leaseItem is mine, select a specifc user, then get their id and sent them the message
            //code for sending messages
            if("{{!auth()->guest()}}"){
                $(document).on('keyup', 'input', function(e){
                    var msg = $(this).val();
                    var datastr = null;
                    console.log('leaseItem Owner: ' + leaseItemOwner);
                    console.log('user logged in: '+ userLoggedIn);
                    // if I am the leaseItem owner, then i need a receiver id which should be the person I have selected form the users list
                    if(leaseItemOwner == userLoggedIn){
                        // if it is my ownleaseItem, use receiver id, instead of leaseItem owner id
                        datastr = "receiver_id=" + receiverSelected + "&message=" + msg + "&for_sublease=" + leaseItem_id;
                            // console.log(datastr);
                    }else{ //else send a message to the leaseItem owner from me thats default
                        // console.log("bottom branch");
                        datastr = "receiver_id=" + leaseItemOwner + "&message=" + msg + "&for_sublease=" + leaseItem_id;
                    }

                    if(e.keyCode == 13 && msg != '' && leaseItemOwner != ''){
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
        
        // 
        // ----------------------- Delete Listing Code -----------------------------
        // 

        if(userLoggedIn == leaseItemOwner){
            var deleteModal = document.getElementById("delete-modal");
            var deleteButton = document.getElementById("delete-modal-trigger");
            var deleteSpan = document.getElementsByClassName("close")[0];
            var cancelBtn = document.getElementById('cancelbtn');
            deleteButton.onclick = function() {
                deleteModal.style.display = "grid";
            }
            deleteSpan.onclick = function() {
                deleteModal.style.display = "none";
            }
            cancelBtn.onclick = function() {
                deleteModal.style.display = "none";
            }
            window.onclick = function(event) {
                if (event.target == deleteModal) {
                    deleteModal.style.display = "none";
                }
            }
        }
    </script>

</x-layout>
{{-- @endsection --}}