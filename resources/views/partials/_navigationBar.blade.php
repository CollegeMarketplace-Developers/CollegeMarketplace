{{-- source code using Coding Nepal --}}
{{-- link: https://www.codingnepalweb.com/responsive-dropdown-menu-bar-html-css/ --}}

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
                    <!-- <li><a href="/shop/all?type=rentable">For Rent</a></li>
                    <li><a href="/shop/all?type=lease">For Lease</a></li> -->
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
                    <li><a href="/shop/all?distance=0%20-%200.5%20Mi">Listings < .5 Mile</a></li>
                    <li><a href="/shop/all?type=all">All Items</a></li>
                    </ul>
                </li>

                {{-- button to rent --}}
                <li><a class="desktop-link" href="/shop/all?type=rentable">Rent</a></li>


                {{-- button to lease --}}
                <li><a class="desktop-link" href="/shop/all?type=lease">Lease</a></li>
                
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
                <div class="recently-viewed">
                    <p>Recently Viewed</p>
                    <div class="recently-viewed-list">
                        @foreach (range(0, 9) as $number)
                            <a href="">
                                <img src="" alt="">
                                <div class="recently-viewed-details">
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos, vero.</p>
                                    <div class="details-row">
                                        <p><i class="fa-solid fa-sack-dollar"></i>200</p>
                                        {{-- <p><i class="fa-solid fa-message"></i> 100 </p> --}}
                                        <p><i class="fa-solid fa-eye"></i> 2.6k</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
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
                <label for="show-notifications-panel" class="bell-icon">
                    <i class="fa-solid fa-bell"></i>
                </label>
                <label for="show-profile-panel" class="profile-icon">
                    <i class="fa-solid fa-user"></i>
                </label>
            @else
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
    // var form = document.getElementById("logout-form");

    // document.getElementById("logout-button").addEventListener("click", function () {
    // form.submit();
    // });
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
                console.log('no unread messages')
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
                console.log('no active posts');
                $wrapper = $("<div/>", {
                    class: "no-active-posts",
                    html: $("<p />",{
                        text: "No Active Posts"
                    })
                });
                console.log("right before appending")
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
            $titleImage = jQuery.parseJSON(obj.image_uploads);
            var $wrapper = $('<a>', {href: "localhost:3000"}),
            $imgTag = $('<img />', {
                id: 'test', 
                src: 'https://cmimagestoragebucket.s3.amazonaws.com/'+$titleImage[0], 
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
                $wrapper.append($imgTag).append($displayActiveDetails.append($postTitle).append($detailsRow)).appendTo('#displayActivePosts'); 
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
                $wrapper.append($imgTag).append($displayActiveDetails.append($postTitle).append($detailsRow)).appendTo('#displayActivePosts'); 
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
                $wrapper.append($imgTag).append($displayActiveDetails.append($postTitle).append($detailsRow)).appendTo('#displayActivePosts'); 
            }
        });
    }
</script>