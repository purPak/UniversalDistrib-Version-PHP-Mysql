(function($) {
    "use strict"; // Start of use strict

    // Reroutage
    //function MM_jumpMenu(targ,selObj,restore) { //v3.0
    //    eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
    //    if (restore) selObj.selectedIndex=0;}

    // Carousel Animation
    $('#homeHeaderCarousel').carousel({
        interval: 6000,
        pause: "hover"
    });

    $('#subcategoryCarousel').carousel({
        interval: 0
    });

    // Activate scrollspy
    $('body').scrollspy({
        target: '#mainNav',
        offset: 56
    });

    // News Animation
    $('.news-item').click(
        'news', function() {
            if ($(window).width()>992) {
                if ($(this).hasClass("news-action")) {
                    $(this).removeClass("news-action");
                    $('.news-veil').removeClass('veil');
                } else {
                    $(this).addClass('news-action');
                    $('.news-veil').addClass('veil');
                }
            }
        }
    );

    $('.news-content').scroll(
        'navbarCollapse', function() {
            if ($('#mainNav').offset().top > 70) {
                $('#mainNav').addClass("navbar-animate");
            } else {
                $("#mainNav").removeClass("navbar-animate");
            }
        }
    );

    // Navbar Animation
    $(window).scroll(
        'navbarCollapse', function() {
            if ($('#mainNav').offset().top > 70) {
                $('#mainNav').addClass("navbar-animate");
            } else {
                $("#mainNav").removeClass("navbar-animate");
            }
        }
    );

    // Hide navbar when modals trigger
    $('.news-modal').on(
        'show.bs.modal', function() {$(".navbar").addClass("d-none");},
        'hidden.bs.modal', function() {$(".navbar").removeClass("d-none");}
    );

    // Counter
    console.clear();

    document.addEventListener('click', function changeCount(evt) {
        let counterBtn = evt.target;

        if (!counterBtn.closest('.js-counter-btn')) return;

        let counterInput = counterBtn.closest('.js-counter').
        querySelector('.js-counter-value');

        switch (counterBtn.getAttribute('data-action')) {
            case 'plus':
                counterInput.value = Number(counterInput.value) + 1;
                break;
            case 'minus':
                counterInput.value = Number(counterInput.value) - 1;
                break;}

    });

    $('.counter-img').click(function () {
        $(this).hide();
    });

})(jQuery); // End of use strict