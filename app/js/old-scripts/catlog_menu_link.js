/*------------------------------
Script to handle the catalog-menu
click and hover events
--------------------------------*/
$(".main-catalog-link").click(function(){
    if($(window).width() > 640){
        if($(".front-left").css('display') == 'none' ){
            $(".front-left").css('display', 'block' );
        }
        else{
            $(".front-left").css('display', 'none');
        }
        if($(".not-home-page").css('display') == 'none' ){
            $(".not-home-page").css('display', 'block' );
        }
        else{
            $(".not-home-page").css('display', 'none');
        }
    }
});


$(".main-catalog-link").mouseover(function(){
            $(".not-home-page").css('display', 'block');
            $(".front-left").css('display', 'block' );
});


$(".main-catalog-link-mobile").click(function(){
       if($(".front-left").css('display') == 'none' ){
           $(".front-left").css('display', 'block' );
       }
       else{
           $(".front-left").css('display', 'none');
       }

   if($(window).width() < 640){
       if($(".not-home-page").css('display') == 'none' ){
           $(".not-home-page").css('display', 'block' );
       }
       else{
           $(".not-home-page").css('display', 'none');
       }
    }
});

$(".front-left").mouseleave(function(){
    $(".not-home-page").css('display', 'none');
    $(".front-left").css('display', 'none' );
});
