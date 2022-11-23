


 
<link rel="stylesheet" types ="text/css" href="/css/navigation.css" />

<div class="wrapper">
    <nav>
        <input type="checkbox" id="show-search">
        <input type="checkbox" id="show-menu" class="panel">
        <label for="show-menu" class="menu-icon"><i class="fas fa-bars"></i></label>

        <input type="checkbox" id="show-notifications-panel" class="panel" onclick="change()">
        <input type="checkbox" id="show-profile-panel" class="panel"> 

        <div class="content">

            
            <div class="logo">
                <a href="/">College Marketplace</a>
            </div>
            <ul class="links">
                
                
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
                    
                    <li><a href="/shop/all?type=all">All Items</a></li>
                    </ul>
                </li>

                
                <li><a href="/shop/all?type=rentable">Rent</a></li>

                
                <li><a href="/shop/all?type=lease">Lease</a></li>
                
                

                <li>
                    <a class="desktop-link">Post</a>
                    
                    <input type="checkbox" id="show-services">

                    
                    <label for="show-services" style="position:relative;">Post <span class="down-arrow"></span></label>
                    <ul>
                    <li><a href="/listings/create">For Sale</a></li>
                    
                    <li><a href="/rentables/create">For Rent</a></li>
                    <li><a href="/subleases/create">For Lease</a></li>
                    </ul>
                </li>


                
                <li><a href="#">Requests</a></li>


                
            </ul>

            <ul class="notifications-panel">
                <div class="messages-container">
                    <p>Messages</p>
                    <div class="recently-messaged-list" id="displayUnreadMessages">
                        
                    </div>
                </div>
                <div class="active-sales-container">
                    <p>Active Posts</p>
                    <div class="sales-active-list" id="displayActivePosts">
                        
                    </div>
                </div>
            </ul>

            <ul class="user-panel">
                
                <li>
                    <a class="desktop-link" href="/users/manage">My Profile</a>
                </li>
                <li>
                    <a id="logout-button" onclick="document.getElementById('logout-form').submit();">Logout</a>
                    <form method="POST" id="logout-form" action="/logout">
                        <?php echo csrf_field(); ?>
                    </form>
                </li>
            </ul>
        </div>

        

        
        <div class="searchAndProfile">
            <label for="show-search" class="search-icon">
                
                <i class="fas fa-search"></i>
            </label>
            
            
            <?php if(auth()->guard()->check()): ?>
                <label for="show-notifications-panel" class="bell-icon">
                    <i class="fa-solid fa-bell"></i>
                    <span class = "red-dot-notification" id="notifier"></span>
                </label>
                <label for="show-profile-panel" class="profile-icon">
                    <i class="fa-solid fa-user"></i>
                </label>
            <?php else: ?>
                <label class="bell-icon">
                    <a href="/login">
                        <i class="fa-solid fa-bell"></i>
                    </a>
                </label>
                <label class="profile-icon">
                    <a href="/login">
                        <i class="fa-solid fa-user"></i>
                    </a>
                </label>
            <?php endif; ?>
        </div>

        
        <form action="/shop/all" class="search-box">
            <input type="hidden" name="type" value="all">
            <input type="text" name = "search" placeholder="Type Something to Search..." required>

            
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
        if("<?php echo e(auth()->guest()); ?>") {
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
        }else if("<?php echo e(!auth()->guest()); ?>"){
            // console.log('The USER is logged in. Status is AUTH.');
            var currentUser = <?php echo json_encode(auth()->user()); ?>;
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
                if("<?php echo e(!auth()->guest()); ?>") {
                    $(document).ready(function(){
                        var currentUser = <?php echo json_encode(auth()->user()); ?>;

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
    if("<?php echo e(!auth()->guest()); ?>"){
        $(document).ready(function(){
            var checkMessages = setInterval(function(){
                checkForUnreadMessages();
                if("<?php echo e(auth()->guest()); ?>"){
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
            console.log(obj);
            // $mainImg = jQuery.parseJSON(obj.image_uploads);
            var $wrapper = $('<a>', {href: "localhost:3000"}),
            $imgTag = $('<img />', {
                id: 'test', 
                src: '', 
                alt: 'test'
            }),
            $recentlyMessagedDetails = $("<div />", {class: "recently-messaged-details"});

            $recentlyMessagedDetails.append($('<p />', {text: obj.first_name + obj.last_name})).append($('<p />', {
                html: $('<span />', {text: obj.message})
            })).append($('<p />', {text: obj.updated_at}));

            if(obj.for_listing != null){
                $wrapper.attr("href", "/listings/"+obj.for_listing);
            }else if(obj.for_rentals != null){
                $wrapper.attr("href", "/rentables/"+obj.for_rentals);
            }else if(obj.for_sublease != null){
                $wrapper.attr("href", "/subleases/"+obj.for_sublease);
            }
            $wrapper.append($imgTag).append($recentlyMessagedDetails).appendTo('#displayUnreadMessages');
        });
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

</script><?php /**PATH C:\xampp\htdocs\CollegeMarketplace\resources\views/partials/_navigationBar.blade.php ENDPATH**/ ?>