/**
 * Permet d'afficher une notification sur la page. Cette notification contient un message passé en paramètre.
 * Par défaut, une notification indique une erreur. Pour que la notification indique un succès, le paramètre "success" doit être présent et valoir "true".
 * @param {string} message Le message que la notification devra afficher.
 * @param {boolean} type (Optionnel) Si présent et de valeur "true" : la notification sera de type "success"
 * @returns {void}
 */
function notification(type, message) {
    $(".notification").remove();
    var cadre = $("<div>").addClass("notification").text(message);
    switch (type) {
        case "error":
            cadre.addClass("notif_error");
            break;
        case "success":
            cadre.addClass("notif_success");
            break;
    }
    cadre.appendTo("body");
    $(".notification").css({'bottom': "-" + cadre.outerHeight() + "px"});
    cadre.show('fast').animate({bottom: "0"}, 250).delay(2500).animate({bottom: "-60px"}, 250, function() {
        this.remove();
    });
}