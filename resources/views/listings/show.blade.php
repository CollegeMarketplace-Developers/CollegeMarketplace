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
                            <img src={{$listing->image_uploads ? Storage::disk('s3')->url($titleImage) : asset('/images/rotunda.jpg')}} id = "expandedImg" alt="image doesnt exist">
                        </div>
                        <div class = "img-showcase">
                            @if(is_array(json_decode($listing->image_uploads)))
                                @foreach(json_decode($listing->image_uploads) as $link)
                                    <img src={{$listing->image_uploads ? Storage::disk('s3')->url($link) : asset('/images/rotunda.jpg')}} alt = "shoe image" onclick="myFunction(this);">
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
                
                                    <form><button class="share-button" type="button" title="Share this listing!"><i class="fa-solid fa-arrow-up-from-bracket"></i></button></form>
            
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

        closeButton.addEventListener('click', event => {
        shareDialog.classList.remove('is-open');
        });
    </script>
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
                                <div>
                                    <p>Date Posted:</p>
                                    <span>{{$date}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="map-container" id = "map-container">
                        </div>
                    </div>
                </div>
                <div class="selected-row">
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
                            <form class="shareForm">
                                <button id = 'share' onclick = "toggleText()" type = "button"><i class="fa fa-share-alt"></i>
                                </button>
                            </form> 
                        </div>
                        <h1>Description</h1>
                        <p>{{$listing->description}}</p>
                    </div>
                    <div class="about-seller-and-chat">
                        <div class="about-seller">
                            <i class="fa-solid fa-user"></i>
                            <div>
                                <p>Name</p>
                                <p>Joined: <span>2001-14-16</span></p>
                            </div>
                        </div>
                        <div class="chat-seller">
                            @php
                                $type = null;
                                if($listing instanceof \App\Models\Listing){
                                    $type="listing";
                                }
                                elseif($listing instanceof \App\Models\Rentable){
                                    $type="rentable";
                                }
                                else {
                                    $type="lease";
                                }
                                // this is the listing owner
                                $itemID = $listing->id;
                                $ownerID = $listing->user_id;

                                // this is the current user logged in and the one messaging the owner
                                $from = $currentUser ? $currentUser->id : -1;
                                $item = $listing->id;
                            @endphp

                            @if($currentUser != null && $currentUser->id == $ownerID)
                                {{-- if post is mine --}}
                                <a href="/all/{{$type}}/{{$itemID}}/{{$ownerID}}/{{$from}}/messages">
                                    <p>My Messages</p>
                                </a>
                            @else
                                {{-- only go to this link if I am not the listing owner, aka I'm messaging buyer --}}
                                <a href="/all/{{$type}}/{{$itemID}}/{{$ownerID}}/{{$from}}/messages">
                                    <p>Chat with Seller</p>
                                </a>
                            @endif
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
                    <img src="{{asset('/images/sad-dog.png')}}" alt="">
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
         @include('partials._listingCarousel', ['listings' => $listings, 'message' => 'Related Items', 'carouselClass'=>'my-slider','carouselControls' => 'controls', 'carouselP' =>'previous previous1', 'carouselN' => 'next next1'])
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
        
        console.log(getGoogleMapsImage(address));
        function myFunction(imgs) {
            var expandImg = document.getElementById("expandedImg");
            expandImg.src = imgs.src;
        }
        var listing_id = "{{$listing->id}}"
        var listingOwner = "{{$listing->user_id}}";
        var userLoggedIn = "{{$currentUser ? $currentUser->id : -1}}";
        var receiverSelected = null; //the person whose chat we have open

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
    <!-- for dynamic map, not needed since using static -->
    <!-- <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2Umn-3TUxP23ok373mWr0U4CHQDItcEk&callback=initMap&libraries=places&v=weekly"
      defer
    ></script> -->
</x-layout>
{{-- @endsection --}}