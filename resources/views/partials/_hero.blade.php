<!-- Header-->
<div class="header-cont">
    <div class="header-cont-inner">
        {{-- open --}}
        <div id = "diagonal" class="hero-diagonal-blur">
            <div class="arrow-icon-container">
                <i class="fa-solid fa-chevron-left"></i> 
            </div>
            <div class="countPlusRecent">

            </div>
        </div>
    </div>  
</div> 

<script>
    $(document).ready(function() {
        $( ".arrow-icon-container" ).click(function() {
            $(".hero-diagonal-blur").toggleClass("open");
        });

        $(function() {
            $('#diagonal').addClass('open');
        });
    });
</script>