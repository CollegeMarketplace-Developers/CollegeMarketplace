
<?php $controller = app('App\Http\Controllers\Controller'); ?>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.layout','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    
    <?php echo $__env->make('partials._hero', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main class = "main-listings-container">

        
        <div class = "listings-parent-container">
            <?php echo $__env->make('partials._carouselByCategory',['furnitureItems' => $furnitureItems, 'clothesItems'=>$clothesItems, "electronicsItems"=>$electronicsItems, 'kitchenItems' => $kitchenItems, 'schoolItems' =>$schoolItems, 'bookItems'=>$bookItems, 'currentUser'=>$user], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        
        
        <div class="listings-parent-container">
            <?php echo $__env->make('partials._componentDesignOne', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        
        <?php if($user != null && $likedItems != null && count($likedItems) > 0): ?>
            <div class="listings-parent-container">
                <?php echo $__env->make('partials._mixedCarousel', ['listings' => $likedItems, 'message' => 'Liked Items', 'carouselClass'=>'liked-items-slider','carouselControls' => 'liked-items-controls', 'carouselP' =>'previous liked-items-previous', 'carouselN' => 'next liked-items-next',
                'currentUser'=>$user, 'extraLink' => '/shop/all?type=all'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        <?php endif; ?>

        <?php if($recentlyViewed != null && count($recentlyViewed) > 0): ?>
            <div class="listings-parent-container">

                <?php echo $__env->make('partials._mixedCarousel', ['listings' => $recentlyViewed, 'message' => 'Recently Viewed Items', 'carouselClass'=>'recently-viewed-slider','carouselControls' => 'recently-viewed-controls', 'carouselP' =>'previous recently-viewed-previous', 'carouselN' => 'next recently-viewed-next',
                'currentUser'=>$user, 'extraLink'=> '/shop/all?type=all'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        <?php endif; ?>
        

        
        

        
        <div class="listings-parent-container">
            <?php echo $__env->make('partials._rentablesCarousel',
            ['rentables'=> $rentables, 'message' => 'For Rent' , 'carouselClass' => 'slider2',
            'carouselControls' => 'controls2', 'carouselP' =>' previous previous2', 'carouselN' => 'next next2', 'currentUser'=>$user], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        
        
        <div class = "listings-parent-container">
            <?php echo $__env->make('partials._cardGallary', ['listings' => $listings, 'heading'=>'Items Recently Added', 'displayTags' => true, 'displayMoreButton' => true,
            'currentUser' => $user], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        
        <div class="listings-parent-container">
            <?php echo $__env->make('partials._subleaseCarousel',
            ['subleases'=> $subleases, 'message' => 'Places For Leasing' , 'carouselClass' => 'slider3',
            'carouselControls' => 'controls3', 'carouselP' =>' previous previous3', 'carouselN' => 'next next3', 'currentUser' => $user], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </main>

    <script>

        var likedItems = <?php echo json_encode(array_values($likedItems)); ?>;
        var recentlyViewed = <?php echo json_encode(array_values($recentlyViewed)); ?>;
        if(likedItems.length>0){
            tns({
                container: ".liked-items-slider",
                "slideBy":1,
                "speed":400,
                "nav":false,
                autoplayButton: false,
                autoplay: true,
                autoplayText:["",""],
                controlsContainer:"#liked-items-controls",
                responsive:{
                    1500:{
                        items: 5,
                        gutter: 5
                    },
                    1200:{
                        items: 4,
                        gutter: 10
                    },
                    // 1100:{
                    //     items: 3,
                    //     gutter: 15
                    // },
                    1024:{
                        items: 3,
                        gutter: 15
                    },
                    700:{
                        items: 2,
                        gutter: 20
                    },
                    480:{
                        items: 1
                    }
                }
            })
        }

        if(recentlyViewed.length>0){
            tns({
                container: ".recently-viewed-slider",
                "slideBy":1,
                "speed":400,
                "nav":false,
                autoplayButton: false,
                autoplay: true,
                autoplayText:["",""],
                controlsContainer:"#recently-viewed-controls",
                responsive:{
                    1500:{
                        items: 5,
                        gutter: 5
                    },
                    1200:{
                        items: 4,
                        gutter: 10
                    },
                    // 1100:{
                    //     items: 3,
                    //     gutter: 15
                    // },
                    1024:{
                        items: 3,
                        gutter: 15
                    },
                    700:{
                        items: 2,
                        gutter: 20
                    },
                    480:{
                        items: 1
                    }
                }
            })
        }


        if("<?php echo e($user == null); ?>") {
            getLocation();
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition,showError,options);
            } else { 
                console.log("location not supported")
            }
        }

        function showPosition(position) {
            //console.log(position.coords.latitude+" "+position.coords.longitude);
            getListings(position.coords.latitude,position.coords.longitude);
        }

        function showError(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    console.log("User denied the request for Geolocation.");
                break;
                case error.POSITION_UNAVAILABLE:
                    console.log("Location information is unavailable.");
                break;
                case error.TIMEOUT:
                    console.log( "The request to get user location timed out.");
                break;
                case error.UNKNOWN_ERROR:
                    console.log( "An unknown error occurred.");
                break;
            }
        }

        var options = {
            enableHighAccuracy: true,
            timeout: 1000,
            maximumAge: 0
        };

        /*$(document).ready(function(){
                $(window).on("load",function(){
                    getLocation();
                });
        });*/

        //function to get proximate listings after getting location 
        function getListings(latitude,longitude){
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            $.ajax({
                type:'GET',
                url: '/item?latitude='+latitude+'&longitude='+longitude,
                data: 'JSON',
                cache: false, //look into caching later
                success:function(data) {
                    console.log("Listings near the user: ", data);
                    // console.log(data);
                    //add your success handling here
                },
                error: function (data, textStatus, errorThrown) {
                    console.log("failed");
                    //add your failed handling here
                },
            });
        }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\CollegeMarketplace\resources\views/main/index.blade.php ENDPATH**/ ?>