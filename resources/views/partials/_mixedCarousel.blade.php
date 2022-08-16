{{-- css for the carousel --}}
<link rel="stylesheet" types ="text/css" href="/css/carousel.css">

<section id="slider" class="category-slider">
    <div class="container">
        <div class="subcontainer">
            <div class="slider-wrapper">
                @unless(count($listings) == 0)
                    <div id="{{$carouselControls}}">
                        <button class = "{{$carouselP}}">
                            <i   class="fa-solid fa-angle-left"></i>
                        </button>
                        <button class = "{{$carouselN}}">
                            <i class="fa-solid fa-angle-right"></i>
                        </button>
                    </div>
                @endunless
                <div class="controller mixed-controller">
                    <div> 
                        {{-- : @php echo count($listings) @endphp --}}
                        <h2>{{$message}} <span>Recently Added</span></h2>
                        <a style="font-size:14px;" href="/shop/all?type=listing" class="button1">MORE ></a>
                    </div>
                </div>
                {{-- <br> --}}
                @unless(count($listings) == 0)
                    <div class="{{$carouselClass}}">
                        @foreach($listings as $listing)
                            <div>
                                @if($listing instanceof App\Models\Listing)
                                    <x-carousel-card :listing="$listing"/>
                                @elseif($listing instanceof App\Models\Rentable)
                                    <x-carousel-card :listing="null" :rentable="$listing"/>
                                @endif
                            </div>
                        @endforeach                      
                    </div>
                @else
                    <p class="empty-gallary-message">No Listings Found!</p>
                @endunless
            </div>
        </div>
    </div>
    {{-- <script>
        $(document).ready(function() {
            var stickyElementPositioner = $('.controller');
            function stickyElementFixed() {
                stickyElementPositioner.addClass("sticky-class");
            }

            function stickyElementStatic() {
                stickyElementPositioner.removeClass("sticky-class");
            }

            $(window).scroll(function() {
                var windowScroll = $(window).scrollTop() + 50;

                if (windowScroll < stickyElementPositioner.offset().top) {
                    stickyElementStatic();
                } else {
                    stickyElementFixed();
                }

            });
        });
    </script> --}}
</section>