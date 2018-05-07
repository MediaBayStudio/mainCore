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
        var height = $(".last-post-container").height();
        $('html, body').animate({
            scrollTop: target.offset().top - 40
        }, 1000);
        e.preventDefault();
        var link = $(this).attr('href');
        $('.line-post').fadeOut(500, function(){
            $(".last-post-container").height(height);
            $(this).load(link + ' .line-post', function() {
                $(this).fadeIn(500);
            });
        });
    });
});

jQuery(function($) {
    var target = $('.category--lasts');
    $('.category--line').on('click', '.pagination a', function(e){
        $('html, body').animate({
            scrollTop: target.offset().top - 90
        }, 1000);
        e.preventDefault();
        var link = $(this).attr('href');
        var height = $(".category--lasts").height();
        $('.category--line').fadeOut(500, function(){
            $(".category--lasts-wrapper").height(height);
            $(this).load(link + ' .category--line', function() {
                $(this).fadeIn(500);
            });
        });
    });
});
