(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();

    const buttons = document.querySelectorAll("[data-carousel-button]");
    let currentIndex = 0;
    let intervalId;

    // Function to change slide
    function changeSlide(offset) {
        const slides = document.querySelector("[data-slides]");
        const activeSlide = slides.querySelector("[data-active]");
        currentIndex = (currentIndex + offset + slides.children.length) % slides.children.length;
        activeSlide.removeAttribute("data-active");
        slides.children[currentIndex].setAttribute("data-active", "");
    }

    // Button click event listeners
    buttons.forEach(button => {
        button.addEventListener("click", () => {
            const offset = button.dataset.carouselButton === "next" ? 1 : -1;
            changeSlide(offset);
            resetInterval();
        });
    });

    // Function to start the automatic slide change
    function startInterval() {
        intervalId = setInterval(() => {
            changeSlide(1);
        }, 3000); // Change slide every 3 seconds (adjust as needed)
    }

    // Function to reset the interval
    function resetInterval() {
        clearInterval(intervalId);
        startInterval();
    }

    // Start the automatic slide change
    startInterval();

    // Initiate the wowjs
    new WOW().init();

})(jQuery);
