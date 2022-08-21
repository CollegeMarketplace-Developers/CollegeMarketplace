




<?php $listingController = app('App\Http\Controllers\ListingController'); ?>
<link rel="stylesheet" type="text/css" href="/css/listing.css">

<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.layout','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <section class = "product-details-container">
        <div class = "card-wrapper-selected">

            
            <div class="back-button">
                <a href="javascript:history.back()" class="button1 b-button">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
            </div> 

            
            <div class = "card-selected">
                <div class="selected-row">
                    <!-- card left -->
                    <div class = "product-imgs">
                        <div class = "img-display">
                            <?php if($listing->status =='Available'): ?>
                                <div class="stat-container">
                                    <div class="stat green">
                                    </div>
                                </div>
                            <?php elseif($listing->status=='Pending'): ?>
                                <div class="stat-container">
                                    <div class="stat yellow">
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="stat-container">
                                    <div class="stat">
                                    </div>
                                </div>
                            <?php endif; ?> 
                            <?php
                                if(isset($listing->image_uploads)){
                                    //decode the json object
                                    $imgLinks = json_decode($listing->image_uploads);
                                    $titleImage = null;
                                    if(is_array($imgLinks)){
                                        $titleImage = $imgLinks[0];
                                    }
                                }
                            ?>
                            <img src=<?php echo e($listing->image_uploads ? Storage::disk('s3')->url($titleImage) : asset('/images/rotunda.jpg')); ?> id = "expandedImg" alt="image doesnt exist">
                        </div>
                        <div class = "img-showcase">
                            <?php if(is_array(json_decode($listing->image_uploads))): ?>
                                <?php $__currentLoopData = json_decode($listing->image_uploads); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <img src=<?php echo e($listing->image_uploads ? Storage::disk('s3')->url($link) : asset('/images/rotunda.jpg')); ?> alt = "shoe image" onclick="myFunction(this);">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <?php
                                    $site = 'https://picsum.photos/300/200?sig='. rand(0,100);
                                ?>
                                <img src="<?php echo e($site); ?>" alt="" onclick="myFunction(this);">
                                <img src="<?php echo e($site); ?>" alt="" onclick="myFunction(this);">
                                <img src="<?php echo e($site); ?>" alt="" onclick="myFunction(this);"> 
                                <img src="<?php echo e($site); ?>" alt="" onclick="myFunction(this);">
                                <img src="<?php echo e($site); ?>" alt="" onclick="myFunction(this);">
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- card right -->
                    <div class = "product-content">
                        <div class="product-details">
                            <div class="price-favorite">
                                <h1>$<?php echo e($listing->price); ?></h1>
                                    <?php if($currentUser != null and $currentUser->favorites != null and in_array($listing->id, explode(", " , $currentUser->favorites))): ?>
                                        <form action="/users/removefavorite" method="GET">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="type" value="listing">
                                            <input type="hidden" name="id" value="<?php echo e($listing->id); ?>">
                                            <button><i class="fa-solid fa-heart saved"></i></button>
                                        </form>
                                    <?php else: ?>
                                        <form action="/users/addfavorite" method="GET">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="type" value="listing">
                                            <input type="hidden" name="id" value="<?php echo e($listing->id); ?>">
                                            <button><i class="fa-solid fa-heart bouncy"></i></button>
                                        </form>
                                    <?php endif; ?>  
                            </div>
                            <div class="product-header">
                                <h1><?php echo e($listing->item_name); ?></h1>
                            </div>
                            <div class="product-extra">
                                <div>
                                    <p>Price:</p> 
                                    <span><?php echo e($listing->negotiable); ?></span>
                                </div>
                                <div>
                                    <p>Condition:</p>
                                    <span><?php echo e($listing->condition); ?></span>
                                </div>
                                <?php
                                    $listingController::updateViewCount($listing);
                                ?>
                                <p><i class="fa-solid fa-eye"></i><span><?php echo e($listing->view_count); ?></span></p>
                                <p><i class="fa-solid fa-location-dot"></i><span><?php echo e($listing->city); ?>, <?php echo e($listing->state); ?></span></p>
                            </div>
                            <div class="product-category">
                                <?php
                                    $categories = explode(", ", $listing->category);
                                    $date = $listing->created_at ->format('Y-m-d');
                                ?>
                                <div class="categories-container">
                                    <p>Categories:</p>
                                    <div class="categories">
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="/shop/all?type=all&category=<?php echo e($category); ?>"><?php echo e($category); ?></a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                <div>
                                    <p>Date Posted:</p>
                                    <span><?php echo e($date); ?></span>
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
                            
                            
                            
                            
                            <?php if($currentUser != null and $listing->user_id == $currentUser->id): ?>
                                <form method="POST" action="/listings/<?php echo e($listing->id); ?>/update">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <select name="status" id="status" style = " font-size: 17px; text-align:center;" onchange="this.form.submit()">
                                        <option style = "text-align:center;">Status</option>
                                        <option style = "text-align:center;" value="Available">Available</option>
                                        <option style = "text-align:center;" value="Pending">Pending</option>
                                        <option style = "text-align:center;" value="Sold">Sold</option>  
                                    </select>
                                </form>
                                
                            
                                <form class = "editForm" action="/listings/<?php echo e($listing->id); ?>/edit" method = "GET">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="id" value="<?php echo e($listing->id); ?>">
                                    <button><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                </form>

                                <span id="delete-modal-trigger">
                                    <i class="fa fa-trash" ></i>
                                </span>
                            <?php endif; ?>
                            <form class="shareForm">
                                <button id = 'share' onclick = "toggleText()" type = "button"><i class="fa fa-share-alt"></i>
                                </button>
                            </form> 
                        </div>
                        <h1>Description</h1>
                        <p><?php echo e($listing->description); ?></p>
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
                            <?php
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
                            ?>

                            <?php if($currentUser != null && $currentUser->id == $ownerID): ?>
                                
                                <a href="/all/<?php echo e($type); ?>/<?php echo e($itemID); ?>/<?php echo e($ownerID); ?>/<?php echo e($from); ?>/messages">
                                    <p>My Messages</p>
                                </a>
                            <?php else: ?>
                                
                                <a href="/all/<?php echo e($type); ?>/<?php echo e($itemID); ?>/<?php echo e($ownerID); ?>/<?php echo e($from); ?>/messages">
                                    <p>Chat with Seller</p>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="map-container-mobile" id="map-container-mobile">
                    
                </div>
                <div>
                    
                </div>
            </div>
        </div>
        <div class="modal" id="delete-modal">
            <div class="modal-content">
                <div class="sad-dog-container">
                    <img src="<?php echo e(asset('/images/sad-dog.png')); ?>" alt="">
                </div>
                <span class="close">&times;</span>
                <h1>Delete Listing</h1>
                <p>Are you sure you want to delete this listing?</p>

                <div class="clearfix">
                    <input type="button" class="button1" class="cancelbtn" id="cancelbtn" value="Cancel" />
                    <form method="POST" action="/listings/<?php echo e($listing->id); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <input type="submit" class="deletebtn button1" value="Delete"/>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <section class = "listings-parent-container">
         <?php echo $__env->make('partials._listingCarousel', ['listings' => $listings, 'message' => 'Related Items', 'carouselClass'=>'my-slider','carouselControls' => 'controls', 'carouselP' =>'previous previous1', 'carouselN' => 'next next1'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>    

    
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
            var listingLat = "<?php echo e($listing->latitude); ?>";
            var listingLong = "<?php echo e($listing->longitude); ?>";
            geocoder = new google.maps.Geocoder();
            var latlng = new google.maps.LatLng(-34.397, 150.644);
            var mapOptions = {
                zoom: 15,
                center: latlng
            }
            mapTwo = new google.maps.Map(document.getElementById('map-container'), mapOptions);
                console.log(listingLat, listingLong);
            if(!isEmpty("<?php echo e($listing->street); ?>")  && !isEmpty("<?php echo e($listing->state); ?>")) {
                console.log('top if');
                var address = "<?php echo e($listing->street." ".$listing->city); ?>";
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
                console.log("<?php echo e($listing->latitude); ?>", "<?php echo e($listing->longitude); ?>");
                var latlng = new google.maps.LatLng("<?php echo e($listing->latitude); ?>", "<?php echo e($listing->longitude); ?>");
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
        let address = ['<?php echo e($listing->street); ?>', '<?php echo e($listing->city); ?>', '<?php echo e($listing->state); ?>', '<?php echo e($listing->postcode); ?>', '<?php echo e($listing->country); ?>'];
        
        console.log(getGoogleMapsImage(address));
        function myFunction(imgs) {
            var expandImg = document.getElementById("expandedImg");
            expandImg.src = imgs.src;
        }
        var listing_id = "<?php echo e($listing->id); ?>"
        var listingOwner = "<?php echo e($listing->user_id); ?>";
        var userLoggedIn = "<?php echo e($currentUser ? $currentUser->id : -1); ?>";
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\CollegeMarketplace\resources\views/listings/show.blade.php ENDPATH**/ ?>