<?php foreach($attributes->onlyProps(['listing', 'rentable', 'sublease']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['listing', 'rentable', 'sublease']); ?>
<?php foreach (array_filter((['listing', 'rentable', 'sublease']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div>
    
    <?php if($listing != null): ?>
        <div <?php echo e($attributes->merge(['class'=> 'slide single-post-cont'])); ?> data-aos="fade-right">
            
            
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
            </div>
            
            
            <div class = "listing-details">
                <div class="listing-details-top">
                    <h1>$<?php echo e($listing->price); ?></h1>
                    <i class="fa-solid fa-heart"></i>
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
        </div>
    
    <?php elseif($rentable != null): ?>
        <div <?php echo e($attributes->merge(['class'=> 'slide single-post-cont '])); ?> data-aos="fade-right">
            
            
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
            </div>
            
            <div class = "listing-details">
                <div class="listing-details-top">
                    <h1>$<?php echo e($rentable->rental_charging); ?> / <?php echo e($rentable->rental_duration); ?></h1>
                    <i class="fa-solid fa-heart"></i>
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
        </div>
    <?php else: ?>
         <div <?php echo e($attributes->merge(['class'=> 'slide single-post-cont '])); ?> data-aos="fade-right">
            
            
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
            </div>
            <div class = "listing-details">
                <div class="listing-details-top">
                    <h1>$<?php echo e($sublease->rent); ?> / Mo | <?php echo e($sublease->negotiable); ?></h1>
                    <i class="fa-solid fa-heart"></i>
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
        </div>
    <?php endif; ?>
</div><?php /**PATH C:\xampp\htdocs\CollegeMarketplace\resources\views/components/carousel-card.blade.php ENDPATH**/ ?>