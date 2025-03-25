/**
 * Animation-Hilfsfunktionen fu00fcr das Anmeldeformular
 * Diese Funktionen bieten Standardanimationen, die in verschiedenen Komponenten verwendet werden ku00f6nnen
 */

// Ein Element einblenden mit Fade-Effekt
function fadeIn(element) {
    if (!element) return;
    element.style.opacity = '0';
    element.style.display = '';
    setTimeout(function() {
        element.style.opacity = '1';
    }, 50);
}

// Ein Element ausblenden mit Fade-Effekt
function fadeOut(element) {
    if (!element) return;
    element.style.opacity = '1';
    setTimeout(function() {
        element.style.opacity = '0';
        element.style.display = 'none';
    }, 50);
}
