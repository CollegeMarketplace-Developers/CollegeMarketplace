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
                <div>
                    <h4>$<?php echo e($listing->price); ?></h4>  
                    <i class="fa-solid fa-heart"></i>
                </div>  
                <div>
                    <a href="/listings/<?php echo e($listing->id); ?>">
                        <h1 class="card_title"><?php echo e($listing->item_name); ?></h1>
                    </a>
                    <h4 class="card_text"><?php echo e($listing->city); ?>, <?php echo e($listing->state); ?></h4>
                </div>
                <div class="listing-tags">
                    <?php if($displayTags): ?>
                        <?php
                            $tags = explode(", ", $listing->tags);
                        ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.listing-tags','data' => ['tags' => $tags,'isUtilities' => false]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listing-tags'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tags' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tags),'isUtilities' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php elseif($listing instanceof \App\Models\Rentable): ?>
                <div>
                    <h4>$<?php echo e($listing->rental_charging); ?> / <?php echo e($listing->rental_duration); ?></h4>  
                    <i class="fa-solid fa-heart"></i>
                </div>  
                <div>
                    <a href="/rentables/<?php echo e($listing->id); ?>">
                        <h1 class="card_title"><?php echo e($listing->rental_title); ?></h1>
                    </a>
                    <h4 class="card_text"><?php echo e($listing->city); ?>, <?php echo e($listing->state); ?></h4>
                </div>
                <div class="listing-tags">
                    <?php if($displayTags): ?>
                        <?php
                            $tags = explode(", ", $listing->tags);
                        ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.listing-tags','data' => ['tags' => $tags,'isUtilities' => false]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listing-tags'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tags' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tags),'isUtilities' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div>
                    <h4>$<?php echo e($listing->rent); ?> / Mo| <?php echo e($listing->negotiable); ?></h4>  
                    <i class="fa-solid fa-heart"></i>
                </div>  
                <div>
                    <a href="/subleases/<?php echo e($listing->id); ?>">
                        <h1 class="card_title"><?php echo e($listing->sublease_title); ?></h1>
                    </a>
                    <h4 class="card_text"><?php echo e($listing->city); ?>, <?php echo e($listing->state); ?></h4>
                </div>
                <div class="listing-tags">
                    <?php if($displayTags): ?>
                        <?php
                            $tags = explode(", ", $listing->utilities);
                        ?>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.listing-tags','data' => ['tags' => $tags,'isUtilities' => true]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('listing-tags'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tags' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tags),'isUtilities' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</li><?php /**PATH C:\xampp\htdocs\CollegeMarketplace\resources\views/components/gallery-card.blade.php ENDPATH**/ ?>