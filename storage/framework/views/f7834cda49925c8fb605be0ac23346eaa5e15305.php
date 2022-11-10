<?php foreach($attributes->onlyProps([ 'listing', 'rentable', 'sublease']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([ 'listing', 'rentable', 'sublease']); ?>
<?php foreach (array_filter(([ 'listing', 'rentable', 'sublease']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php foreach ((['currentUser']) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>
<div>
    
    <?php if($listing != null): ?>
        
        <div <?php echo e($attributes->merge(['class'=> 'slide single-post-cont'])); ?> data-aos="fade-right" data-aos-once="true">
            
            
            <div class="slide-img">
                
                <?php if($listing->status =='Available'): ?>
                    <div class="status green">
                    </div>
                <?php elseif($listing->status=='Pending'): ?>
                    <div class="status yellow">
                    </div>
                <?php else: ?>
                    <div class="status">
                    </div>
                <?php endif; ?>
                <a href="/listings/<?php echo e($listing->id); ?>">
                    <?php
                        $imgLinks = null;
                        if(isset($listing->image_uploads)){
                            //decode the json object
                            $imgLinks = json_decode($listing->image_uploads);
                            if(is_array($imgLinks)){
                                $imgLinks = $imgLinks[0];
                                //echo Storage::disk('s3')->url('listings/'.$imgLinks);
                                //echo $imgLinks;
                                //debug_to_console($imgLinks);
                            }
                        }
                        $site = 'https://picsum.photos/300/200?sig='. rand(0,100);
                    ?>
                    <?php
                        $hardLink=['/images/rotunda.jpg', '/images/old-cabell.jpg', '/images/cavalier-horse.jpg'];
                        $link = $hardLink[random_int(0, count($hardLink)-1)];
                    ?>
                    <img src=<?php echo e($listing->image_uploads ? Storage::disk('s3')->url($imgLinks) : $site); ?>  alt="image doesnt exist">
                </a>
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
            
            <div class = "listing-details">
                <div class="listing-details-top">
                    <h1>$<?php echo e($listing->price); ?></h1>
                    
                </div>
                <div class="listing-details-middle">
                    <a href="/listings/<?php echo e($listing->id); ?>"><?php echo e($listing->item_name); ?></a>
                </div>
                <div class="listing-details-bottom">
                    <div>
                        <p><?php echo e($listing->city); ?>, <?php echo e($listing->state); ?></p>
                        <p><?php echo e($listing->condition); ?></p>
                    </div>
                    <a class="type-sale" href="/listings/<?php echo e($listing->id); ?>">Buy</a>
                </div>
            </div>

            <a href="/listings/<?php echo e($listing->id); ?>" class="clickable-card"></a>
        </div>
    
    <?php elseif($rentable != null): ?>
        <div <?php echo e($attributes->merge(['class'=> 'slide single-post-cont '])); ?> data-aos="fade-right" data-aos-once="true">
            
            
            <div class="slide-img">
                    
                <?php if($rentable->status =='Available'): ?>
                    <div class="status green">
                    </div>
                <?php else: ?>
                    <div class="status">
                    </div>
                <?php endif; ?>
                <a href="/rentables/<?php echo e($rentable->id); ?>">
                    <?php
                    $imgLinks = null;
                        if(isset($rentable->image_uploads)){
                            //decode the json object
                            $imgLinks = json_decode($rentable->image_uploads);
                            if(is_array($imgLinks)){
                                $imgLinks = $imgLinks[0];
                            }
                        }
                        $site = 'https://picsum.photos/300/200?sig='. rand(0,100);
                    ?>
                    
                    <?php
                        $hardLink=['/images/rotunda.jpg', '/images/old-cabell.jpg', '/images/cavalier-horse.jpg'];
                        $link = $hardLink[random_int(0, count($hardLink)-1)];
                    ?>
                    <img src=<?php echo e($rentable->image_uploads ? Storage::disk('s3')->url($imgLinks) : $site); ?>  alt="image doesnt exist">
                </a>
                <?php if($currentUser != null and $currentUser->rentableFavorites != null and in_array($rentable->id, explode(", " , $currentUser->rentableFavorites))): ?>
                    <form action="/users/removefavorite" method="GET">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="type" value="rentable">
                        <input type="hidden" name="id" value="<?php echo e($rentable->id); ?>">
                        <button><i class="fa-solid fa-heart saved"></i></button>
                    </form>
                <?php else: ?>
                    <form action="/users/addfavorite" method="GET">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="type" value="rentable">
                        <input type="hidden" name="id" value="<?php echo e($rentable->id); ?>">
                        <button><i class="fa-solid fa-heart bouncy"></i></button>
                    </form>
                <?php endif; ?>
            </div>
            
            <div class = "listing-details">
                <div class="listing-details-top">
                    <h1>$<?php echo e($rentable->rental_charging); ?> / <?php echo e($rentable->rental_duration); ?></h1>
                    
                </div>
                <div class="listing-details-middle">
                    <a href="/rentables/<?php echo e($rentable->id); ?>"><?php echo e($rentable->rental_title); ?></a>
                </div>
                <div class="listing-details-bottom">
                    <div>
                        <p><?php echo e($rentable->city); ?>, <?php echo e($rentable->state); ?></p>
                        <p><?php echo e($rentable->condition); ?></p>
                    </div>
                    <a class="type-rent" href="/rentables/<?php echo e($rentable->id); ?>">Rent</a>
                </div>
            </div>

            <a href="/rentables/<?php echo e($rentable->id); ?>" class="clickable-card"></a>
        </div>
    <?php elseif($sublease != null): ?>
         <div <?php echo e($attributes->merge(['class'=> 'slide single-post-cont '])); ?> data-aos="fade-right" data-aos-once="true">
            
            
            <div class="slide-img">
                <?php if($sublease->status =='Available'): ?>
                    <div class="status green">
                    </div>
                <?php else: ?>
                    <div class="status">
                    </div>
                <?php endif; ?>
                <a href="/subleases/<?php echo e($sublease->id); ?>">
                    <?php
                    $imgLinks = null;
                        if(isset($sublease->image_uploads)){
                            //decode the json object
                            $imgLinks = json_decode($sublease->image_uploads);
                            if(is_array($imgLinks)){
                                $imgLinks = $imgLinks[0];
                            }
                        }
                        $site = 'https://picsum.photos/300/200?sig='. rand(0,100);
                    ?>
                    
                    <?php
                        $hardLink=['/images/rotunda.jpg', '/images/old-cabell.jpg', '/images/cavalier-horse.jpg'];
                        $link = $hardLink[random_int(0, count($hardLink)-1)];
                    ?>
                    <img src=<?php echo e($sublease->image_uploads ? Storage::disk('s3')->url($imgLinks) : $site); ?>  alt="image doesnt exist">
                </a>
                <?php if($currentUser != null and $currentUser->leaseFavorites != null and in_array($sublease->id, explode(", " , $currentUser->leaseFavorites))): ?>
                    <form action="/users/removefavorite" method="GET">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="type" value="leaseItem">
                        <input type="hidden" name="id" value="<?php echo e($sublease->id); ?>">
                        <button><i class="fa-solid fa-heart saved"></i></button>
                    </form>
                <?php else: ?>
                    <form action="/users/addfavorite" method="GET">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="type" value="leaseItem">
                        <input type="hidden" name="id" value="<?php echo e($sublease->id); ?>">
                        <button><i class="fa-solid fa-heart bouncy"></i></button>
                    </form>
                <?php endif; ?>
            </div>
            <div class = "listing-details">
                <div class="listing-details-top">
                    <h1>$<?php echo e($sublease->rent); ?> / Mo | <?php echo e($sublease->negotiable); ?></h1>
                </div>
                <div class="listing-details-middle">
                   <a href="/subleases/<?php echo e($sublease->id); ?>"><?php echo e($sublease->sublease_title); ?></a>
                </div>
                <div class="listing-details-bottom">
                    <div>
                        <p><?php echo e($sublease->city); ?>, <?php echo e($sublease->state); ?></p>
                        <p><?php echo e($sublease->location); ?></p>
                    </div>
                    <a class="type-lease" href="/subleases/<?php echo e($sublease->id); ?>">Lease</a>
                </div>
            </div>

            <a href="/subleases/<?php echo e($sublease->id); ?>" class="clickable-card"></a>
        </div>
    <?php endif; ?>
</div>

<?php /**PATH C:\xampp\htdocs\CollegeMarketplace\resources\views/components/carousel-card.blade.php ENDPATH**/ ?>