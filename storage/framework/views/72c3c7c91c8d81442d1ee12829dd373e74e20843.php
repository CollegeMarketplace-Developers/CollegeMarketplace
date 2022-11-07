
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
            <?php echo $__env->make('partials._carouselByCategory',['furnitureItems' => $furnitureItems, 'clothesItems'=>$clothesItems, "electronicsItems"=>$electronicsItems, 'kitchenItems' => $kitchenItems, 'schoolItems' =>$schoolItems, 'bookItems'=>$bookItems], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        
        
        <div class="listings-parent-container">
            <?php echo $__env->make('partials._componentDesignOne', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        

        
        <?php if(!empty($listingsNear)): ?> 
            <div class = "listings-parent-container">
                <?php echo $__env->make('partials._listingCarousel', ['listings' => $listingsNear, 'message' => 'Within A Mile', 'carouselClass'=>'my-slider','carouselControls' => 'controls', 'carouselP' =>'previous previous1', 'carouselN' => 'next next1'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        <?php else: ?> 
        <?php endif; ?>

        
        <div class="listings-parent-container">
            <?php echo $__env->make('partials._rentablesCarousel',
            ['rentables'=> $rentables, 'message' => 'For Rent' , 'carouselClass' => 'slider2',
            'carouselControls' => 'controls2', 'carouselP' =>' previous previous2', 'carouselN' => 'next next2'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        
        
        <div class = "listings-parent-container">
            <?php echo $__env->make('partials._cardGallary', ['listings' => $listings, 'heading'=>'Items Recently Added', 'displayTags' => true, 'displayMoreButton' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        
        <div class="listings-parent-container">
            <?php echo $__env->make('partials._subleaseCarousel',
            ['subleases'=> $subleases, 'message' => 'Places For Leasing' , 'carouselClass' => 'slider3',
            'carouselControls' => 'controls3', 'carouselP' =>' previous previous3', 'carouselN' => 'next next3'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </main>

    <script>
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