
<link rel="stylesheet" types ="text/css" href="/css/carouselByCategory.css">
<section class = "category-carousel-wrapper">
    <div class="category-carousel-inner">
        <ul >
            <li data-aos="slide-down" data-aos-delay="50" class="furniture-toggle" onclick="toggleDiv(1)" ><i class="fa-solid fa-couch"></i> <p>Furniture</p></li>
            <li data-aos="slide-down" data-aos-delay="100" class="clothes-toggle" onclick="toggleDiv(2)" ><i class="fa-solid fa-shirt"></i> <p>Clothes</p></li>
            <li data-aos="slide-down" data-aos-delay="150" class="electronics-toggle" onclick="toggleDiv(3)" ><i class="fa-solid fa-laptop"></i> <p>Electronics</p></li>
            <li data-aos="slide-down" data-aos-delay="200" class="kitchen-toggle" onclick="toggleDiv(4)" ><i class="fa-solid fa-kitchen-set"></i> <p>Kitchen</p></li>
            <li data-aos="slide-down"   data-aos-delay="250" class="school-toggle" onclick="toggleDiv(5)" ><i class="fa-solid fa-pen-ruler"></i> <p>School</p></li>
            <li data-aos="slide-down" data-aos-delay="300" class="books-toggle" onclick="toggleDiv(6)" ><i class="fa-solid fa-book"></i><p>Books</p></li>
        </ul>
        <div class="category-carousel-display">
            <div class="category-display type1">
                <?php echo $__env->make('partials._mixedCarousel', ['listings' => $furnitureItems, 'message' => 'Furniture Items', 'carouselClass'=>'furniture-slider','carouselControls' => 'furniture-controls', 'carouselP' =>'previous furniture-previous', 'carouselN' => 'next furniture-next'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="category-display type2">
                <?php echo $__env->make('partials._mixedCarousel', ['listings' => $clothesItems, 'message' => 'Clothes Items', 'carouselClass'=>'clothes-slider','carouselControls' => 'clothes-controls', 'carouselP' =>'previous clothes-previous', 'carouselN' => 'next clothes-next'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="category-display type3">
                <?php echo $__env->make('partials._mixedCarousel', ['listings' => $electronicsItems, 'message' => 'Electronics Items', 'carouselClass'=>'electronics-slider','carouselControls' => 'electronics-controls', 'carouselP' =>'previous electronics-previous', 'carouselN' => 'next electronics-next'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="category-display type4">
                <?php echo $__env->make('partials._mixedCarousel', ['listings' => $kitchenItems, 'message' => 'Kithchen Items', 'carouselClass'=>'kitchen-slider','carouselControls' => 'kitchen-controls', 'carouselP' =>'previous kitchen-previous', 'carouselN' => 'next kitchen-next'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="category-display type5">
                <?php echo $__env->make('partials._mixedCarousel', ['listings' => $schoolItems, 'message' => 'School Items', 'carouselClass'=>'school-slider','carouselControls' => 'school-controls', 'carouselP' =>'previous school-previous', 'carouselN' => 'next school-next'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="category-display type6">
                <?php echo $__env->make('partials._mixedCarousel', ['listings' => $bookItems, 'message' => 'Book Items', 'carouselClass'=>'book-slider','carouselControls' => 'book-controls', 'carouselP' =>'previous book-previous', 'carouselN' => 'next book-next'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
</section>

<script>

    function toggleDiv(index){
        var features = ["type1", "type2", "type3", "type4" , "type5" ,"type6"];
        var categoryToggle = ["furniture-toggle", "clothes-toggle", "electronics-toggle", "kitchen-toggle" , "school-toggle" ,"books-toggle"];

        for (var i = 0; i < features.length; i++) {
            if ((i+1) == index) {
                document.getElementsByClassName(features[i])[0].style.display = "flex";
                document.getElementsByClassName(categoryToggle[i])[0].style.color = "#db6657";
            } else {
                document.getElementsByClassName(features[i])[0].style.display = "none";
                document.getElementsByClassName(categoryToggle[i])[0].style.color = "var(--font-color-dark)";
            }
        }
    }

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
</script><?php /**PATH C:\xampp\htdocs\CollegeMarketplace\resources\views/partials/_carouselByCategory.blade.php ENDPATH**/ ?>