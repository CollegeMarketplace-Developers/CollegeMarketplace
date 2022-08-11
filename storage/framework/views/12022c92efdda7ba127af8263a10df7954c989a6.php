
<link rel="stylesheet" types ="text/css" href="/css/carousel.css">

<section id="slider" class="category-slider">
    <div class="container">
        <div class="subcontainer">
            <div class="slider-wrapper">
                <?php if (! (count($listings) == 0)): ?>
                    <div id="<?php echo e($carouselControls); ?>">
                        <button class = "<?php echo e($carouselP); ?>">
                            <i   class="fa-solid fa-angle-left"></i>
                        </button>
                        <button class = "<?php echo e($carouselN); ?>">
                            <i class="fa-solid fa-angle-right"></i>
                        </button>
                    </div>
                <?php endif; ?>
                <div class="controller">
                    <div> 
                        
                        <h2><?php echo e($message); ?> <span>Recently Added</span></h2>
                        <a style="font-size:14px;" href="/shop/all?type=listing" class="button1">MORE ></a>
                    </div>
                </div>
                
                <?php if (! (count($listings) == 0)): ?>
                    <div class="<?php echo e($carouselClass); ?>">
                        <?php $__currentLoopData = $listings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div>
                                <?php if($listing instanceof App\Models\Listing): ?>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.carousel-card','data' => ['listing' => $listing]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('carousel-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listing)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php elseif($listing instanceof App\Models\Rentable): ?>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.carousel-card','data' => ['listing' => null,'rentable' => $listing]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('carousel-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listing' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(null),'rentable' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listing)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                      
                    </div>
                <?php else: ?>
                    <p class="empty-gallary-message">No Listings Found!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section><?php /**PATH C:\xampp\htdocs\CollegeMarketplace\resources\views/partials/_mixedCarousel.blade.php ENDPATH**/ ?>