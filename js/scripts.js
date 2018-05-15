// Menuzord Properties

jQuery(document).ready(function(){
    jQuery("#menuzord").menuzord();
    jQuery('.owl-carousel').owlCarousel({
      loop:true, //Зацикливаем слайдер
      dots:false,
      items:1,
      nav:true,
      navText: ["<i class=\"fa fa-chevron-left\"></i>", "<i class=\"fa fa-chevron-right\"></i>"],
      autoplayHoverPause:true,
      autoplay:true, //Автозапуск слайдера
      smartSpeed:2000, //Время движения слайда
      animateIn: 'fadeIn'
    });
});



// Ajax Pagination

jQuery(function($) {
    $('.last-post-container').on('click', '.pagination a', function(e){
        var height = $(".line--posts").height();
        $('html, body').animate({
            scrollTop: $('.last-post-container').offset().top - 40
        }, 1000);
        e.preventDefault();
        var link = $(this).attr('href');
        $('.last-post-container').fadeOut(500, function(){
            $(".line--posts").height(height+50);
            $(this).load(link + ' .last-post-container', function() {
                $(this).fadeIn(500);
            });
        });
    });
});

jQuery(function($) {
    $('.cat-last-post-wrapper').on('click', '.pagination a', function(e){
        $('html, body').animate({
            scrollTop: $('.cat-last-post-wrapper').offset().top - 20
        }, 1000);
        e.preventDefault();
        var link = $(this).attr('href');
        $('.cat-last-post-wrapper').fadeOut(500, function(){
            $(this).load(link + ' .line-post__container', function() {
                $(this).fadeIn(500);
            });
        });
    });
});
