<!-- Header-->
<div class="header-cont">
    <div class="header-cont-inner">
        

        
        <div id = "diagonal" class="hero-diagonal-blur">
            <div class="arrow-icon-container">
                <i class="fa-solid fa-chevron-left"></i> 
            </div>
            
        </div>
        
        <div class="card-fan">
            <div class="hero-text" id="hero-text">
                <h1><span>BUY</span> and <span>SELL</span> with other students</h1>
                <br>
                <p>Find what you need while supporting your community.</p>
            </div>
            <div class="card-fan-inner">
                <div class="header-card card1"></div>
                <div class="header-card card2"></div>
                <div class="header-card card3"></div>
                <div class="header-card card4"></div>
                <div class="header-card card5"></div>
            </div>
        </div>
    </div>  
</div> 

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>
    $(document).ready(function() {
        $( ".arrow-icon-container" ).click(function() {
            $(".hero-diagonal-blur").toggleClass("open");
            var display =  $("#hero-text").css("display");
            if(display!="none"){
                $("#hero-text").attr("style", "display:none");
            }else{
                $("#hero-text").attr("style", "display:flex");
            }
            // if(herotext.style.display == "flex"){
            //     herotext.stle.display = "none";
            // }else{
            //     herotext.stle.display = "flex";
            // }
        });

        // $(function() {
        //     $('#diagonal').addClass('open');
        // });
    });
</script><?php /**PATH C:\xampp\htdocs\CollegeMarketplace\resources\views/partials/_hero.blade.php ENDPATH**/ ?>