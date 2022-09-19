


 
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
                    <li><a href="/shop/all?type=rentable">For Rent</a></li>
                    <li><a href="/shop/all?type=lease">For Lease</a></li>
                    <li><a href="/shop/all?type=listing">For Sale</a></li>
                    <li><a href="/shop/all?type=all">All Items</a></li>
                    </ul>
                </li>


                
                
                <!-- <li>
                    <a class="desktop-link">Post</a>
                    
                    <input type="checkbox" id="show-services">

                    
                    <label for="show-services" style="position:relative;">Post <span class="down-arrow"></span></label>
                    <ul>
                    <li><a href="/listings/create">For Sale</a></li>
                    
                    <li><a href="/rentables/create">For Rent</a></li>
                    <li><a href="/subleases/create">For Lease</a></li>
                    </ul>
                </li> -->



                
                <li><a class="desktop-link" href="/listings/create">Sell</a></li>


                
                <li><a class="desktop-link" href="/rentables/create">Rent</a></li>


                
                <li><a class="desktop-link" href="/subleases/create">Lease</a></li>


                
                <li><a href="#">Requests</a></li>


                
            </ul>

            <ul class="notifications-panel">
                <div class="messages-container">
                    <p>Messages</p>
                    <div class="recently-messaged-list">
                        <?php $__currentLoopData = range(0, 9); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $number): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="">
                                <img src="" alt="">
                                <div class="recently-messaged-details">
                                   <p>Jacob</p>
                                   <p><span>You:</span> Yes it works. Sounds good to me</p>
                                   <p>10 days ago</p>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="active-sales-container">
                    <p>Active Posts</p>
                    <div class="sales-active-list">
                        <?php $__currentLoopData = range(0, 9); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $number): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </ul>

            <ul class="user-panel">
                <div class="recently-viewed">
                    <p>Recently Viewed</p>
                    <div class="recently-viewed-list">
                        <?php $__currentLoopData = range(0, 9); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $number): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
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
                <label for="show-profile-panel" class="profile-icon">
                    <i class="fa-solid fa-user"></i>
                </label>
                <label for="show-notifications-panel" class="bell-icon">
                    <i class="fa-solid fa-bell"></i>
                </label>
            <?php else: ?>
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
            //console.log("ran");
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
                    //console.log("worked");
                    console.log(data);
                },
                error: function (data, textStatus, errorThrown) {
                    console.log("failed");
                    //add your failed handling here
                },
            });
        }

        function getActivePosts(){
            //console.log("ran");
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            $.ajax({
                type:'GET',
                url: '/activeposts',
                data: 'JSON',
                cache: false, //look into caching later
                success:function(data) {
                    //add your success handling here
                    //console.log("worked");
                    console.log(data);
                },
                error: function (data, textStatus, errorThrown) {
                    console.log("failed");
                    //add your failed handling here
                },
            });
        }
    </script>
</div><?php /**PATH C:\xampp\htdocs\CollegeMarketplace\resources\views/partials/_navigationBar.blade.php ENDPATH**/ ?>