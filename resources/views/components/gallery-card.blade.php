@props(['listing', 'displayTags'])
{{-- data-aos-once="true" --}}
<li class="cards_item" data-aos="zoom-in">
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
                <div class="card_type sale">
                    <p>Buy</p>
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
                <div>
                    <h4>${{$listing->price}}</h4>  
                    <i class="fa-solid fa-heart"></i>
                </div>  
                <div>
                    <a href="/listings/{{$listing->id}}">
                        <h1 class="card_title">{{$listing->item_name}}</h1>
                    </a>
                    <h4 class="card_text">{{$listing->city}}, {{$listing->state}}</h4>
                </div>
                <div class="listing-tags">
                    @if($displayTags)
                        @php
                            $tags = explode(", ", $listing->tags);
                        @endphp
                        <x-listing-tags :tags="$tags" :isUtilities=false/>
                    @endif
                </div>
            @elseif($listing instanceof \App\Models\Rentable)
                <div>
                    <h4>${{$listing->rental_charging}} / {{$listing->rental_duration}}</h4>  
                    <i class="fa-solid fa-heart"></i>
                </div>  
                <div>
                    <a href="/rentables/{{$listing->id}}">
                        <h1 class="card_title">{{$listing->rental_title}}</h1>
                    </a>
                    <h4 class="card_text">{{$listing->city}}, {{$listing->state}}</h4>
                </div>
                <div class="listing-tags">
                    @if($displayTags)
                        @php
                            $tags = explode(", ", $listing->tags);
                        @endphp
                        <x-listing-tags :tags="$tags" :isUtilities=false/>
                    @endif
                </div>
            @else
                <div>
                    <h4>${{$listing->rent}} / Mo| {{$listing->negotiable}}</h4>  
                    <i class="fa-solid fa-heart"></i>
                </div>  
                <div>
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
                </div>
            @endif
        </div>
    </div>
</li>