/*! RedlofDashboard app.js
 * ================
 * Main JS application file for RedlofDashboard v2. This file
 * should be included in all pages. It controls some layout
 * options and implements exclusive RedlofDashboard plugins.
 */

//Make sure jQuery has been loaded before app.js
if ( typeof jQuery === "undefined" ) {
  throw new Error( "Redlof Admin Dashboard needs jQuery" );
}

/* RedlofDashboard
 *
 * @type Object
 * @description $.RedlofDashboard is the main object for the template's app.
 *              It's used for implementing functions and options related
 *              to the template. Keeping everything wrapped in an object
 *              prevents conflict with other plugins and is a better
 *              way to organize our code.
 */
$.RedlofDashboard = {};

/* --------------------
 * - RedlofDashboard Options -
 * --------------------
 * Modify these options to suit your implementation
 */
$.RedlofDashboard.options = {
  //Add slimscroll to navbar menus
  //This requires you to load the slimscroll plugin
  //in every page before app.js
  navbarMenuSlimscroll: true,
  navbarMenuSlimscrollWidth: "3px", //The width of the scroll bar
  navbarMenuHeight: "200px", //The height of the inner menu
  //General animation speed for JS animated elements such as box collapse/expand and
  //sidebar treeview slide up/down. This options accepts an integer as milliseconds,
  //'fast', 'normal', or 'slow'
  animationSpeed: 300,
  //Sidebar push menu toggle button selector
  sidebarToggleSelector: "[data-toggle='offcanvas']",
  //Activate sidebar push menu
  sidebarPushMenu: true,
  //Activate sidebar slimscroll if the fixed layout is set (requires SlimScroll Plugin)
  sidebarSlimScroll: true,
  //Enable sidebar expand on hover effect for sidebar mini
  //This option is forced to true if both the fixed layout and sidebar mini
  //are used together
  sidebarExpandOnHover: false,
  //Bootstrap.js tooltip
  enableBSToppltip: true,
  BSTooltipSelector: "[data-toggle='tooltip']",
  //Enable Fast Click. Fastclick.js creates a more
  //native touch experience with touch devices. If you
  //choose to enable the plugin, make sure you load the script
  //before RedlofDashboard's app.js
  //Control Sidebar Options
  enableControlSidebar: true,
  controlSidebarOptions: {
    //Which button should trigger the open/close event
    toggleBtnSelector: "[data-toggle='control-sidebar']",
    //The sidebar selector
    selector: ".control-sidebar",
    //Enable slide over content
    slide: true
  },

  //Define the set of colors to use globally around the website
  colors: {
    lightBlue: "#3c8dbc",
    red: "#f56954",
    green: "#00a65a",
    aqua: "#00c0ef",
    yellow: "#f39c12",
    blue: "#0073b7",
    navy: "#001F3F",
    teal: "#39CCCC",
    olive: "#3D9970",
    lime: "#01FF70",
    orange: "#FF851B",
    fuchsia: "#F012BE",
    purple: "#8E24AA",
    maroon: "#D81B60",
    black: "#222222",
    gray: "#d2d6de"
  },
  //The standard screen sizes that bootstrap uses.
  //If you change these in the variables.less file, change
  //them here too.
  screenSizes: {
    xs: 480,
    sm: 768,
    md: 992,
    lg: 1200
  }
};

/* ----------------------------------
 * - Initialize the RedlofDashboard Object -
 * ----------------------------------
 * All RedlofDashboard functions are implemented below.
 */
function _init() {
  'use strict';
  /* Layout
   * ======
   * Fixes the layout height in case min-height fails.
   *
   * @type Object
   * @usage $.RedlofDashboard.layout.activate()
   *        $.RedlofDashboard.layout.fix()
   *        $.RedlofDashboard.layout.fixSidebar()
   */
  $.RedlofDashboard.layout = {
    activate: function () {
      var _this = this;
      _this.fix();
      _this.fixSidebar();
      $( window, ".wrapper" ).resize( function () {
        _this.fix();
        _this.fixSidebar();
      } );
    },
    fix: function () {
      //Get window height and the wrapper height
      var neg = $( '.main-header' ).outerHeight() + $( '.main-footer' ).outerHeight();
      var window_height = $( window ).height();
      var sidebar_height = $( ".sidebar" ).height();
      //Set the min-height of the content and sidebar based on the
      //the height of the document.
      if ( $( "body" ).hasClass( "fixed" ) ) {
        $( ".content-wrapper, .right-side" ).css( 'min-height', window_height - $( '.main-footer' ).outerHeight() );
      } else {
        var postSetWidth;
        if ( window_height >= sidebar_height ) {
          $( ".content-wrapper, .right-side" ).css( 'min-height', window_height - neg );
          postSetWidth = window_height - neg;
        } else {
          $( ".content-wrapper, .right-side" ).css( 'min-height', sidebar_height );
          postSetWidth = sidebar_height;
        }

        //Fix for the control sidebar height
        var controlSidebar = $( $.RedlofDashboard.options.controlSidebarOptions.selector );
        if ( typeof controlSidebar !== "undefined" ) {
          if ( controlSidebar.height() > postSetWidth )
            $( ".content-wrapper, .right-side" ).css( 'min-height', controlSidebar.height() );
        }

      }
    },
    fixSidebar: function () {
      //Make sure the body tag has the .fixed class
      if ( !$( "body" ).hasClass( "fixed" ) ) {
        if ( typeof $.fn.slimScroll != 'undefined' ) {
          $( ".sidebar" ).slimScroll( {
            destroy: true
          } ).height( "auto" );
        }
        return;
      } else if ( typeof $.fn.slimScroll == 'undefined' && window.console ) {
        window.console.error( "Error: the fixed layout requires the slimscroll plugin!" );
      }
      //Enable slimscroll for fixed layout
      if ( $.RedlofDashboard.options.sidebarSlimScroll ) {
        if ( typeof $.fn.slimScroll != 'undefined' ) {
          //Destroy if it exists
          $( ".sidebar" ).slimScroll( {
            destroy: true
          } ).height( "auto" );
          //Add slimscroll
          $( ".sidebar" ).slimscroll( {
            height: ( $( window ).height() - $( ".main-header" ).height() ) + "px",
            color: "rgba(0,0,0,0.2)",
            size: "3px"
          } );
        }
      }
    }
  };

  /* PushMenu()
   * ==========
   * Adds the push menu functionality to the sidebar.
   *
   * @type Function
   * @usage: $.RedlofDashboard.pushMenu("[data-toggle='offcanvas']")
   */
  $.RedlofDashboard.pushMenu = {
    activate: function ( toggleBtn ) {
      //Get the screen sizes
      var screenSizes = $.RedlofDashboard.options.screenSizes;

      //Enable sidebar toggle
      $( toggleBtn ).on( 'click', function ( e ) {
        e.preventDefault();

        //Enable sidebar push menu
        if ( $( window ).width() > ( screenSizes.sm - 1 ) ) {
          if ( $( "body" ).hasClass( 'sidebar-collapse' ) ) {
            $( "body" ).removeClass( 'sidebar-collapse' ).trigger( 'expanded.pushMenu' );
          } else {
            $( "body" ).addClass( 'sidebar-collapse' ).trigger( 'collapsed.pushMenu' );
          }
        }
        //Handle sidebar push menu for small screens
        else {
          if ( $( "body" ).hasClass( 'sidebar-open' ) ) {
            $( "body" ).removeClass( 'sidebar-open' ).removeClass( 'sidebar-collapse' ).trigger( 'collapsed.pushMenu' );
          } else {
            $( "body" ).addClass( 'sidebar-open' ).trigger( 'expanded.pushMenu' );
          }
        }
      } );

      $( ".content-wrapper" ).click( function () {
        //Enable hide menu when clicking on the content-wrapper on small screens
        if ( $( window ).width() <= ( screenSizes.sm - 1 ) && $( "body" ).hasClass( "sidebar-open" ) ) {
          $( "body" ).removeClass( 'sidebar-open' );
        }
      } );

      //Enable expand on hover for sidebar mini
      if ( $.RedlofDashboard.options.sidebarExpandOnHover || ( $( 'body' ).hasClass( 'fixed' ) && $( 'body' ).hasClass( 'sidebar-mini' ) ) ) {
        this.expandOnHover();
      }
    },
    expandOnHover: function () {
      var _this = this;
      var screenWidth = $.RedlofDashboard.options.screenSizes.sm - 1;
      //Expand sidebar on hover
      $( '.main-sidebar' ).hover( function () {
        if ( $( 'body' ).hasClass( 'sidebar-mini' ) && $( "body" ).hasClass( 'sidebar-collapse' ) && $( window ).width() > screenWidth ) {
          _this.expand();
        }
      }, function () {
        if ( $( 'body' ).hasClass( 'sidebar-mini' ) && $( 'body' ).hasClass( 'sidebar-expanded-on-hover' ) && $( window ).width() > screenWidth ) {
          _this.collapse();
        }
      } );
    },
    expand: function () {
      $( "body" ).removeClass( 'sidebar-collapse' ).addClass( 'sidebar-expanded-on-hover' );
    },
    collapse: function () {
      if ( $( 'body' ).hasClass( 'sidebar-expanded-on-hover' ) ) {
        $( 'body' ).removeClass( 'sidebar-expanded-on-hover' ).addClass( 'sidebar-collapse' );
      }
    }
  };

  /* Tree()
   * ======
   * Converts the sidebar into a multilevel
   * tree view menu.
   *
   * @type Function
   * @Usage: $.RedlofDashboard.tree('.sidebar')
   */
  $.RedlofDashboard.tree = function ( menu ) {
    var _this = this;
    var animationSpeed = $.RedlofDashboard.options.animationSpeed;
    $( document ).on( 'click', menu + ' li a', function ( e ) {
      //Get the clicked link and the next element
      var $this = $( this );
      var checkElement = $this.next();

      //Check if the next element is a menu and is visible
      if ( ( checkElement.is( '.treeview-menu' ) ) && ( checkElement.is( ':visible' ) ) ) {
        /*
        //Close the menu
        checkElement.slideUp( animationSpeed, function () {
          checkElement.removeClass( 'menu-open' );
          //Fix the layout in case the sidebar stretches over the height of the window
          //_this.layout.fix();
          $.RedlofDashboard.layout.fix();
        } );
        checkElement.parent( "li" ).removeClass( "active" );
        */
      }
      //If the menu is not visible
      else if ( ( checkElement.is( '.treeview-menu' ) ) && ( !checkElement.is( ':visible' ) ) ) {
        //Get the parent menu
        var parent = $this.parents( 'ul' ).first();
        //Close all open menus within the parent
        var ul = parent.find( 'ul:visible' ).slideUp( animationSpeed );
        //Remove the menu-open class from the parent
        ul.removeClass( 'menu-open' );
        //Get the parent li
        var parent_li = $this.parent( "li" );

        //Open the target menu and add the menu-open class
        checkElement.slideDown( animationSpeed, function () {
          //Add the class active to the parent li
          checkElement.addClass( 'menu-open' );
          parent.find( 'li.active' ).removeClass( 'active' );
          parent_li.addClass( 'active' );
          //Fix the layout in case the sidebar stretches over the height of the window
          //_this.layout.fix();
          $.RedlofDashboard.layout.fix();
        } );
      }
      //if this isn't a link, prevent the page from being redirected
      if ( checkElement.is( '.treeview-menu' ) ) {
        e.preventDefault();
      }
    } );
  };

  /* ControlSidebar
   * ==============
   * Adds functionality to the right sidebar
   *
   * @type Object
   * @usage $.RedlofDashboard.controlSidebar.activate(options)
   */
  $.RedlofDashboard.controlSidebar = {
    //instantiate the object
    activate: function () {
      //Get the object
      var _this = this;
      //Update options
      var o = $.RedlofDashboard.options.controlSidebarOptions;
      //Get the sidebar
      var sidebar = $( o.selector );
      //The toggle button
      var btn = $( o.toggleBtnSelector );

      //Listen to the click event
      btn.on( 'click', function ( e ) {
        e.preventDefault();
        //If the sidebar is not open
        if ( !sidebar.hasClass( 'control-sidebar-open' ) && !$( 'body' ).hasClass( 'control-sidebar-open' ) ) {
          //Open the sidebar
          _this.open( sidebar, o.slide );
        } else {
          _this.close( sidebar, o.slide );
        }
      } );

      //If the body has a boxed layout, fix the sidebar bg position
      var bg = $( ".control-sidebar-bg" );
      _this._fix( bg );

      //If the body has a fixed layout, make the control sidebar fixed
      if ( $( 'body' ).hasClass( 'fixed' ) ) {
        _this._fixForFixed( sidebar );
      } else {
        //If the content height is less than the sidebar's height, force max height
        if ( $( '.content-wrapper, .right-side' ).height() < sidebar.height() ) {
          _this._fixForContent( sidebar );
        }
      }
    },
    //Open the control sidebar
    open: function ( sidebar, slide ) {
      //Slide over content
      if ( slide ) {
        sidebar.addClass( 'control-sidebar-open' );
      } else {
        //Push the content by adding the open class to the body instead
        //of the sidebar itself
        $( 'body' ).addClass( 'control-sidebar-open' );
      }
    },
    //Close the control sidebar
    close: function ( sidebar, slide ) {
      if ( slide ) {
        sidebar.removeClass( 'control-sidebar-open' );
      } else {
        $( 'body' ).removeClass( 'control-sidebar-open' );
      }
    },
    _fix: function ( sidebar ) {
      var _this = this;
      if ( $( "body" ).hasClass( 'layout-boxed' ) ) {
        sidebar.css( 'position', 'absolute' );
        sidebar.height( $( ".wrapper" ).height() );
        $( window ).resize( function () {
          _this._fix( sidebar );
        } );
      } else {
        sidebar.css( {
          'position': 'fixed',
          'height': 'auto'
        } );
      }
    },
    _fixForFixed: function ( sidebar ) {
      sidebar.css( {
        'position': 'fixed',
        'max-height': '100%',
        'overflow': 'auto',
        'padding-bottom': '50px'
      } );
    },
    _fixForContent: function ( sidebar ) {
      $( ".content-wrapper, .right-side" ).css( 'min-height', sidebar.height() );
    }
  };
}


$.RedlofDashboard.load = function () {

  "use strict";

  //Fix for IE page transitions
  $( "body" ).removeClass( "hold-transition" );

  //Extend options if external options exist
  if ( typeof RedlofDashboardOptions !== "undefined" ) {
    $.extend( true,
      $.RedlofDashboard.options,
      RedlofDashboardOptions );
  }

  //Easy access to options
  var o = $.RedlofDashboard.options;

  //Set up the object
  _init();

  //Activate the layout maker
  $.RedlofDashboard.layout.activate();

  //Enable sidebar tree view controls
  $.RedlofDashboard.tree( '.sidebar' );

  //Enable control sidebar
  if ( o.enableControlSidebar ) {
    $.RedlofDashboard.controlSidebar.activate();
  }

  //Add slimscroll to navbar dropdown
  if ( o.navbarMenuSlimscroll && typeof $.fn.slimscroll != 'undefined' ) {
    $( ".navbar .menu" ).slimscroll( {
      height: o.navbarMenuHeight,
      alwaysVisible: false,
      size: o.navbarMenuSlimscrollWidth
    } ).css( "width", "100%" );
  }

  //Activate sidebar push menu
  if ( o.sidebarPushMenu ) {
    $.RedlofDashboard.pushMenu.activate( o.sidebarToggleSelector );
  }

  //Activate Bootstrap tooltip
  if ( o.enableBSToppltip ) {
    $( 'body' ).tooltip( {
      selector: o.BSTooltipSelector
    } );
  }

  /*
   * INITIALIZE BUTTON TOGGLE
   * ------------------------
   */
  $( '.btn-group[data-toggle="btn-toggle"]' ).each( function () {
    var group = $( this );
    $( this ).find( ".btn" ).on( 'click', function ( e ) {
      group.find( ".btn.active" ).removeClass( "active" );
      $( this ).addClass( "active" );
      e.preventDefault();
    } );

  } );
};



$.RedlofDashboard.load();
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
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeline', 'timelineEnd', 'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());
var map_config = {
    'default': {
        'borderColor': '#9CA8B6',
        'mapShadow': '#fff',
        'shadowOpacity': '50',
        'hoverShadow': '#666666',
        'namesColor': '#9CA8B6',
    },
    'map_1': {
        'hover': 'ANDHRA PRADESH',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_2': {
        'hover': 'ARUNACHAL PRADESH',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_3': {
        'hover': 'ASSAM',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_4': {
        'hover': 'BIHAR',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_5': {
        'hover': 'CHHATTISGARH',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_6': {
        'hover': 'GOA',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_7': {
        'hover': 'GUJARAT',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_8': {
        'hover': 'HARYANA',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_9': {
        'hover': 'HIMACHAL PRADESH',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_10': {
        'hover': 'JAMMU AND KASHMIR',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_11': {
        'hover': 'JHARKHAND',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_12': {
        'hover': 'KARNATAKA',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_13': {
        'hover': 'KERALA',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_14': {
        'hover': '<u><b>MADHYA PRADESH</b></u><br>Write any text and load images<br><img src="assets/images/hover.png">',
        'url': '/',
        'target': 'same_window',
        'upColor': '#e0f3ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_15': {
        'hover': 'MAHARASHTRA',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_16': {
        'hover': 'MANIPUR',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_17': {
        'hover': 'MEGHALAYA',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_18': {
        'hover': 'MIZORAM',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_19': {
        'hover': 'NAGALAND',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_20': {
        'hover': 'ODISHA',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_21': {
        'hover': 'PUNJAB',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_22': {
        'hover': 'RAJASTHAN',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_23': {
        'hover': 'SIKKIM',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_24': {
        'hover': 'TAMIL NADU',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_25': {
        'hover': 'TELANGANA',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_26': {
        'hover': 'TRIPURA',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_27': {
        'hover': 'UTTAR PRADESH',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_28': {
        'hover': 'UTTARAKHAND',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_29': {
        'hover': 'WEST BENGAL',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': false,
    },
    'map_30': {
        'hover': 'ANDAMAN AND NICOBAR ISLANDS',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_31': {
        'hover': 'CHANDIGARH',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_32': {
        'hover': 'DADRA AND NAGAR HAVELI',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_33': {
        'hover': 'DAMAN AND DIU',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_34': {
        'hover': 'LAKSHADWEEP',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_35': {
        'hover': 'NATIONAL CAPITAL TERRITORY OF DELHI',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    },
    'map_36': {
        'hover': 'PUDUCHERRY',
        'url': '/',
        'target': 'same_window',
        'upColor': '#eff9ff',
        'overColor': '#ffcc5f',
        'downColor': '#477cb2',
        'enable': true,
    }
}
// Quick feature detection
function isTouchEnabled() {
    return (('ontouchstart' in window) || (navigator.MaxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0));
}

$(function() {

    if ($('#lakes').find('path').eq(0).attr('fill') != 'undefined') {

        $('#lakes').find('path').attr({
            'fill': map_config['default'].lakesColor
        }).css({
            'stroke': map_config['default'].borderColor
        });
    }

    $('#map-tip').css({
        'box-shadow': '1px 2px 4px ' + map_config['default'].hoverShadow,
        '-moz-box-shadow': '2px 3px 6px ' + map_config['default'].hoverShadow,
        '-webkit-box-shadow': '2px 3px 6px ' + map_config['default'].hoverShadow,
    });

    if ($('#shadow').find('path').eq(0).attr('fill') != 'undefined') {

        var shadowOpacity = map_config['default'].shadowOpacity;

        shadowOpacity = parseInt(shadowOpacity);

        if (shadowOpacity >= 100) {
            shadowOpacity = 1;
        } else if (shadowOpacity <= 0) {
            shadowOpacity = 0;
        } else {
            shadowOpacity = shadowOpacity / 100;
        }

        $('#shadow').find('path').attr({
            'fill': map_config['default'].mapShadow
        }).css({
            'fill-opacity': shadowOpacity
        });
    }
});

function addEvent(id, relationId) {

    var _obj = $('#' + id);

    var _Textobj = $('#' + id + ',' + '#' + map_config[id].namesId);
    //var _h = $('#map').height();

    $('#' + ['text-abb']).attr({
        'fill': map_config['default'].namesColor
    });

    _obj.attr({
        'fill': map_config[id].upColor,
        'stroke': map_config['default'].borderColor
    });

    _Textobj.attr({
        'cursor': 'default'
    });

    if (map_config[id].enable == true) {

        if (isTouchEnabled()) {
            //clicking effect

            _Textobj.on('touchstart', function(e) {

                var touch = e.originalEvent.touches[0];

                var x = touch.pageX + 10,
                    y = touch.pageY + 15;

                var tipw = $('#map-tip').outerWidth(),
                    tiph = $('#map-tip').outerHeight();

                x = (x + tipw > $(document).scrollLeft() + $(window).width()) ? x - tipw - (20 * 2) : x;

                y = (y + tiph > $(document).scrollTop() + $(window).height()) ? $(document).scrollTop() + $(window).height() - tiph - 10 : y;

                $('#' + id).css({
                    'fill': map_config[id].downColor
                });

                $('#map-tip').show().html(map_config[id].hover);

                $('#map-tip').css({
                    left: x,
                    top: y
                });
            });

            _Textobj.on('touchend', function() {
                $('#' + id).css({
                    'fill': map_config[id].upColor
                });
                if (map_config[id].target == 'new_window') {
                    window.open(map_config[id].url);
                } else if (map_config[id].target == 'same_window') {
                    window.location.href = map_config[id].url;
                }
            });
        }

        _Textobj.attr({
            'cursor': 'pointer'
        });

        _Textobj.hover(function() {

            //moving in/out effect
            $('#map-tip').show().html(map_config[id].hover);

            _obj.css({
                'fill': map_config[id].overColor
            });

        }, function() {

            $('#map-tip').hide();

            $('#' + id).css({
                'fill': map_config[id].upColor
            });
        });

        //clicking effect
        _Textobj.mousedown(function() {

            $('#' + id).css({
                'fill': map_config[id].downColor
            });

        });

        _Textobj.mouseup(function() {

            $('#' + id).css({
                'fill': map_config[id].overColor
            });

            if (map_config[id].target == 'new_window') {

                window.open(map_config[id].url);

            } else if (map_config[id].target == 'same_window') {

                window.location.href = map_config[id].url;
            }
        });

        _Textobj.mousemove(function(e) {

            var x = e.pageX + 10,
                y = e.pageY + 15;

            var tipw = $('#map-tip').outerWidth(),
                tiph = $('#map-tip').outerHeight();

            x = (x + tipw > $(document).scrollLeft() + $(window).width()) ? x - tipw - (20 * 2) : x;

            y = (y + tiph > $(document).scrollTop() + $(window).height()) ? $(document).scrollTop() + $(window).height() - tiph - 10 : y;

            $('#map-tip').css({
                left: x,
                top: y
            });
        });
    }
}
