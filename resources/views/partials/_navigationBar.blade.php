{{-- source code using Coding Nepal --}}
{{-- link: https://www.codingnepalweb.com/responsive-dropdown-menu-bar-html-css/ --}}
<?php $apiKey = getenv('GOOGLE_CLIENT_ID');?>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="<?php echo $apiKey; ?>">
 {{-- css for the navigation bar --}}
<link rel="stylesheet" types ="text/css" href="/css/navigation.css" />
{{-- navbar area --}}
<div class="wrapper">
    <nav>
        <input type="checkbox" id="show-search">
        <input type="checkbox" id="show-menu" class="panel">
        <label for="show-menu" class="menu-icon"><i class="fas fa-bars"></i></label>

        <input type="checkbox" id="show-notifications-panel" class="panel" onclick="change()">
        <input type="checkbox" id="show-profile-panel" class="panel"> 

        <div class="content">

            {{-- logo for college marketplace --}}
            <div class="logo">
                <a href="/">College Marketplace</a>
            </div>
            <ul class="links">
                {{-- <li><a href="#">About</a></li> --}}
                {{-- button for buying --}}
                <li>
                    <a class="desktop-link">Buy </a>
                    <input type="checkbox" id="show-features">
                    <label for="show-features" style="position: relative;">Buy <span class="down-arrow"></span> </label>
                    <ul>
                    <li><a href="/shop/all?type=listing">For Sale</a></li>
                    <li><a href="/shop/all?type=all&negotiable=free">Free Listings</a></li>
                    <li>
                        <a class="desktop-link">By Category</a>
                        <input type="checkbox" id="show-items">

                        <label for="show-items" style="position:relative;">By Category<span class="down-arrow"></span></label>
                        <ul>
                        <li><a href="/shop/all?type=all&category=furniture">Furniture</a></li>
                        <li><a href="/shop/all?type=all&category=kitchen">Kitchen</a></li>
                        <li><a href="/shop/all?type=all&category=electronics">Electronics</a></li>
                        <li><a href="/shop/all?type=all&category=clothes">Clothes</a></li>
                        <li><a href="/shop/all?type=all&category=school%20accessories">School Accessories</a></li>
                        </ul>
                    </li>
                    <li><a id ="nearbyItemsLink" href="/shop/all?type=all&distance=0.5%20Mi">Listings < .5 Mile</a></li>
                    {{-- <li>
                        <form id = "distanceForm" method="GET" action="/shop/all?type=all&distance=0%20-%200.5%20Mi">
                            @csrf
                            <input type="hidden" name="type" id="type" value="all">
                            <input type="hidden" name="lat" id="lat" value = '0'>
                            <input type="hidden" name="lng" id="lng" value = '0'>
                            <button type="submit"  id="submit" >Listings < .5 Mile</button>
                        </form>
                    </li> --}}
                    <li><a href="/shop/all?type=all">All Items</a></li>
                    </ul>
                </li>

                {{-- button for renting --}}
                <li><a href="/shop/all?type=rentable">Rent</a></li>

                {{-- button for leasing --}}
                <li><a href="/shop/all?type=lease">Lease</a></li>
                
                {{-- Post things --}}

                <li>
                    <a class="desktop-link">Post</a>
                    {{-- used in the side panel --}}
                    <input type="checkbox" id="show-services">

                    {{-- used in the collapsed menu --}}
                    <label for="show-services" style="position:relative;">Post <span class="down-arrow"></span></label>
                    <ul>
                    <li><a href="/listings/create">For Sale</a></li>
                    {{-- <li><a href="/yardsales/create">Host a Yard Sale</a></li> --}}
                    <li><a href="/rentables/create">For Rent</a></li>
                    <li><a href="/subleases/create">For Lease</a></li>
                    </ul>
                </li>


                {{-- button to request --}}
                <li><a href="#">Requests</a></li>


                {{-- @auth
                    <li>
                        <a class="desktop-link">{{auth()->user()->first_name}}</a>
                        <input type="checkbox" id="show-user-links">
                        <label for="show-user-links">{{auth()->user()->first_name}}</label>
                        <ul>
                            onclick="displayLoadingPage()"
                            <li><a href="/users/manage">Manage Listings</a></li>
                            <li>
                                <a id="logout-button" onclick="document.getElementById('logout-form').submit();">Logout</a>
                                <form method="POST" id="logout-form" action="/logout">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @else   
                    <li><a href="/login">Login</a></li>
                @endauth --}}
            </ul>

            <ul class="notifications-panel">
                <div class="messages-container">
                    <p>Messages</p>
                    <div class="recently-messaged-list" id="displayUnreadMessages">
                        {{-- @foreach (range(0, 2) as $number)
                            <a href="">
                                <img src="" alt="">
                                <div class="recently-messaged-details">
                                   <p>Jacob</p>
                                   <p><span>You:</span> Yes it works. Sounds good to me</p>
                                   <p>10 days ago</p> 
                                </div>
                            </a>
                        @endforeach --}}
                    </div>
                </div>
                <div class="active-sales-container">
                    <p>Active Posts</p>
                    <div class="sales-active-list" id="displayActivePosts">
                        {{-- @foreach (range(0, 3) as $number)
                            <a href="">
                                <img src="" alt="">
                                <div class="sales-active-details">
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos, vero.</p>
                                    <div class="details-row">
                                        <p><i class="fa-solid fa-sack-dollar"></i>200</p>
                                        <p><i class="fa-solid fa-message"></i> 100 </p>
                                        <p><i class="fa-solid fa-eye"></i> 2.6k</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach --}}
                    </div>
                </div>
            </ul>

            <ul class="user-panel">
                {{-- <div class="recently-viewed">
                    <p>Recently Viewed</p>
                    <div class="recently-viewed-list">
                        @foreach (range(0, 9) as $number)
                            <a href="">
                                <img src="" alt="">
                                <div class="recently-viewed-details">
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos, vero.</p>
                                    <div class="details-row">
                                        <p><i class="fa-solid fa-sack-dollar"></i>200</p>
                                        <p><i class="fa-solid fa-eye"></i> 2.6k</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div> --}}
                <li>
                    <a class="desktop-link" href="/users/manage">My Profile</a>
                </li>
                <li>
                    <a id="logout-button" onclick="document.getElementById('logout-form').submit();">Logout</a>
                    <form method="POST" id="logout-form" action="/logout">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>

        {{-- this is the search forum --}}

        {{-- label for search icon checkbox --}}
        <div class="searchAndProfile">
            <label for="show-search" class="search-icon">
                {{-- search icon gets converted into x mark when search bar is displayed .... navigation : 81 --}}
                <i class="fas fa-search"></i>
            </label>
            
            {{-- only if the user is logged in, then the side panels will show --}}
            @auth
            <script>
                function onLoad() {
                    gapi.load('auth2', function() {
                    gapi.auth2.init();
                    });
                }
                // Check if the user is signed in
                if (gapi.auth2.getAuthInstance().isSignedIn.get()) {
                // Get the user's profile information
                var profile = gapi.auth2.getAuthInstance().currentUser.get().getBasicProfile();
                console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
                console.log('Name: ' + profile.getName());
                console.log('Image URL: ' + profile.getImageUrl());
                console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
                // Get the user's profile icon URL
                var profileIconUrl = profile.getImageUrl();

                // Replace the existing icon with the user's profile icon
                var iconElement = document.getElementById("icon");
                iconElement.src = profileIconUrl;

                }
            </script>
                <label for="show-notifications-panel" class="bell-icon">
                    <i class="fa-solid fa-bell"></i>
                    <span class = "red-dot-notification" id="notifier"></span>
                </label>
                <label for="show-profile-panel" class="profile-icon">
                    <i id = "icon" class="fa-solid fa-user"></i>
                </label>
            @else
                <label class="bell-icon">
                    <a href="/login">
                        <i class="fa-solid fa-bell"></i>
                    </a>
                </label>
                <label class="profile-icon">
                    <a href="/login">
                        <i id = "icon" class="fa-solid fa-user"></i>
                    </a>
                </label>
            @endauth
        </div>

        {{-- THe search bar is the input --}}
        <form action="/shop/all" class="search-box">
            <input type="hidden" name="type" value="all">
            <input type="text" name = "search" placeholder="Type Something to Search..." required>

            {{-- This is the arrow button to submit the joint --}}
            <button type="submit" class="go-icon"><i class="fas fa-long-arrow-alt-right"></i></button>
        </form>

        <div class="search-message">
            <span></span>
            <p>Please keep the search generic. Use simple words like table or camera</p>
        </div>
    </nav>
</div>
<script>

    // ---------------------------------------------------------------
    // User Location related  functions
    // ---------------------------------------------------------------

    navigator.permissions.query({ name: 'geolocation' }).then((permissionStatus) => {
        permissionStatus.onchange = () => {
            // console.log(permissionStatus.state);
            updateUrlForNearbyItems();
        };
    });

    var updateUserLatLng = false;

    updateUrlForNearbyItems();

    function updateUrlForNearbyItems(){
         //CASE 1:
        //  if the user is not logged in
        if("{{auth()->guest()}}") {
            // console.log('The USER is not logged in. Status is GUEST.')

            //CASE 1: 
            //  try to get the user's current location
            //  if location feature is allowed, will update the url link for nearby items in the navbar
            if (navigator.geolocation) { 
                navigator.geolocation.getCurrentPosition(showMyPosition,showMyError,myoptions);

            //CASE 2:
            //  other wise the nearby items are just regular items 
            //  the user is not logged in, so we can't check their location on file, also not given permission to retrieve user's location
            } else { 
                // console.log("Unable to extract users location via GEOLOCATION.");
                $('#nearbyItemsLink').attr('href', '/shop/all?type=all&distance=0.5%20Mi&lat=null&lng=null');
            }
        //CASE 2:
        //  if the user is logged in
        }else if("{{!auth()->guest()}}"){
            // console.log('The USER is logged in. Status is AUTH.');
            var currentUser = {!!json_encode(auth()->user())!!};
            // console.log(currentUser);

            //CASE 1: 
            //  if the user is logged in and has lat and long in the db
            if(currentUser.latitude != null && currentUser.longitude != null){
                // console.log('User was logged in and the location was retrieved from the DB; The href was updated to: ');
                // console.log('/shop/all?type=all&distance=0.5%20Mi&lat=' + currentUser.latitude+ "&lng="+currentUser.longitude);
                $('#nearbyItemsLink').attr('href', '/shop/all?type=all&distance=0.5%20Mi&lat=' +currentUser.latitude + "&lng="+currentUser.longitude);
            }

            //CASE 2:
            //  if the user is logged in and there is no lat/long in db and we are allowed to get current location
            else if(currentUser.latitude == null && currentUser.longitude == null){
                // console.log('User was logged in but the location was not found in DB.');
                updateUserLatLng = true;
                navigator.geolocation.getCurrentPosition(showMyPosition,showMyError,myoptions);

            }

            //CASE 3:
            //  if the user is logged in and ther eis not lat/long in the db.
            //  we are also not allowed to extract the users location.
            else{
                // console.log("Unable to extract users location via GEOLOCATION.");
                $('#nearbyItemsLink').attr('href', '/shop/all?type=all&distance=0.5%20Mi&lat=null&lng=null');
            }
        }
    }

    function showMyPosition(position) {
        $(document).ready(function(){

            // console.log('Users location was extracted via GEOLOCATION and the href link is updated to: '+'/shop/all?type=all&distance=0.5%20Mi&lat=' + position.coords.latitude + "&lng="+position.coords.longitude);

            $('#nearbyItemsLink').attr('href', '/shop/all?type=all&distance=0.5%20Mi&lat=' + position.coords.latitude + "&lng="+position.coords.longitude);

            if(updateUserLatLng){
                if("{{!auth()->guest()}}") {
                    $(document).ready(function(){
                        var currentUser = {!!json_encode(auth()->user())!!};

                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        var datastr = "USER_ID=" + currentUser.id + "&lat=" + position.coords.latitude + "&lng=" + position.coords.longitude;
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "/users/update/latlng", 
                            type: 'POST',
                            data: datastr,
                            dataType: 'JSON',
                            _token: CSRF_TOKEN,
                            cache: false,
                            success: function (data) {
                                console.log(data);
                                location.reload();
                            },
                            error: function (jqXHR, status, err) {
                                console.log(err);
                            },
                            complete: function () {
                                // scrollToBottomFunc();
                            }
                        })
                    });
                }
            }
        });
    }

    function showMyError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                $('#nearbyItemsLink').attr('href', '/shop/all?type=all&distance=0.5%20Mi&lat=null&lng=null');
                // console.log("User denied the request for Geolocation.");
            break;
            case error.POSITION_UNAVAILABLE:
                $('#nearbyItemsLink').attr('href', '/shop/all?type=all&distance=0.5%20Mi&lat=null&lng=null');
                // console.log("Location information is unavailable.");
            break;
            case error.TIMEOUT:
                $('#nearbyItemsLink').attr('href', '/shop/all?type=all&distance=0.5%20Mi&lat=null&lng=null');
                // console.log( "The request to get user location timed out.");
            break;
            case error.UNKNOWN_ERROR:
                $('#nearbyItemsLink').attr('href', '/shop/all?type=all&distance=0.5%20Mi&lat=null&lng=null');
                // console.log( "An unknown error occurred.");
            break;
        }
    }

    var myoptions = {
        enableHighAccuracy: true,
        timeout: 1000,
        maximumAge: 0
    };

    // -------------------------------------------------------
    // Side panel related functions
    // -------------------------------------------------------

    //if the user is logged in, check every 10 seconds if there are unread messages
    if("{{!auth()->guest()}}"){
        $(document).ready(function(){
            var checkMessages = setInterval(function(){
                checkForUnreadMessages();
                if("{{auth()->guest()}}"){
                    clearInterval(checkMessages);
                    console.log("User Was Logged Out. Stopped Ajax Requests for Unread Messages");
                }
            }, 10000);
        });
    }

    function checkForUnreadMessages(){
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
        $.ajax({
            type:'GET',
            url: '/unreadmessages/count',
            data: 'JSON',
            cache: false, //look into caching later
            success:function(data) {
                //add your success handling here
                if(data == 0){
                    document.getElementById('notifier').style.display = "none";
                }else{
                    document.getElementById('notifier').style.display = "flex";
                }
            },
            error: function (data, textStatus, errorThrown) {
                console.log("failed");
                //add your failed handling here
            },
        });
    }

    $(document).ready(function(){
        $('input.panel').on('change', function() {
            $('input.panel').not(this).prop('checked', false);  
        });
    });


    //
    //-------------------------- Side Notification and User Panels Code -------------------
    //
    function change() {
        var decider = document.getElementById('show-notifications-panel');
        if(decider.checked){
            getUnreadMessages();
            getActivePosts();
        } else {
            
        }
    }

    function getUnreadMessages(){
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
        $.ajax({
            type:'GET',
            url: '/unreadmessages',
            data: 'JSON',
            cache: false, //look into caching later
            success:function(data) {
                //add your success handling here
                showUnreadMessages(data);
            },
            error: function (data, textStatus, errorThrown) {
                console.log("failed");
                //add your failed handling here
            },
        });
    }

    function showUnreadMessages(data){
        // console.log(data);
        $(document).ready(function(){
            $('#displayUnreadMessages').empty();
            // if there are no unread messages
            if(data == null || data.length == 0 ){
                // console.log('no unread messages')
                $wrapper = $("<div/>", {
                    class: "no-unread-messages",
                    html: $("<p />",{
                        text: "No Unread Messages"
                    })
                });
                $wrapper.appendTo('#displayUnreadMessages');
            }else{
                // if there are unread messages, loop through each one
                jQuery.each(data, function(index, value){
                    supportUnreadMessages(value);
                });
            }
        })
        
    }

    function supportUnreadMessages(obj){
        $(document).ready(function(){

            $titleImage = obj.image_uploads != null ? jQuery.parseJSON(obj.image_uploads) : null;
            $source = $titleImage == null ? 'https://picsum.photos/300/200?sig=' + Math.floor(Math.random() * 100) + 1 : 'https://cmimagestoragebucket.s3.amazonaws.com/'+$titleImage[0];

            var $wrapper = $('<a>', {href: "localhost:3000"}),
            $imgTag = $('<img />', {
                id: 'test', 
                src: $source, 
                alt: 'test'
            }),

            $recentlyMessagedDetails = $("<div />", {class: "recently-messaged-details"});
            $timeDifference = calculateTimeDifference( obj.created_at)
            $recentlyMessagedDetails.append($('<p />', {text: obj.first_name + obj.last_name})).append($('<p />', {
                html: $('<span />', {text: obj.message})
            })).append($('<p />', {text: $timeDifference}));

            if(obj.for_listing != null){
                $wrapper.attr("href", "/listings/"+obj.for_listing);

                $wrapper.append($imgTag).append($recentlyMessagedDetails).append($('<p/>', {text: "Sale",class: 'type-badge type-listing'})).appendTo('#displayUnreadMessages');
            }else if(obj.for_rentals != null){
                $wrapper.attr("href", "/rentables/"+obj.for_rentals);

                $wrapper.append($imgTag).append($recentlyMessagedDetails).append($('<p/>', {text: "Rent",class: 'type-badge type-rent'})).appendTo('#displayUnreadMessages');
            }else if(obj.for_sublease != null){
                $wrapper.attr("href", "/subleases/"+obj.for_sublease);

                $wrapper.append($imgTag).append($recentlyMessagedDetails).append($('<p/>', {text: "Lease",class: 'type-badge type-lease'})).appendTo('#displayUnreadMessages');
            }
        });
    }
    
    function calculateTimeDifference(inputTime) {
        // Get the current time and date
        const currentTime = new Date();

        // Parse the time and date from the SQL database
        const sqlTime = new Date(inputTime);

        // Calculate the difference between the two times in milliseconds
        const timeDifference = currentTime - sqlTime;

        // Convert the time difference to a readable format (e.g. "2 hours, 30 minutes")
        const formattedTimeDifference = formatTimeDifference(timeDifference);

        // Output the time difference
        return (formattedTimeDifference);
    }

    function formatTimeDifference(timeDifference) {
        // Calculate the number of seconds, minutes, hours, and days in the time difference
        const seconds = Math.floor(timeDifference / 1000);
        const minutes = Math.floor(timeDifference / (1000 * 60));
        const hours = Math.floor(timeDifference / (1000 * 60 * 60));
        const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));

        // Return a human-readable string representing the time difference
        if (seconds < 60) {
            return "" + seconds + " seconds ago";
        } else if (minutes < 60) {
            return "" + minutes + " minutes ago";
        } else if (hours < 24) {
            return "" + hours + " hours ago";
        } else {
            return "" + days + " days ago";
        }
    }

    function getActivePosts(){
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
        $.ajax({
            type:'GET',
            url: '/activeposts',
            data: 'JSON',
            cache: false, //look into caching later
            success:function(data) {
                showActivePosts(data);
            },
            error: function (data, textStatus, errorThrown) {
                console.log("failed");
                //add your failed handling here
            },
        });
    }

    function showActivePosts(data){
        $(document).ready(function(){
            $('#displayActivePosts').empty();
            if(data == null || data.length == 0 ){
                // console.log('no active posts');
                $wrapper = $("<div/>", {
                    class: "no-active-posts",
                    html: $("<p />",{
                        text: "No Active Posts"
                    })
                });
                // console.log("right before appending")
                $wrapper.appendTo('#displayActivePosts');
            }else{
                jQuery.each(data, function(index, value){
                    supportActivePosts(value);
                });
            }
        })
    }

    function supportActivePosts(obj){
        $(document).ready(function(){
            //if the image_uploads are not null, parse the data or set it equal to null
            $titleImage = obj.image_uploads != null ? jQuery.parseJSON(obj.image_uploads) : null;
            $source = $titleImage == null ? 'https://picsum.photos/300/200?sig=' + Math.floor(Math.random() * 100) + 1 : 'https://cmimagestoragebucket.s3.amazonaws.com/'+$titleImage[0];
            var $wrapper = $('<a>', {href: "localhost:3000"}),
            $imgTag = $('<img />', {
                id: 'test', 
                src: $source, 
                alt: 'test'
            }),

            $displayActiveDetails = $("<div />", {class: "sales-active-details"});
            
            if(obj.item_name != null){
                var $postTitle = $("<p />", {text: obj.item_name}),
                    $detailsRow = $("<div />", {
                        class: "details-row",
                        html: $('<p />').append(
                            $('<i />', {
                                class: "fa-solid fa-sack-dollar"
                            })
                        ).append($("<span />", {text: obj.price})).add($("<p />").append(
                            $('<i />', {
                                class: "fa-solid fa-eye"
                            })
                        ).append($("<span />", {text: obj.view_count})))
                    }); 
                $wrapper.attr("href", "/listings/"+obj.id)
                $wrapper.append($imgTag).append($displayActiveDetails.append($postTitle).append($detailsRow)).append($('<p/>', {text: "Sale",class: 'type-badge type-listing'})).appendTo('#displayActivePosts'); 
            }else if(obj.rental_title != null){
                var $postTitle = $("<p />", {text: obj.rental_title}),
                    $detailsRow = $("<div />", {
                        class: "details-row",
                        html: $('<p />').append(
                            $('<i />', {
                                class: "fa-solid fa-sack-dollar"
                            })
                        ).append($("<span />", {text: obj.rental_charging})).add($("<p />").append(
                            $('<i />', {
                                class: "fa-solid fa-eye"
                            })
                        ).append($("<span />", {text: obj.view_count})))
                    }); 
                $wrapper.attr("href", "/rentables/"+obj.id)
                $wrapper.append($imgTag).append($displayActiveDetails.append($postTitle).append($detailsRow)).append($('<p/>', {text: "Rent",class: 'type-badge type-rent'})).appendTo('#displayActivePosts'); 
            }else if(obj.sublease_title != null){
                var $postTitle = $("<p />", {text: obj.sublease_title}),
                    $detailsRow = $("<div />", {
                        class: "details-row",
                        html: $('<p />').append(
                            $('<i />', {
                                class: "fa-solid fa-sack-dollar"
                            })
                        ).append($("<span />", {text: obj.rent})).add($("<p />").append(
                            $('<i />', {
                                class: "fa-solid fa-eye"
                            })
                        ).append($("<span />", {text: obj.view_count})))
                    }); 
                $wrapper.attr("href", "/subleases/"+obj.id)
                $wrapper.append($imgTag).append($displayActiveDetails.append($postTitle).append($detailsRow)).append($('<p/>', {text: "Lease",class: 'type-badge type-lease'})).appendTo('#displayActivePosts'); 
            }
        });
    }

</script>