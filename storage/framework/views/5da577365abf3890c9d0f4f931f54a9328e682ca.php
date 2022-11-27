<?php
    use App\Libraries\HashMap;
    $map = new HashMap("String", "Array");
    $base = URL::to('/shop/all');

    function deconstructUrl($input, $map){
        $data = $input;
        foreach ( $data as $key => $value) {
            $value = explode(",", $value);
            $map -> put($key, $value);
        }
    }

    deconstructUrl(Request::except('_token'), $map);

    function urlBuilder($futureMap, $base){
        $base = $base . "?";
        $futureMap->forEach(
            function($key, $value) use(&$base, &$futureMap) {
                if($key=="page"){
                    $futureMap->remove($key);
                }else{
                    $base = $base . $key . "=" . implode(",",$value) . "&";
                }
            }
        );
        return substr($base, 0, -1);
    }

    function toggleParam($key, $value, $map){
        $nextMap = clone $map;

        //if we are toggling the type, type always needs to have a default of all, unless specified
        //the type=all is replaced by the specified type
        if($nextMap->contains($key)) {

            //this is the array that is that stored at the respective key
            $storedAtKey = $nextMap->get($key);
            if($key == "type"){
                $nextMap->remove($key);
                $nextMap->put($key, array($value));
                return $nextMap;
            }

            if(in_array($value, $storedAtKey)) {
                // basically deleting key-> value pair if present
                if (($index = array_search($value, $storedAtKey)) !== NULL) {
                    unset($storedAtKey[$index]);
                    $nextMap->put($key, $storedAtKey);
                }
                if(count($storedAtKey) == 0) {
                    $nextMap->remove($key);
                }
                if($key == "distance"){
                    $nextMap->remove('lat');
                    $nextMap->remove('lng');
                }
            } else {
                if($key == 'distance'){
                    unset($storedAtKey[0]);
                    array_push($storedAtKey, $value);
                    $nextMap->put($key, $storedAtKey);
                }else{
                    // if adding a new value to a key value pair
                    array_push($storedAtKey, $value);
                    $nextMap->put($key, $storedAtKey);
                }
            }
        } else {
            $nextMap->put($key, array($value));
            if($key == 'distance'){
                $nextMap->put('lat', !auth()->guest() && auth()->user()->latitude != null ? array(auth()->user()->latitude) : array('null'));
                $nextMap->put('lng', !auth()->guest() && auth()->user()->longitude != null ? array(auth()->user()->longitude) : array('null'));
            }
        }
        return $nextMap;
    }
?>

<link rel="stylesheet" types ="text/css" href="/css/search.css" />
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.layout','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div style="position: relative; overflow:hidden; padding-top:50px;"   >
        <input type="checkbox" id="show-filter" class="show-filter panel">
        
        <div class = "side-filter-container">
            <label for="show-filter">
                
                <i class="fa-solid fa-filter sidebar-toggle"></i>
            </label> 
            
            <ul class="filter-list">
                
                <li>
                    <input type="checkbox" id="type">
                    <label for="type" style="position: relative;">Type <span class="down-arrow"></span> </label>
                    <ul> 
                        <li><a id= "all" href="<?php echo e(urlBuilder(toggleParam('type', 'all', $map), $base)); ?>">Show All Items</a></li>
                        <li><a id = "listing" href="<?php echo e(urlBuilder(toggleParam('type', 'listing', $map), $base)); ?>">Listing</a></li>
                        <li><a id="rentable" href="<?php echo e(urlBuilder(toggleParam('type', 'rentable', $map), $base)); ?>">Rentable</a></li>
                        <li><a id="lease" href="<?php echo e(urlBuilder(toggleParam('type', 'lease', $map), $base)); ?>">Leaseable</a></li>
                    </ul>
                </li>
                
                
                <li>
                    <input type="checkbox" id="cat">
                    <label for="cat" style="position: relative;">Categories <span class="down-arrow"></span> </label>
                    <ul> 
                        <li><a href="<?php echo e(urlBuilder(toggleParam('category', 'furniture', $map), $base)); ?>">Furniture</a></li>
                        <li><a href="<?php echo e(urlBuilder(toggleParam('category', 'clothes', $map), $base)); ?>">Clothes</a></li>
                        <li><a href="<?php echo e(urlBuilder(toggleParam('category', 'electronics', $map), $base)); ?>">Electronics</a></li>
                        <li><a href="<?php echo e(urlBuilder(toggleParam('category', 'kitchen', $map), $base)); ?>">Kitchen</a></li>
                        <li><a href="<?php echo e(urlBuilder(toggleParam('category', 'school accessories', $map), $base)); ?>">School Accessories</a></li>
                        <li><a href="<?php echo e(urlBuilder(toggleParam('category', 'books', $map), $base)); ?>">Books</a></li>
                    </ul>
                </li>

                
                <li>
                    <input type="checkbox" id="cond">
                    <label for="cond" style="position: relative;">Condition <span class="down-arrow"></span> </label>
                    <ul> 
                        <li><a href="<?php echo e(urlBuilder(toggleParam('condition', 'new', $map), $base)); ?>">New</a></li>
                        <li><a href="<?php echo e(urlBuilder(toggleParam('condition', 'good', $map), $base)); ?>">Good</a></li>
                        <li><a href="<?php echo e(urlBuilder(toggleParam('condition', 'slightly used', $map), $base)); ?>">Slightly Used</a></li>
                        <li><a href="<?php echo e(urlBuilder(toggleParam('condition', 'used normal wear', $map), $base)); ?>">Used Normal Wear</a></li>
                    </ul>
                </li>
                
                
                <li>
                    <input type="checkbox" id="cost">
                    <label for="cost" style="position: relative;">Price <span class="down-arrow"></span> </label>

                    <ul>
                    <li><a href="<?php echo e(urlBuilder(toggleParam('negotiable', 'negotiable', $map), $base)); ?>">Negotiable</a></li>
                    <li><a href="<?php echo e(urlBuilder(toggleParam('negotiable', 'fixed', $map), $base)); ?>">Fixed</a></li>
                    <li><a href="<?php echo e(urlBuilder(toggleParam('negotiable', 'free', $map), $base)); ?>">Free</a></li>
                    </ul>
                </li>

                <li>
                    <label for="" class="price-label">
                        <div>
                            <input type="number" min="0.00" name = "minprice" max="10000.00" step="0.01" placeholder="Min Price" id="minprice" value="<?php echo e(old('minprice', null)); ?>"/>
                            <h5>To</h5>
                            <input type="number" min="0.00" name = "maxprice" max="10000.00" step="0.01" placeholder="Max Price" id="maxprice" value="<?php echo e(old('maxprice', null)); ?>" />
                            <input type="submit" value="GO" onclick="submitPriceRange()"/>    
                        </div>
                        <p class="price-error-message" id="error-msg">Please enter min or max</p>
                    </label>
                </li>
                
                <li>
                    <input type="checkbox" id="dist">
                    <label for="dist" style="position: relative;">Distance <span class="down-arrow"></span> </label>

                    <ul>
                    <li><a id = "distance-half1" href="<?php echo e(urlBuilder(toggleParam('distance', '0.5 Mi', $map), $base)); ?>">< 0.5 Miles</a></li>
                    <li><a id = "distance-half2"href="<?php echo e(urlBuilder(toggleParam('distance', '1 Mi', $map), $base)); ?>">< 1 Miles</a></li>
                    <li><a id = "distance-half3"href="<?php echo e(urlBuilder(toggleParam('distance', '1.5 Mi', $map), $base)); ?>">< 1.5 Miles</a></li>
                    <li><a id = "distance-half4"href="<?php echo e(urlBuilder(toggleParam('distance', '2 Mi', $map), $base)); ?>">< 2 Miles</a></li>
                    <li><a id = "distance-half5"href="<?php echo e(urlBuilder(toggleParam('distance', '> 2 Mi', $map), $base)); ?>"> > 2 Miles</a></li>
                    </ul>
                </li>

                 
                <li>
                    <input type="checkbox" id="util">
                    <label for="util" style="position: relative;">Utilities <span class="down-arrow"></span> </label>

                    <ul>
                    <li><a href="<?php echo e(urlBuilder(toggleParam('utilities', 'electric', $map), $base)); ?>">Electric</a></li>
                    <li><a href="<?php echo e(urlBuilder(toggleParam('utilities', 'gas', $map), $base)); ?>">Gas</a></li>
                    <li><a href="<?php echo e(urlBuilder(toggleParam('utilities', 'water', $map), $base)); ?>">Water</a></li>
                    <li><a href="<?php echo e(urlBuilder(toggleParam('utilities', 'trash', $map), $base)); ?>">Trash</a></li>
                    <li><a href="<?php echo e(urlBuilder(toggleParam('utilities', 'internet', $map), $base)); ?>">Internet</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="filters-applied-container">
            <ul class="filters-applied-list" id="filters-ul">
                <?php
                    $data = Request::except('_token');
                    foreach ( $data as $key => $values) {
                        $value = explode(",", $values);
                        foreach($value as $val){
                            $response = urlBuilder(toggleParam($key, $val, $map), $base);

                            if($key == 'distance'){
                                $tempMap = new HashMap("String", "Array");
                                foreach ( $data as $insideKey => $insideValue) {
                                    $insideValue = explode(",", $insideValue);
                                    $tempMap -> put($insideKey, $insideValue);
                                }

                                $tempMap = toggleParam('distance', $data['distance'], $tempMap);
                                
                                $response = urlBuilder($tempMap, $base);
                            }
                            if(($key == "lat" || $val== "null" ) ||
                                $key == "lng" || $val == "null" ){
                                
                                //need to say that can't apply nearby filter because user location is not found
                                continue;
                            }

                            ?>
                                <li><span><?php echo e($key); ?>: </span><?php echo e($val); ?><a href="<?php echo e($response); ?>"><i class='fa-solid fa-xmark'></i></a></li>
                            <?php
                        }
                    }
                ?>
            </ul>
        </div>
        
        <div class = "search-results-container" >
            <?php echo $__env->make('partials._cardGallary',['listings'=>$listings, 'heading' => 'Results Showing: '. count($listings), 'displayTags' => true, 'displayMoreButton' => false, 'currentUser' => $user], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
    <script>

        var userLat = null;
        var userLng = null;
        navigator.permissions.query({ name: 'geolocation' }).then((permissionStatus) => {
            permissionStatus.onchange = () => {
                console.log(permissionStatus.state);
                updateCurrentUrl();
            };
        });

        updateCurrentUrl();
        function updateCurrentUrl(){
             //CASE 1:
            //  if the user is not logged in
            if("<?php echo e(auth()->guest()); ?>") {
                //CASE 1: 
                //  try to get the user's current location
                //  if location feature is allowed, will update the url and go to the link with the updated lat/lng
                if (navigator.geolocation) { 
                    navigator.geolocation.getCurrentPosition(
                        (position)=>{
                            userLat = position.coords.latitude;
                            userLng = position.coords.longitude;
                            console.log('retrieved new coordinates');
                            replaceParameters();
                            goToUpdatedUrl(getUpdatedUrl(position.coords.latitude, position.coords.longitude));
                        },((error)=>{
                            switch(error.code) {
                                case error.PERMISSION_DENIED:
                                    console.log("User denied the request for Geolocation.");
                                    goToUpdatedUrl(getUpdatedUrl('null', 'null'));
                                break;
                                case error.POSITION_UNAVAILABLE:
                                    console.log("Location information is unavailable.");
                                    goToUpdatedUrl(getUpdatedUrl('null', 'null'));
                                break;
                                case error.TIMEOUT:
                                    console.log( "The request to get user location timed out.");
                                    goToUpdatedUrl(getUpdatedUrl('null', 'null'));
                                break;
                                case error.UNKNOWN_ERROR:
                                    console.log( "An unknown error occurred.");
                                    goToUpdatedUrl(getUpdatedUrl('null', 'null'));
                                break;
                            }
                        }),{
                            enableHighAccuracy: true,
                            timeout: 1000,
                            maximumAge: 0
                    });
                //CASE 2:
                //  other wise the nearby items are just regular items 
                //  the user is not logged in, so we can't check their location on file, also not given permission to retrieve user's location
                }else{
                    //for the initial page load when location services are toggled off
                    goToUpdatedUrl('null', 'null');
                }                
            // CASE 2:
            //  If the user is logged in
            }else if("<?php echo e(!auth()->guest()); ?>"){
                var currentUser = <?php echo json_encode(auth()->user()); ?>;

                //CASE 1: 
                //  if the user is logged in and has lat and long in the db
                //  the links in the side filter panel will be updatd accordingly, nothing to do here
                if(currentUser.latitude != null && currentUser.longitude != null){
                    console.log('first branch' + getUpdatedUrl(currentUser.latitude, currentUser.longitude));
                    goToUpdatedUrl(getUpdatedUrl(currentUser.latitude, currentUser.longitude));
           
                //CASE 2:
                //  if the user is logged in and there is no lat/long in db and we are allowed to get current location
                //  the users location is updated in the db via a jax request in the navbar script area
                }else if (currentUser.latitude == null && currentUser.longitude == null){ 
                    console.log('second branch');

                    if (navigator.geolocation) { 
                        navigator.geolocation.getCurrentPosition(
                            (position)=>{
                                userLat = position.coords.latitude;
                                userLng = position.coords.longitude;
                                goToUpdatedUrl(getUpdatedUrl(position.coords.latitude, position.coords.longitude));
                            },((error)=>{
                                switch(error.code) {
                                    case error.PERMISSION_DENIED:
                                        console.log("User denied the request for Geolocation.");
                                        goToUpdatedUrl(getUpdatedUrl('null', 'null'));
                                    break;
                                    case error.POSITION_UNAVAILABLE:
                                        console.log("Location information is unavailable.");
                                        goToUpdatedUrl(getUpdatedUrl('null', 'null'));
                                    break;
                                    case error.TIMEOUT:
                                        console.log( "The request to get user location timed out.");
                                        goToUpdatedUrl(getUpdatedUrl('null', 'null'));
                                    break;
                                    case error.UNKNOWN_ERROR:
                                        console.log( "An unknown error occurred.");
                                        goToUpdatedUrl(getUpdatedUrl('null', 'null'));
                                    break;
                                }
                            }),{
                                enableHighAccuracy: true,
                                timeout: 1000,
                                maximumAge: 0
                        });
                    }
                    
                //CASE 3:
                //  if the user is logged in and there is not lat/long in the db.
                //  we are also not allowed to extract the users location.
                }else{
                    console.log('third branch' + getUpdatedUrl(null, null));
                    goToUpdatedUrl(getUpdatedUrl('null', 'null'));    
                }
            }
        }

        function getUpdatedUrl(lat, lng){

            var urlString = window.location.href;
            let paramString = urlString.split('?')[1];
            let queryString = new URLSearchParams(paramString);
            var urlBase = "/shop/all";

            urlBase = urlBase + "?";
            var goToNewUrl = false;

            for (let pair of queryString.entries()) {
                // console.log("Key is: " + pair[0] + " Value is: " + pair[1]);

                if(pair[0] == 'page'){
                    continue;
                }
                if(pair[0] == 'lat'){
                     console.log(pair[1] , lat);
                    if(pair[1] != lat){goToNewUrl = true;}
                    urlBase = urlBase + pair[0]+"="+lat+"&";
                }else if(pair[0] == 'lng'){
                    if(pair[1] != lng){goToNewUrl = true;}
                    urlBase = urlBase + pair[0]+"="+lng+"&";
                }else{
                    urlBase = urlBase + pair[0]+"="+pair[1]+"&";
                }
            }
            
            urlBase = urlBase.substring(0, urlBase.length-1);
            // console.log(goToNewUrl);
            return [goToNewUrl, urlBase];
        }

        function goToUpdatedUrl(input){
            if(input[0]){
                window.location.href = input[1];
            }
        }

        function replaceParameters(){

            document.getElementById('distance-half1').href = replaceSingleParameter(document.getElementById('distance-half1').href);
            document.getElementById('distance-half2').href = replaceSingleParameter(document.getElementById('distance-half2').href);
            document.getElementById('distance-half3').href = replaceSingleParameter(document.getElementById('distance-half3').href);
            document.getElementById('distance-half4').href = replaceSingleParameter(document.getElementById('distance-half4').href);
            document.getElementById('distance-half5').href = replaceSingleParameter(document.getElementById('distance-half5').href);
            
            console.log(document.getElementById('distance-half1').href);
            console.log(document.getElementById('distance-half2').href);
            console.log(document.getElementById('distance-half3').href);
            console.log(document.getElementById('distance-half4').href);
            console.log(document.getElementById('distance-half5').href);
        }

        function replaceSingleParameter(inputUrl){
            let paramString = inputUrl.split('?')[1];
            let queryString = new URLSearchParams(paramString);
            var urlBase = "/shop/all";

            urlBase = urlBase + "?";
            for (let pair of queryString.entries()) {
                if(pair[0] == 'page'){
                    continue;
                }
                if(pair[0] == 'lat'){
                    urlBase = urlBase + pair[0]+"="+userLat+"&";
                }else if(pair[0] == 'lng'){
                    urlBase = urlBase + pair[0]+"="+userLng+"&";
                }else{
                    urlBase = urlBase + pair[0]+"="+pair[1]+"&";
                }
            }
            urlBase = urlBase.substring(0, urlBase.length-1);
            return urlBase;
        }
        
        function isEmpty(val){
            return (val === undefined || val == null || val.length <= 0) ? true : false;
        }

        function submitPriceRange(){
            //creating a map from the current url string including parameters
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            entries = urlParams.entries();
            const myMap = new Map();
            for(const entry of entries) {
                let key = entry[0];
                let values = entry[1].split(",");
                let set = new Set();
                for(const value of values){
                    set.add(value);
                }
                myMap.set(key, set);
            }

            var min = document.getElementById('minprice').value;
            var max = document.getElementById('maxprice').value;
            console.log(min, max);
            if(isEmpty(min) && isEmpty(max)){
                document.getElementById('error-msg').style.display = 'flex';
                if(myMap.has('minprice')){myMap.delete('minprice');}
                if(myMap.has('maxprice')){myMap.delete('maxprice');}
                // console.log(myMap); 
                // return;/
            }else{
                document.getElementById('error-msg').style.display = 'none';
            }
            
            //logic to add minprice
            if(myMap.has('minprice')){
                myMap.delete('minprice');
            }
            if(!isEmpty(min))
            {
                myMap.set('minprice', new Set([min]));
            }

            // logic to add maxprice
            if(myMap.has('maxprice')){
                myMap.delete('maxprice');
            }
            if(!isEmpty(max))
            {
                myMap.set('maxprice', new Set([max]));
            }

            if(myMap.has('page')){myMap.delete('page')};
            var base = "<?php echo e($base); ?>" + "?";
            for(const x of myMap.entries()){
                let key =x[0];
                let values = Array.from(x[1]).join(',');
                base = base + key + "=" + values + "&";
            }
            base = base.slice(0,-1);
            location.assign(base);
        }

    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?> <?php /**PATH C:\xampp\htdocs\CollegeMarketplace\resources\views/main/search.blade.php ENDPATH**/ ?>