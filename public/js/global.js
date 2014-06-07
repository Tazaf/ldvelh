/**
 * Affiche le tooltip sur l'élément choisi.
 * @param {jQuery Object} context L'objet jQuery concerné par un appel $(this)
 * @returns {void}
 */
function showTooltip(context) {
    var title = context.attr('title');
    context.data('tipText', title).removeAttr('title');
    $('<div>')
            .addClass("tooltip")
            .text(title)
            .prependTo('body')
            .fadeIn('fast');
}

/**
 * Vérifie si le personnage est mort (n'a plus de points de vie).
 * Si tel est le cas, l'interactivité est désactivée.
 * @returns {void}
 */
function checkDeath() {
    var test1 = $("#endurance").length !== 0 && $("#endurance>span.actuel").text() == 0;
    var test2 = $("div:nth-of-type(2).stats").length !== 0 && $("div:nth-of-type(2).stats>span.actuel").text() == 0;
    if (test1 || test2) {
        $("#endurance").addClass("bad").empty().text("Mort");
        $(".centre button, input[name='bourse'], select[name='paragraphe']").prop("disabled", true);
        $(".centre>div").addClass("disabled");
        $("div:nth-of-type(2).stats>span.max").remove();
        $("div:nth-of-type(2).stats>span.actuel").addClass("mort").text("Mort");
    }
}

/**
 * Supprime le tooltip de l'élément choisi.
 * @param {jQuery Object} context L'objet jQuery concerné par un appel $(this)
 * @returns {void}
 */
function removeTooltip(context) {
    context.attr('title', context.data('tipText'));
    $('.tooltip').remove();
}

/**
 * Fait se déplacer le Tooltip selon les déplacements de la souris à l'intérieur de l'élément choisi.
 * @param {jQuery Object} context L'objet jQuery concerné par un appel $(this)
 * @param {eventObject} event L'évènement qui a déclenché l'appel de la fonction
 * @returns {void}
 */
function moveTooltip(context, event) {
    var mousex = event.pageX + 20; //Get X coordinates
    var mousey = event.pageY + 30; //Get Y coordinates
    if (context.hasClass("tooltip_right")) {
        $('.tooltip').css({top: mousey, right: $(window).width() - mousex + 20});
    } else {
        $('.tooltip').css({top: mousey, left: mousex});
    }
}

$(document).ready(function() {
    /**
     * TOOLTIP FUNCTION
     * SOURCE : http://www.alessioatzeni.com/blog/simple-tooltip-with-jquery-only-text/
     * @author Alessio Atzeni
     */

    // Registre des éléments présents sur la page à son chargement et concernés par le tooltip
    var elements = [
        "#personnages .stats>div",
        "#personnages>li>div:first-of-type>span:last-of-type",
        "#personnages>li>a",
        "#perso_mort .stats>div",
        "#perso_mort>li>div:first-of-type>span:last-of-type",
        "#perso_mort>li>a",
        "#new_popup>p",
        "#new_popup>form>input:text",
        "#small_title>p>a",
        "nav>ul>li",
        "div.centre>div:last-of-type>input:text",
        "#new_equip>label",
        "#new_equip>input:text"
    ];
    $(elements.join(", ")).hover(function() {
        showTooltip($(this));
    }, function() {
        removeTooltip($(this));
    }).mousemove(function(e) {
        moveTooltip($(this), e);
    });

    // Registre des éléments créés dynamiquement dans la page et concernés par le tooltip
    var new_elements = [
        "ul.monstres>li>span:not(.monstre_nom)"
    ];
    $("#combat").on("mouseenter mouseleave mousemove", new_elements.join(", "), function(event) {
        switch (event.type) {
            case "mouseenter":
                showTooltip($(this));
                break;
            case "mouseleave":
                removeTooltip($(this));
                break;
            case "mousemove":
                moveTooltip($(this), event);
                break;
        }
    });
});