{{-- css for the carousel --}}
<link rel="stylesheet" types ="text/css" href="/css/carousel.css">

<section id="slider" class="rent-slider">
    <div class="container">
        <div class="subcontainer">
            <div class="slider-wrapper">
                @unless(count($rentables) == 0)
                    <div id="{{$carouselControls}}">
                        <button class = "{{$carouselP}}">
                            <i   class="fa-solid fa-angle-left"></i>
                        </button>
                        <button class = "{{$carouselN}}">
                            <i class="fa-solid fa-angle-right"></i>
                        </button>
                    </div>
                @endunless
                <div class="controller">
                    <div> 
                        {{-- : @php echo count($rentables) @endphp --}}
                        <h2>{{$message}}</h2>
                        <a style="font-size:14px;" href="/shop/all?type=rentable" class="button1">MORE</a>
                    </div>
                </div>
                @unless(count($rentables) == 0)
                    <div class="{{$carouselClass}}">
                        @foreach($rentables as $rentable)
                            <x-carousel-card :listing="null" :rentable="$rentable" :currentUser="$currentUser"/>
                        @endforeach
                    </div>
                @else
                    <p class="empty-gallary-message">No Rentables Found!</p>
                @endunless
            </div>
        </div>
    </div>
    <script>
        var rentablesArray =  {!! json_encode($rentables) !!};
        if(rentablesArray.length > 0){
            tns({
                container: ".slider2",
                "slideBy":1,
                "speed":400,
                "nav":false,
                autoplayButton: false,
                autoplay: true,
                autoplayText:["",""],
                controlsContainer:"#controls2",
                responsive:{
                    1500:{
                        items: 5,
                        gutter: 5
                    },
                    1200:{
                        items: 4,
                        gutter: 10
                    },
                    // 1100:{
                    //     items: 3,
                    //     gutter: 15
                    // },
                    1024:{
                        items: 3,
                        gutter: 15
                    },
                    700:{
                        items: 2,
                        gutter: 20
                    },
                    480:{
                        items: 1
                    }
                }
            })
        }

    </script>
</section>