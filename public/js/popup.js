/* Auteur originel : Soh Tanaka
 * Modifications : Mathias Oberson
 */

/**
 * Permet de cacher la popup et de supprimer le cache.
 * @returns {void} Ne retourne rien.
 */
function removePopUp() {
    $('#fade, .popup_block').fadeOut(function() {
        $('#fade').remove();
    });
}

/**
 * Permet de rendre visible la popup indiquée par son identifiant.
 * Génère le cache.
 * @param {string} popID L'ID de la popup que l'on souhaite rendre visible.
 * @returns {void} Ne retourne rien.
 */
function showPopup(popID) {
    // Calcul du positionnement de la popup
    calculatePositionPopup(popID);

    //Faire apparaitre la pop-up
    $('#' + popID).fadeIn("fast");

    $('body').append('<div id="fade"></div>');
    $('#fade').css({'filter': 'alpha(opacity=0.3)'}).fadeIn();
}

/**
 * Permet de calculer les valeurs du positionnement de la popup pour assurer qu'elle soit toujours centrée et à la bonne taille en indiquant l'ID de la popup.
 * @param {type} popID L'ID de la popup que l'on souhaite rendre visible.
 * @returns {void} Ne retourne rien.
 */
function calculatePositionPopup(popID) {
    // Récupération des largeurs de fenêtre et de popup
    var widthWindow = $(window).width();
    var heightWindow = $(window).height();

    var widthPopup = $('#' + popID).width();
    var heightPopup = $('#' + popID).height();

    var deltaWidth = (widthWindow - widthPopup) / 2;
    var deltaHeight = (heightWindow - heightPopup) / 2 + $("body").scrollTop();

    var valueLeft = Math.ceil((deltaWidth * 100) / widthWindow);
    var valueTop = Math.ceil((deltaHeight * 100) / heightWindow);

    //Apply Margin to Popup
    $('#' + popID).css({
        'left': valueLeft + '%',
        'top': valueTop + "%"
    });
}

jQuery(function($) {
    
    //Close Popups and Fade Layer
    $('body').on('click', '#fade', function() {
        removePopUp();
    });

    // Recalcule le positionnement de la popup affichée lors du redimensionnement de la fenêtre.
    $(window).resize(function() {
        var popID = $(".popup_block[style*='display']");
        if (popID.size() !== 0) {
            calculatePositionPopup(popID.attr('id'));
        }
    });

    // Recalcul du positionnement de la popup affichée lors du scroll de la fenêtre.
    $(window).scroll(function() {
        $(this).resize();
    });
});