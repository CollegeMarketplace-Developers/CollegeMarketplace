{{-- @extends('layout') --}}

{{-- @section('content') --}}

{{-- css for individual user listing --}}
@inject('rentablesController', 'App\Http\Controllers\RentablesController')
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
                            @if($rentable->status =='Available')
                                <div class="stat-container">
                                    <div class="stat green">
                                    </div>
                                </div>
                            @else
                                <div class="stat-container">
                                    <div class="stat">
                                    </div>
                                </div>
                            @endif 
                            @php
                                if(isset($rentable->image_uploads)){
                                    //decode the json object
                                    $imgLinks = json_decode($rentable->image_uploads);
                                    $titleImage = null;
                                    if(is_array($imgLinks)){
                                        $titleImage = $imgLinks[0];
                                    }
                                }
                            @endphp
                            <img src={{$rentable->image_uploads ? Storage::disk('s3')->url($titleImage) : asset('/images/rotunda.jpg')}} id = "expandedImg" alt="image doesnt exist">
                        </div>
                        <div class = "img-showcase">
                            @if(is_array(json_decode($rentable->image_uploads)))
                                @foreach(json_decode($rentable->image_uploads) as $link)
                                    <img src={{$rentable->image_uploads ? Storage::disk('s3')->url($link) : asset('/images/rotunda.jpg')}} alt = "shoe image" onclick="myFunction(this);">
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
                                <h1>${{$rentable->rental_charging}} / {{$rentable->rental_duration}}</h1>
                                @if($currentUser != null and $currentUser->rentableFavorites != null and in_array($rentable->id, explode(", " , $currentUser->rentableFavorites)))
                                    <form action="/users/removefavorite" method="GET">
                                        @csrf
                                        <input type="hidden" name="type" value="rentable">
                                        <input type="hidden" name="id" value={{$rentable->id}}>
                                        <button><i class="fa-solid fa-heart saved"></i></button>
                                    </form>
                                @else
                                    <form action="/users/addfavorite" method="GET">
                                        @csrf
                                        <input type="hidden" name="type" value="rentable">
                                        <input type="hidden" name="id" value="{{$rentable->id}}">
                                        <button><i class="fa-solid fa-heart bouncy"></i></button>
                                    </form>
                                @endif

                            </div>
                            <div class="product-header">
                                <h1>{{$rentable->rental_title}}</h1> 
                            </div>
                            <div class="product-extra">
                                <div>
                                    <p>Price:</p> 
                                    <span>{{$rentable->negotiable}}</span>
                                </div>
                                <div>
                                    <p>Condition:</p>
                                    <span>{{$rentable->condition}}</span>
                                </div>
                                @php
                                    $rentablesController::updateViewCount($rentable);
                                @endphp
                                <p><i class="fa-solid fa-eye"></i><span>{{$rentable->view_count}}</span></p>
                                <p><i class="fa-solid fa-location-dot"></i><span>{{$rentable->city}}, {{$rentable->state}}</span></p>
                            </div>
                            <div class="product-category">
                                @php
                                    $categories = explode(", ", $rentable->category);
                                    $date = $rentable->created_at ->format('Y-m-d');
                                @endphp
                                <div class="categories-container">
                                    <p>Categories:</p>
                                    <div class="categories">
                                        @foreach($categories as $category)
                                            <a href="/shop/all?type=all&category={{$category}}">{{$category}}</a>
                                        @endforeach
                                    </div>
                                </div>
                                <div>
                                    <p>Date Posted:</p>
                                    <span>{{$date}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="map-container" id = "map-container">
                        </div>
                        {{-- 
                        <div class="product-buttons">
                            <ul>
                                <!-- vertical line added by this code -->
                                @if($currentUser != null and $rentable->user_id == $currentUser->id)
                                    <li>
                                        <form method="POST" action="/rentables/{{$rentable->id}}/update">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" id="status" style = " font-size: 17px; text-align:center;" onchange="this.form.submit()">
                                                <option style = "text-align:center;">Status</option>
                                                <option style = "text-align:center;" value="Available">Available</option>
                                                <option style = "text-align:center;" value="Rented">Rented</option>
                                            </select>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="/rentables/{{$rentable->id}}/edit" method="GET">
                                            @csrf
                                            <button><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </form>
                                    </li>
                                    <li>
                                        <span id="delete-modal-trigger">
                                            <i class="fa fa-trash" ></i>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <p id='demo' style='text-align:right; display: none; padding-right: 20px;'>Link Copied!</p> --}}
                    </div>
                </div>
                <div class="product-description-area">
                    <div class="controls">
                        @if($currentUser != null and $rentable->user_id == $currentUser->id)
                            <form method="POST" action="/rentables/{{$rentable->id}}/update">
                                @csrf
                                @method('PUT')
                                <select name="status" id="status" style = " font-size: 17px; text-align:center;" onchange="this.form.submit()">
                                    <option style = "text-align:center;">Status</option>
                                    <option style = "text-align:center;" value="Available">Available</option>
                                    <option style = "text-align:center;" value="Rented">Rented</option>
                                </select>
                            </form>
                            <form class="editForm" action="/rentables/{{$rentable->id}}/edit" method="GET">
                                @csrf
                                <button><i class="fa fa-pencil" aria-hidden="true"></i></button>
                            </form>
                            <span id="delete-modal-trigger">
                                <i class="fa fa-trash" ></i>
                            </span>
                        @endif
                        <form class="shareForm"><button id = 'share' onclick = "toggleText()" type = "button"><i class="fa fa-share-alt"></i></button></form> 
                    </div>
                    <h1>Description</h1>
                    <p>{{$rentable->description}}</p>
                </div>
                <div class="map-container-mobile" id="map-container-mobile">
    
                </div>
                <div>
                    {{-- community thread goes here --}}
                </div>
            </div>
            {{-- old user chat and map area was here--}}
            {{-- map chat container was here --}}
        </div>

        {{-- delete modal is here --}}
        <div class="modal" id="delete-modal">
            <div class="modal-content">
                <div class="sad-dog-container">
                    <img src="{{asset('/images/sad-dog.png')}}" alt="">
                </div>
                <span class="close">&times;</span>
                <h1>Delete Listing</h1>
                <p>Are you sure you want to delete this listing?</p>

                <div class="clearfix">
                    <input type="button" class="button1" class="cancelbtn" id="cancelbtn" value="Cancel" />
                    <form method="POST" action="/rentables/{{$rentable->id}}">
                        @csrf
                        @method('DELETE')
                        <input type="submit" class="deletebtn button1" value="Delete"/>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- carousel section --}}
    <section class = "listings-parent-container">
        {{-- carousel for rentable items --}}
        @include('partials._rentablesCarousel',
        ['rentables'=> $rentables, 'message' => 'Items For Rent' , 'carouselClass' => 'slider2',
        'carouselControls' => 'controls2', 'carouselP' =>' previous previous2', 'carouselN' => 'next next2'])
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>    

    {{-- for pusher real time messages --}}
     <script src="https://js.pusher.com/7.1/pusher.min.js"></script>

    <script>
        function isEmpty(input){
            if(input === '' || input === null || input === undefined || input == null){
                return true;
            }return false;
        }
        
        //code for dynamic maps
        /*function initMap() {
            var mapTwo;
            var geocoder;
            var listingLat = "{{$rentable->latitude}}";
            var listingLong = "{{$rentable->longitude}}";

            geocoder = new google.maps.Geocoder();
            var latlng = new google.maps.LatLng(-34.397, 150.644);
            var mapOptions = {
                zoom: 15,
                center: latlng
            }

            mapTwo = new google.maps.Map(document.getElementById('map-container'), mapOptions);
                console.log(listingLat, listingLong);

            if(!isEmpty("{{$rentable->street}}")  && !isEmpty("{{$rentable->state}}")) {
                console.log('top if');
                var address = "{{$rentable->street." ".$rentable->city}}";
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
                console.log("{{$rentable->latitude}}", "{{$rentable->longitude}}");
                var latlng = new google.maps.LatLng("{{$rentable->latitude}}", "{{$rentable->longitude}}");
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

        let address = ['{{$rentable->street}}', '{{$rentable->city}}', '{{$rentable->state}}', '{{$rentable->postcode}}', '{{$rentable->country}}'];
        
        console.log(getGoogleMapsImage(address));
        

        function myFunction(imgs) {
            var expandImg = document.getElementById("expandedImg");
            expandImg.src = imgs.src;
        }

        var listing_id = "{{$rentable->id}}"
        var listingOwner = "{{$rentable->user_id}}";
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
            // if I am not the listing owner, show me messages that have been sent to me instantly
            // if I am the listing owner -> get selected user and update their information or display a pending symbol
            channel.bind('my-event', function(data) {
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
                            if(data.for_rentals == listing_id){
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
                if("{{$rentable->user_id}}" != userLoggedIn){
                    var ul = document.getElementById("messages");
                    ul.innerHTML = null;
                    
                    $.ajax({
                        type: "GET",
                        url: "/messages?from=" + UserSending + "&to=" + UserReceiving + "&rental_id=" + listing_id, // need to create this route
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

            // if I am the listing owner, I want to click on a user and get all the messages from me to them or them to me
            $('.user').click(function(){
                var ul = document.getElementById("messages");
                ul.innerHTML = null;

                $('.user-wrapper').removeClass('active');
                $('.messages-container').addClass('active');
                receiverSelected = $(this).attr('id');
                $(this).find('.pending').remove();

                $.ajax({
                    type: "GET",
                    url: "/messages?from=" + receiverSelected + "&to=" + listingOwner + "&rental_id=" + listing_id, // need to create this route
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
                                if(data[i].from == listingOwner){
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
            });

            // take to take in to account two different scenarios
            //1) if the listing is not mine, i wanna be able to message the listing owner
            //2) if the listing is mine, select a specifc user, then get their id and sent them the message
            if("{{!auth()->guest()}}"){
                $(document).on('keyup', 'input', function(e){
                    var msg = $(this).val();
                    var datastr = null;
                    // if I am the listing owner, then i need a receiver id which should be the person I have selected form the users list
                    if(listingOwner == userLoggedIn){
                        // if it is my ownlisting, use receiver id, instead of listing owner id
                        datastr = "receiver_id=" + receiverSelected + "&message=" + msg + "&for_rentals=" + listing_id;
                            // console.log(datastr);
                    }else{ //else send a message to the listing owner from me thats default
                        // console.log("bottom branch");
                        datastr = "receiver_id=" + listingOwner + "&message=" + msg + "&for_rentals=" + listing_id;
                    }

                    if(e.keyCode == 13 && msg != '' && listingOwner != ''){
                        $(this).val(''); // while pressed enter text box will be empty
                        // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            url: "/sendmessage", 
                            type: 'POST',
                            data: datastr,
                            // dataType: 'JSON',
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

        //delete modal
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

        function toggleText() {
            navigator.clipboard.writeText(window.location.href);
            var text = document.getElementById("demo");
            if (text.style.display === "none") {
                text.style.display = "block";
            } else {
                text.style.display = "none";
            }
        }
    </script>

    <!-- code for dynamic maps -->
    <!-- <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2Umn-3TUxP23ok373mWr0U4CHQDItcEk&callback=initMap&libraries=places&v=weekly"
      defer
    ></script> -->

</x-layout>
{{-- @endsection --}}