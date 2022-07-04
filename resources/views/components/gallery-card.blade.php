@props(['listing', 'displayTags'])
<li class="cards_item" data-aos="zoom-in" data-aos-once="true">
    <div class="card-type">
        @if($listing instanceof \App\Models\Listing)
        <div class="card-type-inner sale-border">
            <h5>For Sale</h5>
        </div>
        @elseif($listing instanceof \App\Models\Rentable)
        <div class="card-type-inner rent-border">
            <h5>For Rent</h5>
        </div>
        @else
        <div class="card-type-inner lease-border">
            <h5>For Lease</h5>
        </div>
        @endif
    </div>
    <div class="card"> 
        <div class="card_image">
            @if($listing instanceof \App\Models\Listing)
            {{-- <span class="ribbon ribbon-listing">{{$listing->status}}</span> --}}
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
                            $imgLinks = json_decode($listing->image_uploads);
                            if(is_array($imgLinks)){
                                $imgLinks = $imgLinks[0];
                                if(file_exists(public_path('storage/'.$imgLinks))){
                                    $imgLinks = "storage/".$imgLinks;
                                }else{
                                    $imgLinks = "/images/rotunda.jpg";
                                }
                            }else{
                                 $imgLinks = "/images/rotunda.jpg";
                            }
                        }else{
                            $imgLinks = "/images/rotunda.jpg";
                        }
                    @endphp
                    <img src={{asset($imgLinks) }}  alt="title image">
                </a>
            @elseif($listing instanceof \App\Models\Rentable)
            {{-- <span class="ribbon ribbon-rental">{{$listing->status}}</span> --}}
                @if($listing->status =='Available')
                    <div class="status green">
                    </div>
                @else
                    <div class="status">
                    </div>
                @endif
                <a href="/rentables/{{$listing->id}}">
                    @php
                    $imgLinks = null;
                        if(isset($listing->image_uploads)){
                            $imgLinks = json_decode($listing->image_uploads);
                            if(is_array($imgLinks)){
                                $imgLinks = $imgLinks[0];
                            }
                        }
                    @endphp
                    <img src={{$listing->image_uploads ?asset('storage/'.$imgLinks) : asset('/images/rotunda.jpg') }}  alt="image doesnt exist">
                </a>
            @else
                {{-- <span class="ribbon ribbon-lease">{{$listing->status}}</span> --}}
                @if($listing->status =='Available')
                    <div class="status green">
                    </div>
                @else
                    <div class="status">
                    </div>
                @endif
                <a href="/subleases/{{$listing->id}}">
                    @php
                    $imgLinks = null;
                        if(isset($listing->image_uploads)){
                            $imgLinks = json_decode($listing->image_uploads);
                            if(is_array($imgLinks)){
                                $imgLinks = $imgLinks[0];
                            }
                        }
                    @endphp
                    <img src={{$listing->image_uploads ?asset('storage/'.$imgLinks) : asset('/images/rotunda.jpg') }}  alt="image doesnt exist">
                </a>
            @endif
        </div>
        <div class="card_content">
            @if($listing instanceof \App\Models\Listing)
                <a href="/listings/{{$listing->id}}">
                <h1 class="card_title">{{$listing->item_name}}</h1>
                </a>
                <h4>${{$listing->price}}</h4>
                <h4 class="card_text">{{$listing->city}}, {{$listing->state}}</h4>
                <div class="listing-tags">
                    @if($displayTags)
                        @php
                            $tags = explode(", ", $listing->tags);
                        @endphp
                        <x-listing-tags :tags="$tags"/>
                    @endif
                </div>
            @elseif($listing instanceof \App\Models\Rentable)
                <a href="/rentables/{{$listing->id}}">
                <h1 class="card_title">{{$listing->rental_title}}</h1>
                </a>
                <h4>${{$listing->rental_charging}} / {{$listing->rental_duration}}</h4>
                <h4 class="card_text">{{$listing->city}}, {{$listing->state}}</h4>
                <div class="listing-tags">
                    @if($displayTags)
                        @php
                            $tags = explode(", ", $listing->tags);
                        @endphp
                        <x-listing-tags :tags="$tags"/>
                    @endif
                </div>
            @else
                <a href="/subleases/{{$listing->id}}">
                <h1 class="card_title">{{$listing->sublease_title}}</h1>
                </a>
                <h4>${{$listing->rent}} | {{$listing->negotiable}}</h4>
                <h4 class="card_text">{{$listing->city}}, {{$listing->state}}</h4>
                <div class="listing-tags">
                    @if($displayTags)
                        @php
                            $tags = explode(", ", $listing->tags);
                        @endphp
                        <x-listing-tags :tags="$tags"/>
                    @endif
                </div>
            @endif
        </div> 
    </div>
</li>