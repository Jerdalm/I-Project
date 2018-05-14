$(window).scroll(function() {
    var scrolled = $(this).scrollTop() > 1;
    $("nav.navbar").css('background-color', scrolled ? 'rgba(0, 0, 0, 0.4)' : "rgba(0, 0, 0, 0)");
});

 $("#myCarousel").on("slide.bs.carousel", function(e) {
  var $e = $(e.relatedTarget);
  var idx = $e.index();
  var itemsPerSlide = 3;
  var totalItems = $(".carousel-item").length;

  if (idx >= totalItems - (itemsPerSlide - 1)) {
    var it = itemsPerSlide - (totalItems - idx);
    for (var i = 0; i < it; i++) {
      // append slides to end
      if (e.direction == "left") {
        $(".carousel-item")
          .eq(i)
          .appendTo(".carousel-inner");
      } else {
        $(".carousel-item")
          .eq(0)
          .appendTo($(this).find(".carousel-inner"));
      }
    }
  }
}); 