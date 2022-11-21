{{-- css for the category specific carousel --}}
@inject('generalController', 'App\Http\Controllers\Controller')
<link rel="stylesheet" types ="text/css" href="/css/componentDesign.css">
<section class = "component-container-outer">
    <div class="component-container-inner">
        <div class="img-slider-container">
            <div class="single-slide active">
                <img src="" alt="">
                <div class="info">
                    <h2>BUY</h2>
                    <p>Buy furniture, books, supplies, and more from your fellow students!</p>
                </div>
            </div>
            <div class="single-slide">
                <img src="" alt="">
                <div class="info">
                    <h2>SELL</h2>
                    <p>Connect with a nearby student and sell your new or used items.
                    Making money at college has never been easier!</p>
                </div>
            </div>
            <div class="single-slide">
                <img src="" alt="">
                <div class="info">
                    <h2>RENT</h2>
                    <p>Need a place to stay? No worries!
                    Get started by checking out all the places available near your university or on-grounds!</p>
                </div>
            </div>
            <div class="single-slide">
                <img src="" alt="">
                <div class="info">
                    <h2>LEASE</h2>
                    <p>Need a lease? We got you covered! Check out leasing options available near you.</p>
                </div>
            </div>
            <div class="navigation">
                <div class="btn active"></div>
                <div class="btn"></div>
                <div class="btn"></div>
                <div class="btn"></div>
            </div>
        </div>
        <h1 class="recommended-item-title">Recommended Item</h1>
        <div class="showRandomItem" id="showRandomItem">
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
                    </div>
                    <button onclick="getNewItem()" class="next-recommended type-sale"><i class="fa-solid fa-xmark"></i></button>
                    <a class="view-item type-sale" href="/listings/{{$randomItem->id}}" >Buy</a>
                @elseif($randomItem instanceof App\Models\Rentable)
                    <a href="/rentables/{{$randomItem->id}}">
                        <img src={{$randomItem->image_uploads ? Storage::disk('s3')->url($imgLinks) : asset($link) }}  alt="image doesnt exist">
                    </a>
                    <div class="random-item-content">
                        <div>
                            <h1>{{$randomItem->rental_charging}} / {{$randomItem->rental_duration}}</h1>
                            <p>{{$randomItem->rental_title}}</p>
                        </div>
                    </div>
                    <button onclick="getNewItem()" class="next-recommended type-rent"><i class="fa-solid fa-xmark"></i></button>
                    <a href="/rentables/{{$randomItem->id}}" class="view-item type-rent">Rent</a>
                @else
                    <a href="/subleases/{{$randomItem->id}}">
                        <img src={{$randomItem->image_uploads ? Storage::disk('s3')->url($imgLinks) : asset($link) }}  alt="image doesnt exist">
                    </a>
                    <div class="random-item-content">
                        <div>
                            <h1>{{$randomItem->rent}}</h1>
                            <p>{{$randomItem->sublease_title}}</p>
                        </div>
                    </div>
                    <button onclick="getNewItem()" class="next-recommended type-lease"><i class="fa-solid fa-xmark"></i></button>
                    <a href="/subleases/{{$randomItem->id}}" class="view-item type-lease">Lease</a>
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
            }, 5000);
        }
        repeater();
    }
    repeat();

    function getNewItem(){
        console.log("button clicked");

        $.ajax({
            type: "GET",
            url: "/random/item", // need to create this route
            data: "JSON",
            cache: false,
            success: function (data) {
                // console.log(data);
                if(data != null){
                    // console.log(data);
                    $(document).ready(function(){
                        $('#showRandomItem').empty();

                        $href = $('<a>',{href: "localhost:3000"});
                        $titleImage = data.image_uploads != null ? jQuery.parseJSON(data.image_uploads) : null;
                        $source = $titleImage == null ? 'https://picsum.photos/300/200?sig=' + Math.floor(Math.random() * 100) + 1 : 'https://cmimagestoragebucket.s3.amazonaws.com/'+$titleImage[0];
                        $imgTag = $("<img/>", {
                            id: 'test',
                            src: $source,
                            alt: 'test'
                        });
                        $href.append($imgTag).appendTo('#showRandomItem');
                        
                        if(data.item_name != null){

                            $href.attr("href", "/listings/"+data.id);

                            $banner = $('<div/>',{
                                class: 'random-item-content',
                                html: $('<div/>').append($('<h1>',{
                                    text: data.price
                                    })).append($('<p>',{
                                        text: data.item_name
                                    }))
                            });
                            $banner.appendTo('#showRandomItem');

                            $button = $('<button>',{
                                class: 'next-recommended type-sale'
                            }).append($('<i/>', {
                                class: 'fa-solid fa-xmark'
                            })).attr("onclick", "getNewItem()");
                            $button.appendTo('#showRandomItem');

                            $linkHref = $('<a>', {
                                href: "/listings/"+data.id,
                                class: "view-item type-sale",
                                text: "Buy"
                            }).appendTo('#showRandomItem');

                        }else if(data.rental_title != null){

                            $href.attr("href", "/rentables/"+data.id);
                            
                            $banner = $('<div/>',{
                                class: 'random-item-content',
                                html: $('<div/>').append($('<h1>',{
                                        text: data.rental_charging + " / " + data.rental_duration
                                    })).append($('<p>',{
                                        text: data.rental_title
                                    }))
                            });
                            $banner.appendTo('#showRandomItem');

                            $button = $('<button>',{
                                class: 'next-recommended type-rent'
                            }).append($('<i/>', {
                                class: 'fa-solid fa-xmark'
                            })).attr("onclick", "getNewItem()");
                            $button.appendTo('#showRandomItem');

                            $linkHref = $('<a>', {
                                href: "/rentables/"+data.id,
                                class: "view-item type-rent",
                                text: "Rent"
                            }).appendTo('#showRandomItem');

                        }else if(data.sublease_title != null){

                            $href.attr("href", "/subleases/"+data.id);

                            $banner = $('<div/>',{
                                class: 'random-item-content',
                                html: $('<div/>').append($('<h1>',{
                                    text: data.rent
                                    })).append($('<p>',{
                                        text: data.sublease_title
                                    }))
                            });
                            $banner.appendTo('#showRandomItem');

                            $button = $('<button>',{
                                class: 'next-recommended type-lease'
                            }).append($('<i/>', {
                                class: 'fa-solid fa-xmark'
                            })).attr("onclick", "getNewItem()");
                            $button.appendTo('#showRandomItem');

                            $linkHref = $('<a>', {
                                href: "/subleases/"+data.id,
                                class: "view-item type-lease",
                                text: "Lease"
                            }).appendTo('#showRandomItem');

                        }
                    });
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                alert("Status: " + textStatus); alert("Error: " + errorThrown); 
            }
        });
    }

</script>