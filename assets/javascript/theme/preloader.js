(function() {
    fadeOutEffect(document.querySelector('.preloader'), 200);
})();

function fadeOutEffect(fadeTarget, timeout = 200) {
    var fadeEffect = setInterval(function () {
        if (!fadeTarget.style.opacity) {
            fadeTarget.style.opacity = 1;
        }
        if (fadeTarget.style.opacity > 0) {
            fadeTarget.style.opacity -= 0.1;
        } else {
            clearInterval(fadeEffect);
        }
    }, timeout);
}
