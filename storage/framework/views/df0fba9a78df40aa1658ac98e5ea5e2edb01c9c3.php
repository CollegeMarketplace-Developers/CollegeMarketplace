<?php foreach($attributes->onlyProps(['listing', 'displayTags']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['listing', 'displayTags']); ?>
<?php foreach (array_filter((['listing', 'displayTags']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<li class="cards_item" data-aos="zoom-in" data-aos-once="true">
    <div class="card"> 
        <div class="card_image">
            <?php if($listing instanceof \App\Models\Listing): ?>
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
                <div class="card_type sale">
                    <p>Buy</p>
                </div>

                <div class="card_favorite">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <a href="/listings/<?php echo e($listing->id); ?>">
                    <?php
                    $imgLinks = null;
                        if(isset($listing->image_uploads)){
                            $imgLinks = json_decode($listing->image_uploads);
                            if(is_array($imgLinks)){
                                $imgLinks = $imgLinks[0];
                                
                            }
                        }
                        $site = 'https://picsum.photos/300/200?sig='. rand(0,100);
                    ?>
                    <img src=<?php echo e($listing->image_uploads ? Storage::disk('s3')->url($imgLinks) : $site); ?>  alt="image doesnt exist">
                </a>
            <?php elseif($listing instanceof \App\Models\Rentable): ?>
                <?php if($listing->status =='Available'): ?>
                    <div class="status green">
                    </div>
                <?php else: ?>
                    <div class="status">
                    </div>
                <?php endif; ?>
                <div class="card_type rent">
                    <p>Rent</p>
                </div>

                <div class="card_favorite">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <a href="/rentables/<?php echo e($listing->id); ?>">
                    <?php
                    $imgLinks = null;
                        if(isset($listing->image_uploads)){
                            $imgLinks = json_decode($listing->image_uploads);
                            if(is_array($imgLinks)){
                                $imgLinks = $imgLinks[0];
                            }
                        }
                        $site = 'https://picsum.photos/300/200?sig='. rand(0,100);
                    ?>
                    
                    <img src=<?php echo e($listing->image_uploads ? Storage::disk('s3')->url($imgLinks) : $site); ?>  alt="image doesnt exist">
                </a>
            <?php else: ?>
                <?php if($listing->status =='Available'): ?>
                    <div class="status green">
                    </div>
                <?php else: ?>
                    <div class="status">
                    </div>
                <?php endif; ?>
                <div class="card_type lease">
                    <p>Lease</p>
                </div>

                <div class="card_favorite">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <a href="/subleases/<?php echo e($listing->id); ?>">
                    <?php
                    $imgLinks = null;
                        if(isset($listing->image_uploads)){
                            $imgLinks = json_decode($listing->image_uploads);
                            if(is_array($imgLinks)){
                                $imgLinks = $imgLinks[0];
                            }
                        }
                        $site = 'https://picsum.photos/300/200?sig='. rand(0,100);
                    ?>
                    <img src=<?php echo e($listing->image_uploads ? Storage::disk('s3')->url($imgLinks) : $site); ?>  alt="image doesnt exist">
                </a>
            <?php endif; ?>
        </div>
        <div class="card_content">
            <?php if($listing instanceof \App\Models\Listing): ?>
                <a href="">
                    <h4>$<?php echo e($listing->price); ?></h1>  
                    <p><?php echo e($listing->item_name); ?></p>
                </a>
            <?php elseif($listing instanceof \App\Models\Rentable): ?>
                <a>
                    <h4>$<?php echo e($listing->rental_charging); ?> / <?php echo e($listing->rental_duration); ?></h4>  
                    <p><?php echo e($listing->rental_title); ?></p>
                </a>  
            <?php else: ?>
                <div>
                    <h4>$<?php echo e($listing->rent); ?> / Mo | <?php echo e($listing->negotiable); ?></h4>  
                    <p><?php echo e($listing->sublease_title); ?></p>
                </div>  
                
            <?php endif; ?>
        </div>
    </div>
</li><?php /**PATH C:\xampp\htdocs\CollegeMarketplace\resources\views/components/gallery-card.blade.php ENDPATH**/ ?>