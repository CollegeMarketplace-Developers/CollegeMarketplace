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
            } else {
                // if adding a new value to a key value pair
                array_push($storedAtKey, $value);
                $nextMap->put($key, $storedAtKey);
            }
        } else {
            $nextMap->put($key, array($value));
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
                    <li><a href="<?php echo e(urlBuilder(toggleParam('distance', '0 - 0.5 Mi', $map), $base)); ?>">0 - 0.5 Mi</a></li>
                    <li><a href="<?php echo e(urlBuilder(toggleParam('distance', '0.5 - 1 Mi', $map), $base)); ?>">0.5 - 1 Mi</a></li>
                    <li><a href="<?php echo e(urlBuilder(toggleParam('distance', '1 - 1.5 Mi', $map), $base)); ?>">1 - 1.5 Mi</a></li>
                    <li><a href="<?php echo e(urlBuilder(toggleParam('distance', '1.5 - 2 Mi', $map), $base)); ?>">1.5 - 2 Mi</a></li>
                    <li><a href="<?php echo e(urlBuilder(toggleParam('distance', '> 2 Mi', $map), $base)); ?>"> > 2 Mi</a></li>
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
                                ?>
                                    <li><span><?php echo e($key); ?>: </span><?php echo e($val); ?><a href="<?php echo e($response); ?>"><i class='fa-solid fa-xmark'></i></a></li>
                                <?php
                            }
                        }
                  ?>
            </ul>
        </div>
        
        <div class = "search-results-container" >
            <?php echo $__env->make('partials._cardGallary',['listings'=>$listings, 'heading' => 'Results Showing: '. count($listings), 'displayTags' => true, 'displayMoreButton' => false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
    <script>
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