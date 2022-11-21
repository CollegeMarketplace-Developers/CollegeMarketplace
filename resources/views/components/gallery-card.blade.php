@props(['listing', 'displayTags', 'currentUser'])
{{-- data-aos-once="true" --}}
<li class="cards_item" data-aos="zoom-in" data-aos-once="true">
    <div class="card"> 
        <div class="card_image">
            @if($listing instanceof \App\Models\Listing)
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

                @if($listing->negotiable == "Free")
                    <div class="ribbon">
                        <span class="ribbon2 gallery-ribbon">F<br>R<br>E<br>E<br></span>
                    </div>
                @else
                    <div class="card_type sale">
                        <p>Buy</p>
                    </div>
                @endif

                {{-- has the item been favorited --}}
                <div class="card_favorite">
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
                    {{-- <i class="fa-solid fa-heart"></i> --}}
                </div>
                <a href="/listings/{{$listing->id}}">
                    @php
                    $imgLinks = null;
                        if(isset($listing->image_uploads)){
                            $imgLinks = json_decode($listing->image_uploads);
                            if(is_array($imgLinks)){
                                $imgLinks = $imgLinks[0];
                                
                            }
                        }
                        $site = 'https://picsum.photos/300/200?sig='. rand(0,100);
                    @endphp
                    <img src={{$listing->image_uploads ? Storage::disk('s3')->url($imgLinks) : $site }}  alt="image doesnt exist">
                </a>
            @elseif($listing instanceof \App\Models\Rentable)
                @if($listing->status =='Available')
                    <div class="status green">
                    </div>
                @else
                    <div class="status">
                    </div>
                @endif
                <div class="card_type rent">
                    <p>Rent</p>
                </div>

                <div class="card_favorite">
                    @if($currentUser != null and $currentUser->rentableFavorites != null and in_array($listing->id, explode(", " , $currentUser->rentableFavorites)))
                        <form action="/users/removefavorite" method="GET">
                            @csrf
                            <input type="hidden" name="type" value="rentable">
                            <input type="hidden" name="id" value="{{$listing->id}}">
                            <button><i class="fa-solid fa-heart saved"></i></button>
                        </form>
                    @else
                        <form action="/users/addfavorite" method="GET">
                            @csrf
                            <input type="hidden" name="type" value="rentable">
                            <input type="hidden" name="id" value="{{$listing->id}}">
                            <button><i class="fa-solid fa-heart bouncy"></i></button>
                        </form>
                    @endif
                    {{-- <i class="fa-solid fa-heart"></i> --}}
                </div>
                <a href="/rentables/{{$listing->id}}">
                    @php
                    $imgLinks = null;
                        if(isset($listing->image_uploads)){
                            $imgLinks = json_decode($listing->image_uploads);
                            if(is_array($imgLinks)){
                                $imgLinks = $imgLinks[0];
                            }
                        }
                        $site = 'https://picsum.photos/300/200?sig='. rand(0,100);
                    @endphp
                    {{-- asset('/images/rotunda.jpg') --}}
                    <img src={{$listing->image_uploads ? Storage::disk('s3')->url($imgLinks) : $site }}  alt="image doesnt exist">
                </a>
            @else
                @if($listing->status =='Available')
                    <div class="status green">
                    </div>
                @else
                    <div class="status">
                    </div>
                @endif
                <div class="card_type lease">
                    <p>Lease</p>
                </div>

                <div class="card_favorite">
                    @if($currentUser != null and $currentUser->leaseFavorites != null and in_array($listing->id, explode(", " , $currentUser->leaseFavorites)))
                        <form action="/users/removefavorite" method="GET">
                            @csrf
                            <input type="hidden" name="type" value="leaseItem">
                            <input type="hidden" name="id" value="{{$listing->id}}">
                            <button><i class="fa-solid fa-heart saved"></i></button>
                        </form>
                    @else
                        <form action="/users/addfavorite" method="GET">
                            @csrf
                            <input type="hidden" name="type" value="leaseItem">
                            <input type="hidden" name="id" value="{{$listing->id}}">
                            <button><i class="fa-solid fa-heart bouncy"></i></button>
                        </form>
                    @endif
                    {{-- <i class="fa-solid fa-heart"></i> --}}
                </div>
                <a href="/subleases/{{$listing->id}}">
                    @php
                    $imgLinks = null;
                        if(isset($listing->image_uploads)){
                            $imgLinks = json_decode($listing->image_uploads);
                            if(is_array($imgLinks)){
                                $imgLinks = $imgLinks[0];
                            }
                        }
                        $site = 'https://picsum.photos/300/200?sig='. rand(0,100);
                    @endphp
                    <img src={{$listing->image_uploads ? Storage::disk('s3')->url($imgLinks) : $site }}  alt="image doesnt exist">
                </a>
            @endif
        </div>
        <div class="card_content">
            @if($listing instanceof \App\Models\Listing)
                <a href="">
                    <h4>${{$listing->price}}</h1>  
                    <p>{{$listing->item_name}}</p>
                </a>
            @elseif($listing instanceof \App\Models\Rentable)
                <a>
                    <h4>${{$listing->rental_charging}} / {{$listing->rental_duration}}</h4>  
                    <p>{{$listing->rental_title}}</p>
                </a>  
            @else
                <div>
                    <h4>${{$listing->rent}} / Monthly </h4>  
                    <p>{{$listing->sublease_title}}</p>
                </div>  
                {{-- <div>
                    <a href="/subleases/{{$listing->id}}">
                        <h1 class="card_title">{{$listing->sublease_title}}</h1>
                    </a>
                    <h4 class="card_text">{{$listing->city}}, {{$listing->state}}</h4>
                </div>
                <div class="listing-tags">
                    @if($displayTags)
                        @php
                            $tags = explode(", ", $listing->utilities);
                        @endphp
                        <x-listing-tags :tags="$tags" :isUtilities=true />
                    @endif
                </div> --}}
            @endif
        </div>
    </div>
</li>