{{-- the listings page serves as the homepage and extends to layout for additional footer and navigation bar --}}
@inject('controller', 'App\Http\Controllers\Controller')
<x-layout >
    {{-- main page hero section --}}
    @include('partials._hero')

    <main class = "main-listings-container">

        {{-- showing items based on category --}}
        <div class = "listings-parent-container">
            @include('partials._carouselByCategory',['furnitureItems' => $furnitureItems, 'clothesItems'=>$clothesItems, "electronicsItems"=>$electronicsItems, 'kitchenItems' => $kitchenItems, 'schoolItems' =>$schoolItems, 'bookItems'=>$bookItems, 'currentUser'=>$user])
        </div>
        
        
        <div class="listings-parent-container">
            @include('partials._componentDesignOne')
        </div>

        {{-- Show liked items if the user is logged in and has liked items--}}
        @if($user != null && $likedItems != null && count($likedItems) > 0)
            <div class="listings-parent-container">
                @include('partials._mixedCarousel', ['listings' => $likedItems, 'message' => 'Liked Items', 'carouselClass'=>'liked-items-slider','carouselControls' => 'liked-items-controls', 'carouselP' =>'previous liked-items-previous', 'carouselN' => 'next liked-items-next',
                'currentUser'=>$user, 'extraLink' => '/shop/all?type=all'])
            </div>
        @endif

        @if($recentlyViewed != null && count($recentlyViewed) > 0)
            <div class="listings-parent-container">
                @include('partials._mixedCarousel', ['listings' => $recentlyViewed, 'message' => 'Recently Viewed', 'carouselClass'=>'recently-viewed-slider','carouselControls' => 'recently-viewed-controls', 'carouselP' =>'previous recently-viewed-previous', 'carouselN' => 'next recently-viewed-next',
                'currentUser'=>$user, 'extraLink'=> '/shop/all?type=all'])
            </div>
        @endif
        

        {{-- Show listings near--}}
        @if($listingsNear != null) 
            <div class = "listings-parent-container">
                {{!! $listingsNear !!}}
            </div>
        @else
            <div class= "listings-parent-container" id="conditionalRenderNearby">

            </div>
        @endif

        {{-- carousel for rentables --}}
        <div class="listings-parent-container">
            @include('partials._rentablesCarousel',
            ['rentables'=> $rentables, 'message' => 'For Rent' , 'carouselClass' => 'slider2',
            'carouselControls' => 'controls2', 'carouselP' =>' previous previous2', 'carouselN' => 'next next2', 'currentUser'=>$user])
        </div>
        
        {{-- main card gallery for items posted within the last 24hrs --}}
        <div class = "listings-parent-container">
            @include('partials._cardGallary', ['listings' => $listings, 'heading'=>'Recently Added', 'displayTags' => true, 'displayMoreButton' => true,
            'currentUser' => $user])
        </div>

        {{-- carousel for subleases --}}
        <div class="listings-parent-container">
            @include('partials._subleaseCarousel',
            ['subleases'=> $subleases, 'message' => 'Places For Leasing' , 'carouselClass' => 'slider3',
            'carouselControls' => 'controls3', 'carouselP' =>' previous previous3', 'carouselN' => 'next next3', 'currentUser' => $user])
        </div>
    </main>

    <script>

        var likedItems = {!! json_encode(array_values($likedItems)) !!};
        var recentlyViewed = {!! json_encode(array_values($recentlyViewed)) !!};
        var listingsNear = {!! json_encode($listingsNear) !!};
        var createTns = false;

        if(likedItems.length>0){
            tns({
                container: ".liked-items-slider",
                "slideBy":1,
                "speed":400,
                "nav":false,
                autoplayButton: false,
                autoplay: true,
                autoplayText:["",""],
                controlsContainer:"#liked-items-controls",
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

        if(recentlyViewed.length>0){
            tns({
                container: ".recently-viewed-slider",
                "slideBy":1,
                "speed":400,
                "nav":false,
                autoplayButton: false,
                autoplay: true,
                autoplayText:["",""],
                controlsContainer:"#recently-viewed-controls",
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

        if(listingsNear != null || createTns){
             tns({
                container: ".nearby-items-slider",
                "slideBy":1,
                "speed":400,
                "nav":false,
                autoplayButton: false,
                autoplay: true,
                autoplayText:["",""],
                controlsContainer:"#nearby-items-controls",
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


        // ---------------------------------------------------------------
        // User Location related functions to show nearby items
        // ---------------------------------------------------------------

        navigator.permissions.query({ name: 'geolocation' }).then((permissionStatus) => {
        permissionStatus.onchange = () => {
            // console.log(permissionStatus.state);
            showNearbyItemsCarousel();
            };
        });

        showNearbyItemsCarousel();
        function showNearbyItemsCarousel(){
            //CASE 1:
            //  if the user is not logged in
            if("{{$user == null}}") {
                navigator.permissions.query({ name: 'geolocation' }).then((result) => {
                    //CASE 1: 
                    //  try to get the user's current location
                    //  if location feature is allowed, call the getLocation() method which will perform an ajax query, then generate a coursel on the main page
                    if (result.state === 'granted') {
                        getLocation();

                    //CASE 2:
                    //  the user is not logged in, we can't check their location on file, also not given permission to retrieve user's location
                    //in this scenario, we do not show a nearby-carousel at all.
                    }else if (result.state === 'denied') {
                        // console.log('came to the bottom one');
                        $("#conditionalRenderNearby").empty();
                    }
                });
             
            //CASE 2:
            //  if the user is logged in
            }else{
                var currentUser = {!!json_encode(auth()->user())!!}
                //CASE 1: 
                //  if the user is logged in and has lat and long in the db
                //  Done: if this is the case, then the carousel will auto generate without us needing to do anything.
                if(currentUser.latitude != null && currentUser.longitude != null){
                    //the carousel will be auto generated. 
                    
                //CASE 2:
                //  if the user is logged in and there is no lat/long in db and we are allowed to get current location
                //  once we get permission, the user's location will be put in the db so we can reload the page to auto genearte the nearbycarousel with items
                }else{
                    //this is whats essentially happening but we run the following line in the ajax response code once we successfully update the db.
                    //after reloading, the carousel will be auto generated.
                    //location.reload();
                }
                //CASE 3:
                //  if the user is logged in and ther eis not lat/long in the db.
                //  we are also not allowed to extract the users location.
                //  in this scenario, we don't show a nearby items carousel at all

            }        
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
                    // console.log("Listings near the user: ", data.html);
                    createTns = true;
                    $("#conditionalRenderNearby").html(data.html);
                    tns({
                        container: ".nearby-items-slider",
                        "slideBy":1,
                        "speed":400,
                        "nav":false,
                        autoplayButton: false,
                        autoplay: true,
                        autoplayText:["",""],
                        controlsContainer:"#nearby-items-controls",
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
                    // console.log(data);
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