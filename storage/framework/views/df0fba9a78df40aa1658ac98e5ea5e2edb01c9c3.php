<?php foreach($attributes->onlyProps(['listing', 'displayTags', 'currentUser']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['listing', 'displayTags', 'currentUser']); ?>
<?php foreach (array_filter((['listing', 'displayTags', 'currentUser']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
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

                <?php if($listing->negotiable == "Free"): ?>
                    <div class="ribbon">
                        <span class="ribbon2 gallery-ribbon">F<br>R<br>E<br>E<br></span>
                    </div>
                <?php else: ?>
                    <div class="card_type sale">
                        <p>Buy</p>
                    </div>
                <?php endif; ?>

                
                <div class="card_favorite">
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
                    <?php if($currentUser != null and $currentUser->rentableFavorites != null and in_array($listing->id, explode(", " , $currentUser->rentableFavorites))): ?>
                        <form action="/users/removefavorite" method="GET">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="type" value="rentable">
                            <input type="hidden" name="id" value="<?php echo e($listing->id); ?>">
                            <button><i class="fa-solid fa-heart saved"></i></button>
                        </form>
                    <?php else: ?>
                        <form action="/users/addfavorite" method="GET">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="type" value="rentable">
                            <input type="hidden" name="id" value="<?php echo e($listing->id); ?>">
                            <button><i class="fa-solid fa-heart bouncy"></i></button>
                        </form>
                    <?php endif; ?>
                    
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
                    <?php if($currentUser != null and $currentUser->leaseFavorites != null and in_array($listing->id, explode(", " , $currentUser->leaseFavorites))): ?>
                        <form action="/users/removefavorite" method="GET">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="type" value="leaseItem">
                            <input type="hidden" name="id" value="<?php echo e($listing->id); ?>">
                            <button><i class="fa-solid fa-heart saved"></i></button>
                        </form>
                    <?php else: ?>
                        <form action="/users/addfavorite" method="GET">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="type" value="leaseItem">
                            <input type="hidden" name="id" value="<?php echo e($listing->id); ?>">
                            <button><i class="fa-solid fa-heart bouncy"></i></button>
                        </form>
                    <?php endif; ?>
                    
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
                    <h4>$<?php echo e($listing->rent); ?> / Monthly </h4>  
                    <p><?php echo e($listing->sublease_title); ?></p>
                </div>  
                
            <?php endif; ?>
        </div>
    </div>
</li><?php /**PATH C:\xampp\htdocs\CollegeMarketplace\resources\views/components/gallery-card.blade.php ENDPATH**/ ?>