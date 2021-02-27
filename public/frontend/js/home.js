jQuery(document).ready(function() {
});
$( window ).resize(function() {
    if($( window ).width()>991&&$( window ).width()<=1220){
        $('.header-main-area .col-lg-9').addClass('col-lg-12');
        $('.header-main-area .col-lg-9').removeClass('col-lg-9');        
    }else{
        $('.header-main-area .col-lg-12').addClass('col-lg-9');
        $('.header-main-area .col-lg-12').removeClass('col-lg-12');        
    }
});
