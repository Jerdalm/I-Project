$(window).scroll(function() {
    var scrolled = $(this).scrollTop() > 1;
    $("nav.navbar").css('background-color', scrolled ? 'rgba(0, 0, 0, 0.4)' : "rgba(0, 0, 0, 0)");
});