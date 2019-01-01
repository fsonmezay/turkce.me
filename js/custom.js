function scrollAction() {
  var scrollValue = $(this).scrollTop();
  if (scrollValue > 50) {
      $('#mysiteNav').addClass('navbar-white');
      $('#mysiteNav').removeClass('navbar-default');
      $('.bg-overlay').css('background-color', 'rgba(33,33,33,' +  (0.17 + (scrollValue / 1000)) + ')');
  }
  else {
      $('#mysiteNav').addClass('navbar-default');
      $('#mysiteNav').removeClass('navbar-white');
      $('.bg-overlay').css('background-color', 'rgba(33,33,33,0.1)');
  }

  $('.paralax').each(function(){
    var $bgobj = $(this);
    var yPos = -(scrollValue / 3);
    var coords = 'center '+ yPos + 'px';
    $bgobj.css({
      backgroundPosition: coords
    });
  });

}

$(document).scroll(function() {
  scrollAction();
});

$(document).ready(function(){
  scrollAction();
});

//jQuery for page scrolling feature - requires jQuery Easing plugin
$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top+1)
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });
});
