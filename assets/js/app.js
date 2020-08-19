$(document).ready(function() {
  var count = 0;
  $("#propertyDetail").on("shown.bs.modal", function() {
    if (count === 1) return;
    $("#content-slider").lightSlider({
      loop: true,
      keyPress: true
    });
    count++;
  });
});

$("#propertyDetail").on("shown.bs.modal", function() {
  window.lightSlider = $("#image-gallery").lightSlider({
    gallery: true,
    item: 1,
    thumbItem: 7,
    slideMargin: 0,
    speed: 500,
    auto: true,
    loop: true,
    onSliderLoad: function() {
      $("#image-gallery").removeClass("cS-hidden");
    }
  });
});

$("#propertyDetail").on("hidden.bs.modal", function() {
  if (window.lightSlider) {
    window.lightSlider.destroy();
  }
});

$(function() {
  "use strict";

  // Header shrink while page scroll
  adjustHeader();
  doSticky();
  placedDashboard();
  $(window).on("scroll", function() {
    adjustHeader();
    doSticky();
    placedDashboard();
  });

  // Header shrink while page resize
  $(window).on("resize", function() {
    adjustHeader();
    doSticky();
    placedDashboard();
  });

  function adjustHeader() {
    var windowWidth = $(window).width();
    if (windowWidth > 992) {
      if ($(document).scrollTop() >= 100) {
        if ($(".header-shrink").length < 1) {
          $(".sticky-header").addClass("header-shrink");
        }
        if ($(".do-sticky").length < 1) {
          $(".logo img").attr("src", "");
        }
      } else {
        $(".sticky-header").removeClass("header-shrink");
        if (
          $(".do-sticky").length < 1 &&
          $(".fixed-header").length == 0 &&
          $(".fixed-header2").length == 0
        ) {
          $(".logo img").attr("src", "");
        } else {
          $(".logo img").attr("src", "");
        }
      }
    } else {
      $(".logo img").attr("src", "");
    }
  }

  function doSticky() {
    if ($(document).scrollTop() > 40) {
      $(".do-sticky").addClass("sticky-header");
      //$('.do-sticky').addClass('header-shrink');
    } else {
      $(".do-sticky").removeClass("sticky-header");
      //$('.do-sticky').removeClass('header-shrink');
    }
  }

  function placedDashboard() {
    var headerHeight = parseInt($(".main-header").height(), 10);
    $(".dashboard").css("top", headerHeight);
  }

  // Banner slider
  (function($) {
    //Function to animate slider captions
    function doAnimations(elems) {
      //Cache the animationend event in a variable
      var animEndEv = "webkitAnimationEnd animationend";
      elems.each(function() {
        var $this = $(this),
          $animationType = $this.data("animation");
        $this.addClass($animationType).one(animEndEv, function() {
          $this.removeClass($animationType);
        });
      });
    }

    //Variables on page load
    var $myCarousel = $("#carousel-example-generic");
    var $firstAnimatingElems = $myCarousel
      .find(".item:first")
      .find("[data-animation ^= 'animated']");
    //Initialize carousel
    $myCarousel.carousel();

    //Animate captions in first slide on page load
    doAnimations($firstAnimatingElems);
    //Pause carousel
    $myCarousel.carousel("pause");
    //Other slides to be animated on carousel slide event
    $myCarousel.on("slide.bs.carousel", function(e) {
      var $animatingElems = $(e.relatedTarget).find(
        "[data-animation ^= 'animated']"
      );
      doAnimations($animatingElems);
    });
    $("#carousel-example-generic").carousel({
      interval: 3000,
      pause: "false"
    });
  })(jQuery);

  // Page scroller initialization.
  $.scrollUp({
    scrollName: "page_scroller",
    scrollDistance: 300,
    scrollFrom: "top",
    scrollSpeed: 500,
    easingType: "linear",
    animation: "fade",
    animationSpeed: 200,
    scrollTrigger: false,
    scrollTarget: false,
    scrollText: '<i class="fa fa-chevron-up"></i>',
    scrollTitle: false,
    scrollImg: false,
    activeOverlay: false,
    zIndex: 2147483647
  });

  // Counter
  function isCounterElementVisible($elementToBeChecked) {
    var TopView = $(window).scrollTop();
    var BotView = TopView + $(window).height();
    var TopElement = $elementToBeChecked.offset().top;
    var BotElement = TopElement + $elementToBeChecked.height();
    return BotElement <= BotView && TopElement >= TopView;
  }

  $(window).on("scroll", function() {
    $(".counter").each(function() {
      var isOnView = isCounterElementVisible($(this));
      if (isOnView && !$(this).hasClass("Starting")) {
        $(this).addClass("Starting");
        $(this)
          .prop("Counter", 0)
          .animate(
            {
              Counter: $(this).text()
            },
            {
              duration: 3000,
              easing: "swing",
              step: function(now) {
                $(this).text(Math.ceil(now));
              }
            }
          );
      }
    });
  });

  // Countdown activation
  // $(function() {
  // 	// Add background image
  // 	//$.backstretch('../img/nature.jpg');
  // 	var endDate = "December  27, 2019 15:03:25";
  // 	$(".countdown.simple").countdown({ date: endDate });
  // 	$(".countdown.styled").countdown({
  // 		date: endDate,
  // 		render: function(data) {
  // 			$(this.el).html(
  // 				"<div>" +
  // 					this.leadingZeros(data.days, 3) +
  // 					" <span>Days</span></div><div>" +
  // 					this.leadingZeros(data.hours, 2) +
  // 					" <span>Hours</span></div><div>" +
  // 					this.leadingZeros(data.min, 2) +
  // 					" <span>Minutes</span></div><div>" +
  // 					this.leadingZeros(data.sec, 2) +
  // 					" <span>Seconds</span></div>"
  // 			);
  // 		}
  // 	});
  // 	$(".countdown.callback")
  // 		.countdown({
  // 			date: +new Date() + 10000,
  // 			render: function(data) {
  // 				$(this.el).text(this.leadingZeros(data.sec, 2) + " sec");
  // 			},
  // 			onEnd: function() {
  // 				$(this.el).addClass("ended");
  // 			}
  // 		})
  // 		.on("click", function() {
  // 			$(this)
  // 				.removeClass("ended")
  // 				.data("countdown")
  // 				.update(+new Date() + 10000)
  // 				.start();
  // 		});
  // });

  $(".range-slider-ui").each(function() {
    var minRangeValue = $(this).attr("data-min");
    var maxRangeValue = $(this).attr("data-max");
    var minName = $(this).attr("data-min-name");
    var maxName = $(this).attr("data-max-name");
    var unit = $(this).attr("data-unit");

    $(this).append(
      "" +
        "<span class='min-value'></span> " +
        "<span class='max-value'></span>" +
        "<input class='current-min' type='hidden' name='" +
        minName +
        "'>" +
        "<input class='current-max' type='hidden' name='" +
        maxName +
        "'>"
    );
    $(this).slider({
      range: true,
      min: minRangeValue,
      max: maxRangeValue,
      values: [minRangeValue, maxRangeValue],
      slide: function(event, ui) {
        event = event;
        var currentMin = parseInt(ui.values[0], 10);
        var currentMax = parseInt(ui.values[1], 10);
        $(this)
          .children(".min-value")
          .text(currentMin + " " + unit);
        $(this)
          .children(".max-value")
          .text(currentMax + " " + unit);
        $(this)
          .children(".current-min")
          .val(currentMin);
        $(this)
          .children(".current-max")
          .val(currentMax);
      }
    });

    var currentMin = parseInt($(this).slider("values", 0), 10);
    var currentMax = parseInt($(this).slider("values", 1), 10);
    $(this)
      .children(".min-value")
      .text(currentMin + " " + unit);
    $(this)
      .children(".max-value")
      .text(currentMax + " " + unit);
    $(this)
      .children(".current-min")
      .val(currentMin);
    $(this)
      .children(".current-max")
      .val(currentMax);
  });

  // Select picket
  $(".selectpicker").selectpicker({
    width: "fit",
    selectedTextFormat: "count > 2"
  });
});
