{{-- layout serves as the base template for all pages --}}

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        
        {{-- for ajax post calls  CSRF token--}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="description" content="" />
        <meta name="author" content="" />

        <title>College Marketplace</title>
        
        {{------------------------------------- style sheet files----------------------------------}}
        {{-- for tiny slider --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">
        {{-- for slide in animation via data-aos --}}
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        {{-- css for the homepage and all other general styling--}}
        <link rel="stylesheet" types ="text/css" href="/css/styles.css" />
        {{-- for carousel --}}
        <link rel="stylesheet" types ="text/css" href="/css/carousel.css">
    

        {{------------------------------------- javascript files----------------------------------}}
        {{-- for tiny slider --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.js"></script>
        {{-- for slide in animation via data-aos --}}
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        {{-- for alpine js | for flash message--}}
        <script src="//unpkg.com/alpinejs" defer></script>
        {{-- for loading static map on show pages--}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 



        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">



        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
 

        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

        <!-- shake animation from surge.sh -->
        <link rel="stylesheet" type="text/css" href="https://csshake.surge.sh/csshake.min.css">
    </head>
    <body>
        <header>
            {{-- import the navigation bar --}}
            @include('partials._navigationBar')
        </header>

        {{-- <div class="loading-page" id='loading-page'>
            <div class="loading-icon">
                <i class="fa fa-spinner fa-spin" style=" color:var(--accent-color);"></i>
            </div>
        </div> --}}

        {{-- <div class="loader-wrapper">
            <span class="loader">
                <span class="loader-inner">
                </span>
            </span>
        </div> --}}

        <x-flash-message />
        {{-- this is body where anything can be shown --}}
        {{-- search results, default listings, and etc --}}

        {{$slot}}
        
        {{-- the footer section --}}
        @include('partials._footer')
        <script>
            AOS.init();
            // function displayLoadingPage(){
            //     var page = document.getElementById('loading-page');
            //     page.style.display="flex";
            // }

            // window.addEventListener('change', (event) => {
            //     document.getElementById('loading-page');
            //     page.style.display='none';
            // });
            // window.addEventListener('load', (event) => {
            //     document.getElementById('loading-page');
            //     page.style.display='none';
            // });
            // $(document).ready(function(){
            // $(window).on("load",function(){
            //     $(".loader-wrapper").fadeOut("slow");
            // });
            // });

        </script>
    </body>
</html>
