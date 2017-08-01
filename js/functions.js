// swiper

 window.setTimeout(function() {

    $(".logoutdiv").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 4000);

//menu in top
/*$(window).scroll(function() { 
    $(".main-nav").removeClass("menu-fixed");
    var scroll = $(window).scrollTop();
    if (scroll > 220) {
        $(".main-nav").addClass("menu-fixed");
    }
});*/

//scroll to top
 /*$(window).scroll(function() {
    if ($(this).scrollTop() > 900) {
     $('.scroll-top').fadeIn(1000);
       } else {
        $('.scroll-top').fadeOut(1000);
      }
    }); 

  $('.scroll-top').click(function(){
    $("html,body").animate({ scrollTop: 0 }, 2000);
    return false;
  });*/

//search bar
$('.search-area i').click(function(){
  $(".search-area").toggleClass("search-form-open");
});

$('.search-box .search-btn').click(function(){
  $(".search-box").toggleClass("search-form-open");
});


