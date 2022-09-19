{{-- source code using Coding Nepal --}}
{{-- link: https://www.codingnepalweb.com/responsive-dropdown-menu-bar-html-css/ --}}

 {{-- css for the navigation bar --}}
<link rel="stylesheet" types ="text/css" href="/css/navigation.css" />
{{-- navbar area --}}
<div class="wrapper">
    <nav>
        <input type="checkbox" id="show-search">
        <input type="checkbox" id="show-menu">
        <label for="show-menu" class="menu-icon"><i class="fas fa-bars"></i></label>

        <input type="checkbox" id="show-notifications-panel">
        <input type="checkbox" id="show-profile-panel">

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
                    <li><a href="/shop/all?type=rentable">For Rent</a></li>
                    <li><a href="/shop/all?type=lease">For Lease</a></li>
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
                <p>notifications</p>
            </ul>
            <ul class="user-panel">
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
                <label for="show-profile-panel" class="profile-icon">
                    <i class="fa-solid fa-user"></i>
                </label>
                <label for="show-notifications-panel" class="bell-icon">
                    <i class="fa-solid fa-bell"></i>
                </label>
            @else
                <label class="profile-icon">
                    <a href="/login">
                        <i class="fa-solid fa-user"></i>
                    </a>
                </label>
                <label class="bell-icon">
                    <a href="/login">
                        <i class="fa-solid fa-bell"></i>
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
            <p>Please keep the search generic and consise. We can't compete with Google.</p>
        </div>
    </nav>
    <script>
        // var form = document.getElementById("logout-form");

        // document.getElementById("logout-button").addEventListener("click", function () {
        // form.submit();
        // });
    </script>
</div>