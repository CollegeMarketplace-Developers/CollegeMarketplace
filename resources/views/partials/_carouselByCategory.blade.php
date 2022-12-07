{{-- css for the category specific carousel --}}
<link rel="stylesheet" types ="text/css" href="/css/carouselByCategory.css">
<section class = "category-carousel-wrapper">
    <div class="category-carousel-inner">
        <ul>
            <div class='single-category-box' >
                <li class="furniture-toggle" onclick="toggleDiv(1)"></li>
                <span onclick="toggleDiv(1)">Furniture</span>
            </div>
            <div class='single-category-box'>
                <li class="clothes-toggle" onclick="toggleDiv(2)"></li>
                <span onclick="toggleDiv(2)">Clothes</span>
            </div>
             <div class='single-category-box'>
                <li class="electronics-toggle" onclick="toggleDiv(3)"></li>
                <span onclick="toggleDiv(3)">Electronics</span>
            </div>
            <div class='single-category-box'>
                <li class="kitchen-toggle" onclick="toggleDiv(4)"></li>
                <span onclick="toggleDiv(4)">Kitchen</span>
            </div>
            <div class='single-category-box'>
                <li class="school-toggle" onclick="toggleDiv(5)"></li>
                <span onclick="toggleDiv(5)">School</span>
            </div>
            <div class='single-category-box'>
                <li class="books-toggle" onclick="toggleDiv(6)"></li>
                <span onclick="toggleDiv(6)">Books</span>
            </div>
            <div class='single-category-box'>
                <li class="lease-toggle" onclick="toggleDiv(7)"></li>
                <span onclick="toggleDiv(7)">Subleases</span>
            </div>

            {{-- <li class="furniture-toggle" onclick="toggleDiv(1)" ><i class="fa-solid fa-couch"></i> <p>Furniture</p></li>
            <li class="clothes-toggle" onclick="toggleDiv(2)" ><i class="fa-solid fa-shirt"></i> <p>Clothes</p></li>
            <li class="electronics-toggle" onclick="toggleDiv(3)" ><i class="fa-solid fa-laptop"></i> <p>Electronics</p></li>
            <li class="kitchen-toggle" onclick="toggleDiv(4)" ><i class="fa-solid fa-kitchen-set"></i> <p>Kitchen</p></li>
            <li class="school-toggle" onclick="toggleDiv(5)" ><i class="fa-solid fa-pen-ruler"></i> <p>School</p></li>
            <li class="books-toggle" onclick="toggleDiv(6)" ><i class="fa-solid fa-book"></i><p>Books</p></li> --}}
        </ul>

        <div class="category-carousel-display">
            <div class="category-display type1">
                @include('partials._mixedCarousel', ['listings' => $furnitureItems, 'message' => 'Furniture Items', 'carouselClass'=>'furniture-slider','carouselControls' => 'furniture-controls', 'carouselP' =>'previous furniture-previous', 'carouselN' => 'next furniture-next',
                'currentUser'=>$currentUser, 'extraLink' => '/shop/all?type=all&category=furniture'])
            </div>
            <div class="category-display type2">
                @include('partials._mixedCarousel', ['listings' => $clothesItems, 'message' => 'Clothes Items', 'carouselClass'=>'clothes-slider','carouselControls' => 'clothes-controls', 'carouselP' =>'previous clothes-previous', 'carouselN' => 'next clothes-next',
                'currentUser'=>$currentUser, 'extraLink' => '/shop/all?type=all&category=clothes'])
            </div>
            <div class="category-display type3">
                @include('partials._mixedCarousel', ['listings' => $electronicsItems, 'message' => 'Electronics Items', 'carouselClass'=>'electronics-slider','carouselControls' => 'electronics-controls', 'carouselP' =>'previous electronics-previous', 'carouselN' => 'next electronics-next',
                'currentUser'=>$currentUser, 'extraLink' => '/shop/all?type=all&category=electronics'])
            </div>
            <div class="category-display type4">
                @include('partials._mixedCarousel', ['listings' => $kitchenItems, 'message' => 'Kitchen Items', 'carouselClass'=>'kitchen-slider','carouselControls' => 'kitchen-controls', 'carouselP' =>'previous kitchen-previous', 'carouselN' => 'next kitchen-next',
                'currentUser'=>$currentUser, 'extraLink' => '/shop/all?type=all&category=kitchen'])
            </div>
            <div class="category-display type5">
                @include('partials._mixedCarousel', ['listings' => $schoolItems, 'message' => 'School Items', 'carouselClass'=>'school-slider','carouselControls' => 'school-controls', 'carouselP' =>'previous school-previous', 'carouselN' => 'next school-next',
                'currentUser'=>$currentUser, 'extraLink' => '/shop/all?type=all&category=school%20accessories'])
            </div>
            <div class="category-display type6">
                @include('partials._mixedCarousel', ['listings' => $bookItems, 'message' => 'Book Items', 'carouselClass'=>'book-slider','carouselControls' => 'book-controls', 'carouselP' =>'previous book-previous', 'carouselN' => 'next book-next',
                'currentUser'=>$currentUser, 'extraLink' => '/shop/all?type=all&category=books'])
            </div>
            <div class="category-display type7">
                @include('partials._mixedCarousel', ['listings' => $leaseItems, 'message' => 'Lease Items', 'carouselClass'=>'lease-slider','carouselControls' => 'lease-controls', 'carouselP' =>'previous lease-previous', 'carouselN' => 'next lease-next',
                'currentUser'=>$currentUser, 'extraLink' => '/shop/all?type=lease'])
            </div>
        </div>
    </div>
</section>

<script>

    function toggleDiv(index){
        var features = ["type1", "type2", "type3", "type4" , "type5" ,"type6", "type7"];
        // var categoryToggle = ["furniture-toggle", "clothes-toggle", "electronics-toggle", "kitchen-toggle" , "school-toggle" ,"books-toggle", "lease-toggle"];
        console.log(document.getElementsByClassName("type7")[0])
        for (var i = 0; i < features.length; i++) {
            console.log(features[i]);
            if ((i+1) == index) {
                document.getElementsByClassName(features[i])[0].style.display = "flex";
                // document.getElementsByClassName(categoryToggle[i])[0].style.color = "#db6657";
            } else {
                document.getElementsByClassName(features[i])[0].style.display = "none";
                // document.getElementsByClassName(categoryToggle[i])[0].style.color = "var(--font-color-dark)";
            }
        }
    }
    var furnitureArray =  @json(array_values($furnitureItems), JSON_PRETTY_PRINT) ;
    var clothesArray =  {!! json_encode(array_values($clothesItems)) !!};
    var electronicsArray = {!! json_encode(array_values($electronicsItems)) !!};
    var kitchenArray =  {!! json_encode(array_values($kitchenItems)) !!};
    var schoolArray =  {!! json_encode(array_values($schoolItems)) !!};
    var bookArray =  {!! json_encode(array_values($bookItems)) !!};
    var leaseArray =  {!! json_encode(array_values($leaseItems)) !!};


    

    // console.log("furniture items: ", furnitureArray.length, furnitureArray);
    // console.log("clothes items: " , clothesArray.length, clothesArray);
    // console.log("electronics items: ",  electronicsArray.length, electronicsArray);
    // console.log("kitchen items: " , kitchenArray.length, kitchenArray);
    // console.log("school items: " , schoolArray.length, schoolArray);
    // console.log("book items: " , bookArray.length, bookArray);

    if(furnitureArray.length>0){
        tns({
            container: ".furniture-slider",
            "slideBy":1,
            "speed":400,
            "nav":false,
            autoplayButton: false,
            autoplay: true,
            autoplayText:["",""],
            controlsContainer:"#furniture-controls",
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
    if(clothesArray.length>0){
        tns({
            container: ".clothes-slider",
            "slideBy":1,
            "speed":400,
            "nav":false,
            autoplayButton: false,
            autoplay: true,
            autoplayText:["",""],
            controlsContainer:"#clothes-controls",
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
    if(electronicsArray.length>0){
        tns({
            container: ".electronics-slider",
            "slideBy":1,
            "speed":400,
            "nav":false,
            autoplayButton: false,
            autoplay: true,
            autoplayText:["",""],
            controlsContainer:"#electronics-controls",
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
    if(kitchenArray.length > 0){
        tns({
            container: ".kitchen-slider",
            "slideBy":1,
            "speed":400,
            "nav":false,
            autoplayButton: false,
            autoplay: true,
            autoplayText:["",""],
            controlsContainer:"#kitchen-controls",
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
    if(schoolArray.length > 0){
        tns({
            container: ".school-slider",
            "slideBy":1,
            "speed":400,
            "nav":false,
            autoplayButton: false,
            autoplay: true,
            autoplayText:["",""],
            controlsContainer:"#school-controls",
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
    if(bookArray.length > 0){
        tns({
            container: ".book-slider",
            "slideBy":1,
            "speed":400,
            "nav":false,
            autoplayButton: false,
            autoplay: true,
            autoplayText:["",""],
            controlsContainer:"#book-controls",
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
    if(leaseArray.length > 0){
        tns({
            container: ".lease-slider",
            "slideBy":1,
            "speed":400,
            "nav":false,
            autoplayButton: false,
            autoplay: true,
            autoplayText:["",""],
            controlsContainer:"#lease-controls",
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