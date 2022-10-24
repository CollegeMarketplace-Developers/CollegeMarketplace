

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        
        
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="description" content="" />
        <meta name="author" content="" />

        <title>College Marketplace</title>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.js"></script>
        

        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

        
        
        <script src="//unpkg.com/alpinejs" defer></script>

        
        <link rel="stylesheet" types ="text/css" href="/css/styles.css" />

        
        <link rel="stylesheet" types ="text/css" href="/css/carousel.css">

        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin=""/>    

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

        
        <link rel="stylesheet" type="text/css" href="csshake.min.css">
        <!-- or from surge.sh -->
        <link rel="stylesheet" type="text/css" href="https://csshake.surge.sh/csshake.min.css">
    </head>
    <body>
        <header>
            
            <?php echo $__env->make('partials._navigationBar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </header>
        

        <div class="loader-wrapper">
            <span class="loader">
                <span class="loader-inner">
                </span>
            </span>
        </div>

        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.flash-message','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('flash-message'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        
        

        <?php echo e($slot); ?>

        
        
        <?php echo $__env->make('partials._footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

         <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init();
            function displayLoadingPage(){
                var page = document.getElementById('loading-page');
                page.style.display="flex";
            }

            window.addEventListener('change', (event) => {
                document.getElementById('loading-page');
                page.style.display='none';
            });
            window.addEventListener('load', (event) => {
                document.getElementById('loading-page');
                page.style.display='none';
            });
            $(document).ready(function(){
            $(window).on("load",function(){
                $(".loader-wrapper").fadeOut("slow");
            });
            });

        </script>
    </body>
</html>
<?php /**PATH C:\xampp\htdocs\CollegeMarketplace\resources\views/components/layout.blade.php ENDPATH**/ ?>