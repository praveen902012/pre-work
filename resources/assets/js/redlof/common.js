function RedlofCommonSetting() {
  $('input').iCheck({
    checkboxClass: 'icheckbox_flat-red',
    radioClass: 'iradio_flat-red',
    increaseArea: '20%' // optional
  });
  $('#password-input').showPassword('focus', {
    toggle: {
      className: 'pwd-show-hide-toggle'
    }
  });
  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });
}
$(document).ready(function() {
  /* Mobile Slider Menu */
  var sideslider = $('[data-toggle=collapse-side]');
  var clicked = false;
  $(document).ready(function() {
    sideslider.click(function(event) {
      clicked = !clicked;
      $(".side-collapse").toggleClass("in");
      event.stopPropagation();
    });
    $('#close_menu').click(function(e) {
      e.preventDefault();
      $('.side-collapse').removeClass("in");
      clicked = !clicked;
    });
  });
  /* Mobile Menu Ends */
  $(".textinput input").change(function() {
    if ($(this).val() !== "") {
      $(this).addClass('filled');
    } else {
      $(this).removeClass('filled');
    }
  });
});


$(function() {
  var windowWidth = $(window).width();
  if (windowWidth < 768) {
    // slimscroll
    $('#story-list').slimScroll({
      height: '216px',
      color: '#ffc108',
      opacity: 1,
      alwaysVisible: true,
      railVisible: true,
      railColor: '#ededeb',
      railOpacity: 1,
      allowPageScroll: true
    });
  } else {
    $('#story-list').slimScroll({
      height: '416px',
      color: '#C4161C',
      opacity: 1,
      alwaysVisible: true,
      railVisible: true,
      railColor: '#ededeb',
      railOpacity: 1,
      allowPageScroll: true
    });
  }
});


$('#template-list').slimScroll({
  height: '416px',
  color: '#C4161C',
  opacity: 1,
  alwaysVisible: true,
  railVisible: true,
  railColor: '#ededeb',
  railOpacity: 1,
  allowPageScroll: true
});


$('#temp_lt').slimScroll({
  height: 'auto',
  color: 'rgb(189, 189, 189)',
  opacity: 1,
  alwaysVisible: true,
  railVisible: true,
  railColor: '#ededeb',
  railOpacity: 1,
  allowPageScroll: true

});

$('#temp_rt').slimScroll({
  height: 'auto',
  color: 'rgb(189, 189, 189)',
  opacity: 1,
  alwaysVisible: true,
  railVisible: true,
  railColor: '#ededeb',
  railOpacity: 1,
  allowPageScroll: true,

});
$('#rte_users').slimScroll({
  height: '325px'
});
$('.dropdown').on('show.bs.dropdown', function(e) {
  $(this).find('.dropdown-menu').first().stop(true, true).slideDown(200);
});
$('.dropdown').on('hide.bs.dropdown', function(e) {
  $(this).find('.dropdown-menu').first().stop(true, true).slideUp(300);
});

$(window).on('load', function() {
  createSticky($(".fixedTop"));
});

$(window).on('load', function() {
  $('.press-flexslider').flexslider({
    animation: "slide",
    controlNav: false,
    start: function() {
      $('.press-slide').show();
    },
    controlsContainer: $(".custompress-controls-container"),
    customDirectionNav: $(".custompress-navigation a"),
  });
});

function createSticky(sticky) {
  if (typeof sticky !== "undefined") {
    if (sticky.length) {
      var pos = sticky.offset().top - 200;
      $(window).on("scroll", function() {
        if ($(window).scrollTop() >= pos) {
          sticky.addClass("fixed-pos");
          $('.category-banner').addClass('sticky-profile-banner') && $('.category-content').addClass('scroll-content');
        } else {
          sticky.removeClass("fixed-pos");
          $('.category-banner').removeClass('sticky-profile-banner') && $('.category-content').removeClass('scroll-content');
        }
      });
    }
  }
}