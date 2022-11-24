@props([ 'listing', 'rentable', 'sublease'])
@aware(['currentUser'])
<div>
    {{-- if the card is a listing card --}}
    @if($listing != null)
        
        <div {{$attributes->merge(['class'=> 'slide single-post-cont'])}} data-aos="fade-right" data-aos-once="true">
            {{-- <div class="cr cr-top cr-right cr-sticky listing">{{$listing->status}}</div> --}}
            {{-- <a href="/listings/{{$listing->id}}"> --}}
            <div class="slide-img">
                {{-- <span class="ribbon ribbon-listing">
                    {{$listing->status}}
                </span> --}}
                @if($listing->negotiable == "Free")
                    <div class="ribbon">
                        <span class="ribbon2">F<br>R<br>E<br>E<br></span>
                    </div>
                @endif

                @if($listing->status =='Available')
                    <div class="status green">
                    </div>
                @elseif($listing->status=='Pending')
                    <div class="status yellow">
                    </div>
                @else
                    <div class="status">
                    </div>
                @endif
                <a href="/listings/{{$listing->id}}">
                    @php
                        $imgLinks = null;
                        if(isset($listing->image_uploads)){
                            //decode the json object
                            $imgLinks = json_decode($listing->image_uploads);
                            if(is_array($imgLinks)){
                                $imgLinks = $imgLinks[0];
                                //echo Storage::disk('s3')->url('listings/'.$imgLinks);
                                //echo $imgLinks;
                                //debug_to_console($imgLinks);
                            }
                        }
                        $site = 'https://picsum.photos/300/200?sig='. rand(0,100);
                    @endphp
                    @php
                        //$hardLink=['https://cmimagestoragebucket.s3.amazonaws.com/devimages/rotunda.jpg', 'https://cmimagestoragebucket.s3.amazonaws.com/devimages/old-cabell.jpg', 'https://cmimagestoragebucket.s3.amazonaws.com/devimages/cavalier-horse.jpg'];
                        $hardLink=['/images/rotunda.jpg', '/images/old-cabell.jpg', '/images/cavalier-horse.jpg'];
                        $link = $hardLink[random_int(0, count($hardLink)-1)];
                    @endphp
                    <img src={{$listing->image_uploads ? Storage::disk('s3')->url($imgLinks) : $site }}  alt="image doesnt exist">
                </a>
                @if($currentUser != null and $currentUser->favorites != null and in_array($listing->id, explode(", " , $currentUser->favorites)))
                    <form action="/users/removefavorite" method="GET">
                        @csrf
                        <input type="hidden" name="type" value="listing">
                        <input type="hidden" name="id" value="{{$listing->id}}">
                        <button><i class="fa-solid fa-heart saved"></i></button>
                    </form>
                @else
                    <form action="/users/addfavorite" method="GET">
                        @csrf
                        <input type="hidden" name="type" value="listing">
                        <input type="hidden" name="id" value="{{$listing->id}}">
                        <button><i class="fa-solid fa-heart bouncy"></i></button>
                    </form>
                @endif
            </div>
            {{-- </a> --}}
            <div class = "listing-details">
                <div class="listing-details-top">
                    <h1>${{$listing->price}}</h1>
                    {{-- <i class="fa-solid fa-heart"></i> --}}
                </div>
                <div class="listing-details-middle">
                    <a href="/listings/{{$listing->id}}">{{$listing->item_name}}</a>
                </div>
                <div class="listing-details-bottom">
                    <div>
                        <p>{{$listing->city}}, {{$listing->state}}</p>
                        <p>{{$listing->condition}}</p>
                    </div>
                    @if($listing->negotiable == "Free")
                        <a class="type-free" href="/listings/{{$listing->id}}">Claim</a>
                    @else
                        <a class="type-sale" href="/listings/{{$listing->id}}">Buy</a>
                    @endif
                </div>
            </div>

            <a href="/listings/{{$listing->id}}" class="clickable-card"></a>
        </div>
    {{-- if the card is a rentable card --}}
    @elseif($rentable != null)
        <div {{$attributes->merge(['class'=> 'slide single-post-cont '])}} data-aos="fade-right" data-aos-once="true">
            {{-- <div class="cr cr-top cr-right cr-sticky rentable">{{$rentable->status}}</div> --}}
            {{-- <a href="/rentables/{{$rentable->id}}"> --}}
            <div class="slide-img">
                    {{-- <span class="ribbon ribbon-rental">
                    {{$rentable->status}}
                </span> --}}
                @if($rentable->status =='Available')
                    <div class="status green">
                    </div>
                @else
                    <div class="status">
                    </div>
                @endif
                <a href="/rentables/{{$rentable->id}}">
                    @php
                    $imgLinks = null;
                        if(isset($rentable->image_uploads)){
                            //decode the json object
                            $imgLinks = json_decode($rentable->image_uploads);
                            if(is_array($imgLinks)){
                                $imgLinks = $imgLinks[0];
                            }
                        }
                        $site = 'https://picsum.photos/300/200?sig='. rand(0,100);
                    @endphp
                    {{-- <h1>{{$listing->image_uploads}}</h1> --}}
                    @php
                        //$hardLink=['https://cmimagestoragebucket.s3.amazonaws.com/devimages/rotunda.jpg', 'https://cmimagestoragebucket.s3.amazonaws.com/devimages/old-cabell.jpg', 'https://cmimagestoragebucket.s3.amazonaws.com/devimages/cavalier-horse.jpg'];
                        $hardLink=['/images/rotunda.jpg', '/images/old-cabell.jpg', '/images/cavalier-horse.jpg'];
                        $link = $hardLink[random_int(0, count($hardLink)-1)];
                    @endphp
                    <img src={{$rentable->image_uploads ? Storage::disk('s3')->url($imgLinks) : $site}}  alt="image doesnt exist">
                </a>
                @if($currentUser != null and $currentUser->rentableFavorites != null and in_array($rentable->id, explode(", " , $currentUser->rentableFavorites)))
                    <form action="/users/removefavorite" method="GET">
                        @csrf
                        <input type="hidden" name="type" value="rentable">
                        <input type="hidden" name="id" value="{{$rentable->id}}">
                        <button><i class="fa-solid fa-heart saved"></i></button>
                    </form>
                @else
                    <form action="/users/addfavorite" method="GET">
                        @csrf
                        <input type="hidden" name="type" value="rentable">
                        <input type="hidden" name="id" value="{{$rentable->id}}">
                        <button><i class="fa-solid fa-heart bouncy"></i></button>
                    </form>
                @endif
            </div>
            {{-- </a> --}}
            <div class = "listing-details">
                <div class="listing-details-top">
                    <h1>${{$rentable->rental_charging}} / {{$rentable->rental_duration}}</h1>
                    {{-- <i class="fa-solid fa-heart"></i> --}}
                </div>
                <div class="listing-details-middle">
                    <a href="/rentables/{{$rentable->id}}">{{$rentable->rental_title}}</a>
                </div>
                <div class="listing-details-bottom">
                    <div>
                        <p>{{$rentable->city}}, {{$rentable->state}}</p>
                        <p>{{$rentable->condition}}</p>
                    </div>
                    <a class="type-rent" href="/rentables/{{$rentable->id}}">Rent</a>
                </div>
            </div>

            <a href="/rentables/{{$rentable->id}}" class="clickable-card"></a>
        </div>
    @elseif($sublease != null)
         <div {{$attributes->merge(['class'=> 'slide single-post-cont '])}} data-aos="fade-right" data-aos-once="true">
            {{-- <div class="cr cr-top cr-right cr-sticky sublease">{{$sublease->status}}</div> --}}
            {{-- <a href="/subleases/{{$sublease->id}}"> --}}
            <div class="slide-img">
                @if($sublease->status =='Available')
                    <div class="status green">
                    </div>
                @else
                    <div class="status">
                    </div>
                @endif
                <a href="/subleases/{{$sublease->id}}">
                    @php
                    $imgLinks = null;
                        if(isset($sublease->image_uploads)){
                            //decode the json object
                            $imgLinks = json_decode($sublease->image_uploads);
                            if(is_array($imgLinks)){
                                $imgLinks = $imgLinks[0];
                            }
                        }
                        $site = 'https://picsum.photos/300/200?sig='. rand(0,100);
                    @endphp
                    {{-- <h1>{{$listing->image_uploads}}</h1> --}}
                    @php
                        //$hardLink=['https://cmimagestoragebucket.s3.amazonaws.com/devimages/rotunda.jpg', 'https://cmimagestoragebucket.s3.amazonaws.com/devimages/old-cabell.jpg', 'https://cmimagestoragebucket.s3.amazonaws.com/devimages/cavalier-horse.jpg'];
                        $hardLink=['/images/rotunda.jpg', '/images/old-cabell.jpg', '/images/cavalier-horse.jpg'];
                        $link = $hardLink[random_int(0, count($hardLink)-1)];
                    @endphp
                    <img src={{$sublease->image_uploads ? Storage::disk('s3')->url($imgLinks) : $site }}  alt="image doesnt exist">
                </a>
                @if($currentUser != null and $currentUser->leaseFavorites != null and in_array($sublease->id, explode(", " , $currentUser->leaseFavorites)))
                    <form action="/users/removefavorite" method="GET">
                        @csrf
                        <input type="hidden" name="type" value="leaseItem">
                        <input type="hidden" name="id" value="{{$sublease->id}}">
                        <button><i class="fa-solid fa-heart saved"></i></button>
                    </form>
                @else
                    <form action="/users/addfavorite" method="GET">
                        @csrf
                        <input type="hidden" name="type" value="leaseItem">
                        <input type="hidden" name="id" value="{{$sublease->id}}">
                        <button><i class="fa-solid fa-heart bouncy"></i></button>
                    </form>
                @endif
            </div>
            <div class = "listing-details">
                <div class="listing-details-top">
                    <h1>${{$sublease->rent}} / Mo | {{$sublease->negotiable}}</h1>
                </div>
                <div class="listing-details-middle">
                   <a href="/subleases/{{$sublease->id}}">{{$sublease->sublease_title}}</a>
                </div>
                <div class="listing-details-bottom">
                    <div>
                        <p>{{$sublease->city}}, {{$sublease->state}}</p>
                        <p>{{$sublease->location}}</p>
                    </div>
                    <a class="type-lease" href="/subleases/{{$sublease->id}}">Lease</a>
                </div>
            </div>

            <a href="/subleases/{{$sublease->id}}" class="clickable-card"></a>
        </div>
    @endif
</div>

