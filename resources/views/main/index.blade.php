{{-- the listings page serves as the homepage and extends to layout for additional footer and navigation bar --}}
@inject('controller', 'App\Http\Controllers\Controller')
<x-layout >
    {{-- main page hero section --}}
    @include('partials._hero')

    <main class = "main-listings-container">

        {{-- showing items based on category --}}
        <div class = "listings-parent-container">
            @include('partials._carouselByCategory',['furnitureItems' => $furnitureItems, 'clothesItems'=>$clothesItems, "electronicsItems"=>$electronicsItems, 'kitchenItems' => $kitchenItems, 'schoolItems' =>$schoolItems, 'bookItems'=>$bookItems])
        </div>

        {{-- Showing items based on distance--}}
        
        @if(!empty($listingsNear)) 
            <div class = "listings-parent-container">
                @include('partials._listingCarousel', ['listings' => $listingsNear, 'message' => 'Within A Mile', 'carouselClass'=>'my-slider','carouselControls' => 'controls', 'carouselP' =>'previous previous1', 'carouselN' => 'next next1'])
            </div>
        @else 
        @endif
        <div class="listings-parent-container">
            @include('partials._componentDesignOne')
        </div>
        {{-- carousel for rentables --}}
        <div class="listings-parent-container">
            @include('partials._rentablesCarousel',
            ['rentables'=> $rentables, 'message' => 'For Rent' , 'carouselClass' => 'slider2',
            'carouselControls' => 'controls2', 'carouselP' =>' previous previous2', 'carouselN' => 'next next2'])
        </div>
        
        {{-- main card gallery for items posted within the last 24hrs --}}
        <div class = "listings-parent-container">
            @include('partials._cardGallary', ['listings' => $listings, 'heading'=>'Items Recently Added', 'displayTags' => true, 'displayMoreButton' => true])
        </div>

        {{-- carousel for subleases --}}
        <div class="listings-parent-container">
            @include('partials._subleaseCarousel',
            ['subleases'=> $subleases, 'message' => 'Places For Leasing' , 'carouselClass' => 'slider3',
            'carouselControls' => 'controls3', 'carouselP' =>' previous previous3', 'carouselN' => 'next next3'])
        </div>
    </main>

    <script>
        if("{{$user == null}}") {
            getLocation();
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition,showError,options);
            } else { 
                console.log("location not supported")
            }
        }

        function showPosition(position) {
            //console.log(position.coords.latitude+" "+position.coords.longitude);
            getListings(position.coords.latitude,position.coords.longitude);
        }

        function showError(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    console.log("User denied the request for Geolocation.");
                break;
                case error.POSITION_UNAVAILABLE:
                    console.log("Location information is unavailable.");
                break;
                case error.TIMEOUT:
                    console.log( "The request to get user location timed out.");
                break;
                case error.UNKNOWN_ERROR:
                    console.log( "An unknown error occurred.");
                break;
            }
        }

        var options = {
            enableHighAccuracy: true,
            timeout: 1000,
            maximumAge: 0
        };

        /*$(document).ready(function(){
                $(window).on("load",function(){
                    getLocation();
                });
        });*/

        //function to get proximate listings after getting location 
        function getListings(latitude,longitude){
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            $.ajax({
                type:'GET',
                url: '/item?latitude='+latitude+'&longitude='+longitude,
                data: 'JSON',
                cache: false, //look into caching later
                success:function(data) {
                    console.log(data);
                    //add your success handling here
                },
                error: function (data, textStatus, errorThrown) {
                    console.log("failed");
                    //add your failed handling here
                },
            });
        }
    </script>
</x-layout>