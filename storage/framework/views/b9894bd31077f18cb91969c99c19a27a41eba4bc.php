
<?php $generalController = app('App\Http\Controllers\Controller'); ?>
<link rel="stylesheet" types ="text/css" href="/css/componentDesign.css">
<section class = "component-container-outer">
    <div class="component-container-inner">
        
        <div class="showRandomItem">
            <?php
                $randomItem = $generalController::getRandomItem();

                $imgLinks = null;
                if(isset($randomItem->image_uploads)){
                    $imgLinks = json_decode($randomItem->image_uploads);
                    if(is_array($imgLinks)){
                        $imgLinks = $imgLinks[0];
                    }
                }

                $hardLink=['/images/rotunda.jpg', '/images/old-cabell.jpg', '/images/cavalier-horse.jpg'];
                $link = $hardLink[random_int(0, count($hardLink)-1)];
            ?>
            <?php if($randomItem != null): ?>
                <?php if($randomItem instanceof App\Models\Listing): ?>
                    <a href="/listings/<?php echo e($randomItem->id); ?>">
                        <img src=<?php echo e($randomItem->image_uploads ? Storage::disk('s3')->url($imgLinks) : asset($link)); ?>  alt="image doesnt exist">
                    </a>
                    <div class="random-item-content">
                        <div>
                            <h1><?php echo e($randomItem->price); ?></h1>
                            <p><?php echo e($randomItem->item_name); ?></p>
                        </div>
                        <a href="/listings/<?php echo e($randomItem->id); ?>" class="type-sale">Buy</a>
                    </div>
                <?php elseif($randomItem instanceof App\Models\Rentable): ?>
                    <a href="/rentables/<?php echo e($randomItem->id); ?>">
                        <img src=<?php echo e($randomItem->image_uploads ? Storage::disk('s3')->url($imgLinks) : asset($link)); ?>  alt="image doesnt exist">
                    </a>
                    <div class="random-item-content">
                        <div>
                            <h1><?php echo e($randomItem->rental_charging); ?> / <?php echo e($randomItem->rental_duration); ?></h1>
                            <p><?php echo e($randomItem->rental_title); ?></p>
                        </div>
                        <a href="/rentables/<?php echo e($randomItem->id); ?>" class="type-rent">Rent</a>
                    </div>
                <?php else: ?>
                    <a href="/subleases/<?php echo e($randomItem->id); ?>">
                        <img src=<?php echo e($randomItem->image_uploads ? Storage::disk('s3')->url($imgLinks) : asset($link)); ?>  alt="image doesnt exist">
                    </a>
                    <div class="random-item-content">
                        <div>
                            <h1><?php echo e($randomItem->rent); ?></h1>
                            <p><?php echo e($randomItem->sublease_title); ?></p>
                        </div>
                        <a href="/subleases/<?php echo e($randomItem->id); ?>" class="type-lease">Lease</a>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <?php
                    $uhoh=['/images/confused.jpg', '/images/confused-removebg-preview.png'];
                    $uhohLink = $uhoh[random_int(0, count($uhoh)-1)];
                ?>
                <img src=<?php echo e(asset('/images/confused.jpg')); ?>  alt="Item was not found nor the image">
                <div class="random-item-content">
                    <p>No Items Found :(</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script type="text/javascript">
    var slides = document.querySelectorAll('.single-slide');
    var btns = document.querySelectorAll('.btn');
    let currentSlide = 1;

    // Javascript for image slider manual navigation
    var manualNav = function (manual) {
        slides.forEach((slide) => {
            slide.classList.remove('active');

            btns.forEach((btn) => {
                btn.classList.remove('active');
            });
        });

        slides[manual].classList.add('active');
        btns[manual].classList.add('active');
    }

    btns.forEach((btn, i) => {
        btn.addEventListener("click", () => {
            manualNav(i);
            currentSlide = i;
        });
    });

    // Javascript for image slider autoplay navigation
    var repeat = function (activeClass) {
        let active = document.getElementsByClassName('active');
        let i = 1;

        var repeater = () => {
            setTimeout(function () {
                [...active].forEach((activeSlide) => {
                    activeSlide.classList.remove('active');
                });

                slides[i].classList.add('active');
                btns[i].classList.add('active');
                i++;

                if (slides.length == i) {
                    i = 0;
                }
                if (i >= slides.length) {
                    return;
                }
                repeater();
            }, 5000);
        }
        repeater();
    }
    repeat();
</script><?php /**PATH C:\xampp\htdocs\CollegeMarketplace\resources\views/partials/_componentDesignOne.blade.php ENDPATH**/ ?>