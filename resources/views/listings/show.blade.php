{{-- @extends('layout') --}}

{{-- @section('content') --}}

{{-- css for individual user listing --}}
@inject('listingController', 'App\Http\Controllers\ListingController')
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
                            
                            @if($listing->negotiable == "Free")
                                <div class="ribbon product-ribbon">
                                    <span class="ribbon2 product-ribbon-inner" style="font-size: 17px !important;">F<br>R<br>E<br>E<br></span>
                                </div>
                                <div class = "share-container bottom-right">
                                    <form><button class="share-button" type="button"><i class="fa-solid fa-arrow-up-from-bracket"></i></button></form>
                                </div>
                            @else
                                <div class = "share-container">
                                    <form><button class="share-button" type="button"><i class="fa-solid fa-arrow-up-from-bracket"></i></button></form>
                                </div>
                            @endif

                            <script>
                                const shareButton = document.querySelector('.share-button');

                                shareButton.addEventListener('click', event => {
                                if (navigator.share) { 
                                navigator.share({
                                    title: 'College Marketplace',
                                    url: '',
                                    text: 'Check out this listing!'
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
                                if(isset($listing->image_uploads)){
                                    //decode the json object
                                    $imgLinks = json_decode($listing->image_uploads);
                                    $titleImage = null;
                                    if(is_array($imgLinks)){
                                        $titleImage = $imgLinks[0];
                                    }
                                }
                            @endphp
                            <img src={{$listing->image_uploads ? Storage::disk('s3')->url($titleImage) : Storage::disk('s3')->url('devimages/rotunda.jpg')}} id = "expandedImg" alt="image doesnt exist">
                        </div>
                        <div class = "img-showcase">
                            @if(is_array(json_decode($listing->image_uploads)))
                                @foreach(json_decode($listing->image_uploads) as $link)
                                    <img src={{$listing->image_uploads ? Storage::disk('s3')->url($link) : Storage::disk('s3')->url('devimages/rotunda.jpg')}} alt = "shoe image" onclick="myFunction(this);">
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
                                <h1>${{$listing->price}}</h1>
                                    @if($currentUser != null and $currentUser->favorites != null and in_array($listing->id, explode(", " , $currentUser->favorites)))
                                        <form action="/users/removefavorite" method="GET">
                                            @csrf
                                            <input type="hidden" name="type" value="listing">
                                            <input type="hidden" name="id" value="{{$listing->id}}">
                                            <button><i class="fa-solid fa-heart saved"></i></button>
                                        </form>
                                    @else
                                        <form action="/users/addfavorite" method="GET">
                                            @csrf
                                            <input type="hidden" name="type" value="listing">
                                            <input type="hidden" name="id" value="{{$listing->id}}">
                                            <button><i class="fa-solid fa-heart bouncy"></i></button>
                                        </form>
                                    @endif
                
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
                            </div>
                            <div class="product-extra">
                                @php
                                    $listingController::updateViewCount($listing);
                                @endphp
                                <p><i class="fa-solid fa-eye"></i><span>{{$listing->view_count}}</span></p>
                                <p><i class="fa-solid fa-location-dot"></i><span>{{$listing->city}}, {{$listing->state}}</span></p>
                            </div>
                            <div class="product-category">
                                @php
                                    $categories = explode(", ", $listing->category);
                                    $date = $listing->created_at ->format('Y-m-d');
                                @endphp
                                <div class="categories-container">
                                    <p>Categories:</p>
                                    <div class="categories">
                                        @foreach($categories as $category)
                                            <a href="/shop/all?type=all&category={{$category}}">{{$category}}</a>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- Added to differentiate listing types -->
                                <div class="categories-container">
                                    <p>Listing Type:</p>
                                    <div class="categories-listing">
                                    <a href="#" onclick="return false;">For Sale</a>
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
                                @if($currentUser != null and $listing->user_id == $currentUser->id)
                                    <form method="POST" action="/listings/{{$listing->id}}/update">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" id="status" style = " font-size: 17px; text-align:center;" onchange="this.form.submit()">
                                            <option style = "text-align:center;">Status</option>
                                            <option style = "text-align:center;" value="Available">Available</option>
                                            <option style = "text-align:center;" value="Pending">Pending</option>
                                            <option style = "text-align:center;" value="Sold">Sold</option>  
                                        </select>
                                    </form>
                                    
                                
                                    <form class = "editForm" action="/listings/{{$listing->id}}/edit" method = "GET">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$listing->id}}">
                                        <button><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                    </form>

                                    <span id="delete-modal-trigger">
                                        <i class="fa fa-trash" ></i>
                                    </span>
                                @endif
                                
                            </div>
                            <h1>Description</h1>
                            <p>{{$listing->description}}</p>
                        </div>
                        <div class="chat-container">
                            {{-- if I am the listing owner show user panel --}}
                            @if($currentUser != null && $listing->user_id == $currentUser->id)
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
                                @if($currentUser != null && $listing->user_id == $currentUser->id)
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
                <h1>Delete Listing</h1>
                <p>Are you sure you want to delete this listing?</p>

                <div class="clearfix">
                    <input type="button" class="button1" class="cancelbtn" id="cancelbtn" value="Cancel" />
                    <form method="POST" action="/listings/{{$listing->id}}">
                        @csrf
                        @method('DELETE')
                        <input type="submit" class="deletebtn button1" value="Delete"/>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <section class = "listings-parent-container">
         @include('partials._listingCarousel', ['listings' => $listings, 'message' => 'Related Items', 'carouselClass'=>'my-slider','carouselControls' => 'controls', 'carouselP' =>'previous previous1', 'carouselN' => 'next next1', 'currentUser'=>$currentUser])
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
        
        //code for dynamic map
        /*function initMap() {
            var mapTwo;
            var geocoder;
            var listingLat = "{{$listing->latitude}}";
            var listingLong = "{{$listing->longitude}}";
            geocoder = new google.maps.Geocoder();
            var latlng = new google.maps.LatLng(-34.397, 150.644);
            var mapOptions = {
                zoom: 15,
                center: latlng
            }
            mapTwo = new google.maps.Map(document.getElementById('map-container'), mapOptions);
                console.log(listingLat, listingLong);
            if(!isEmpty("{{$listing->street}}")  && !isEmpty("{{$listing->state}}")) {
                console.log('top if');
                var address = "{{$listing->street." ".$listing->city}}";
                //console.log(address);
                geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == 'OK') {
                        mapTwo.setCenter(results[0].geometry.location);
                        var marker = new google.maps.Marker({
                        mapTwo: mapTwo,
                        position: results[0].geometry.location
                    });
                    marker.setMap(mapTwo);
                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
                });
            } else {
                console.log('bottom if');
                console.log("{{$listing->latitude}}", "{{$listing->longitude}}");
                var latlng = new google.maps.LatLng("{{$listing->latitude}}", "{{$listing->longitude}}");
                //console.log(latlng);
                var mapOptions = {
                    zoom: 15,
                    center: latlng
                }
                mapTwo = new google.maps.Map(document.getElementById('map-container'), mapOptions);
                var marker = new google.maps.Marker({
                    mapTwo: mapTwo,
                    position: latlng
                });
                marker.setMap(mapTwo);
            }
        }*/

        //trying to implement static maps
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
        }
        let address = ['{{$listing->street}}', '{{$listing->city}}', '{{$listing->state}}', '{{$listing->postcode}}', '{{$listing->country}}'];
        
        // console.log("This is the address for the map: " + address);
        // console.log("This is the url for the map:  " + getGoogleMapsImage(address));
        
        function myFunction(imgs) {
            var expandImg = document.getElementById("expandedImg");
            expandImg.src = imgs.src;
        }

        var listing_id = "{{$listing->id}}"
        var listingOwner = "{{$listing->user_id}}";
        var userLoggedIn = "{{$currentUser ? $currentUser->id : -1}}";
        var receiverSelected = null; //the person whose chat we have open

        //delete modal
        if(userLoggedIn == listingOwner){
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

        // function toggleText() {
        //     navigator.clipboard.writeText(window.location.href);
        //     var text = document.getElementById("demo");
        //     if (text.style.display === "none") {
        //         text.style.display = "block";
        //     } else {
        //         text.style.display = "none";
        //     }
        // }

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
                console.log("this doesnt work");
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

            // load the initial conversation
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

                // console.log("from: " + receiverSelected + " to: " +listingOwner)
                $.ajax({
                    type: "GET",
                    url: "/messages?from=" + receiverSelected + "&to=" + listingOwner + "&listing_id=" + listing_id, 
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
                                if(data[i].from == listingOwner){
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
            //1) if the listing is not mine, i wanna be able to message the listing owner
            //2) if the listing is mine, select a specifc user, then get their id and sent them the message
            //code for sending messages
            if("{{!auth()->guest()}}"){
                $(document).on('keyup', 'input', function(e){
                    var msg = $(this).val();
                    var datastr = null;
                    console.log('listing Owner: ' + listingOwner);
                    console.log('user logged in: '+ userLoggedIn);
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
        //stuff for chat ends here
    </script>
    <!-- for dynamic map, not needed since using static -->
    <!-- <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2Umn-3TUxP23ok373mWr0U4CHQDItcEk&callback=initMap&libraries=places&v=weekly"
      defer
    ></script> -->
</x-layout>
{{-- @endsection --}}