{{-- css for the category specific carousel --}}
@inject('generalController', 'App\Http\Controllers\Controller')
<link rel="stylesheet" types ="text/css" href="/css/componentDesign.css">
<section class = "component-container-outer">
    <div class="component-container-inner">
        <div class="img-slider-container">
            <div class="single-slide active">
                <img src="1.jpg" alt="">
                <div class="info">
                    <h2>BUY</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua.</p>
                </div>
            </div>
            <div class="single-slide">
                <img src="2.jpg" alt="">
                <div class="info">
                    <h2>Sell</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua.</p>
                </div>
            </div>
            <div class="single-slide">
                <img src="3.jpg" alt="">
                <div class="info">
                    <h2>RENT</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua.</p>
                </div>
            </div>
            <div class="single-slide">
                <img src="4.jpg" alt="">
                <div class="info">
                    <h2>LEASE</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua.</p>
                </div>
            </div>
            {{-- <div class="single-slide">
                <img src="5.jpg" alt="">
                <div class="info">
                    <h2>Slide 05</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua.</p>
                </div>
            </div> --}}
            <div class="navigation">
                <div class="btn active"></div>
                <div class="btn"></div>
                <div class="btn"></div>
                <div class="btn"></div>
                {{-- <div class="btn"></div> --}}
            </div>
        </div>
        <div class="showRandomItem">
            @php
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
            @endphp
            @if($randomItem != null)
                @if($randomItem instanceof App\Models\Listing)
                    <a href="/listings/{{$randomItem->id}}">
                        <img src={{$randomItem->image_uploads ? Storage::disk('s3')->url($imgLinks) : asset($link) }}  alt="image doesnt exist">
                    </a>
                    <div class="random-item-content">
                        <div>
                            <h1>{{$randomItem->price}}</h1>
                            <p>{{$randomItem->item_name}}</p>
                        </div>
                        <a href="/listings/{{$randomItem->id}}" class="type-sale">Buy</a>
                    </div>
                @elseif($randomItem instanceof App\Models\Rentable)
                    <a href="/rentables/{{$randomItem->id}}">
                        <img src={{$randomItem->image_uploads ? Storage::disk('s3')->url($imgLinks) : asset($link) }}  alt="image doesnt exist">
                    </a>
                    <div class="random-item-content">
                        <div>
                            <h1>{{$randomItem->rental_charging}} / {{$randomItem->rental_duration}}</h1>
                            <p>{{$randomItem->rental_title}}</p>
                        </div>
                        <a href="/rentables/{{$randomItem->id}}" class="type-rent">Rent</a>
                    </div>
                @else
                    <a href="/subleases/{{$randomItem->id}}">
                        <img src={{$randomItem->image_uploads ? Storage::disk('s3')->url($imgLinks) : asset($link) }}  alt="image doesnt exist">
                    </a>
                    <div class="random-item-content">
                        <div>
                            <h1>{{$randomItem->rent}}</h1>
                            <p>{{$randomItem->sublease_title}}</p>
                        </div>
                        <a href="/subleases/{{$randomItem->id}}" class="type-lease">Lease</a>
                    </div>
                @endif
            @else
                @php
                    $uhoh=['/images/confused.jpg', '/images/confused-removebg-preview.png'];
                    $uhohLink = $uhoh[random_int(0, count($uhoh)-1)];
                @endphp
                <img src={{asset('/images/confused.jpg') }}  alt="Item was not found nor the image">
                <div class="random-item-content">
                    <p>No Items Found :(</p>
                </div>
            @endif
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
            }, 10000);
        }
        repeater();
    }
    repeat();
</script>