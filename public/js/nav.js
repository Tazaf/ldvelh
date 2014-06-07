/**
 * Permet de simuler un ou plusieurs lancés de dés 6.
 * @param {int} nb_dice Le nombre de lancers que l'on souhaite effectuer.
 * @returns {int[]} Un tableau contenant les résultats des ou du lancer de dé.
 */
function throwDice(nb_dice) {
    var results = [];
    for (var i = 0; i < nb_dice; i++) {
        results.push(Math.ceil(Math.random() * 6));
    }
    return results;
}

/**
 * Permet d'afficher le résultats d'un ou de plusieurs lancer de dés. Nécessite un tableau contenant autant de valeurs de dés que désirés.
 * @param {type} results Un tableau contenant autant de valeurs de dés que désiré. Ces valeurs seront ensuite affichées dans la div correspondante.
 * @returns {void} Ne retourne rien.
 */
function showResults(results) {
    $("#dice_popup>div>div:first-child").empty();
    var total = 0;
    for (var i = 0; i < results.length; i++) {
        var dice = $("<img>").attr("src", "./css/img/dice_" + results[i] + ".png");
        $("#dice_popup>div>div:first-child").append(dice);
        total += results[i];
    }
    $("#dice_popup>div>span").text(total);
}

/**
 * Permet de vérifier que le nombre de dés entrés est bien un nombre. Si c'est le cas, le lancer de dés est effectués.
 * Sinon, une notification d'erreur apparaît, le nombre de dés est réinitialisé et le focus retourne sur le champ de saisie.
 * @param {jQuery} context Un objet jQuery contenant l'input sur lequel vérifier la valeur.
 * @returns {void} Ne retourne rien.
 */
function checkNbDice(context) {
    if (isNaN(context.val())) {
        notification("error", "Tutut ! Ce n'est pas un nombre !");
        context.val(1);
        context.focus();
    } else {
        showResults(throwDice(context.val()));
    }
}

$(document).ready(function() {

    // Ancrage de la barre de menu lors du scroll vers le bas
    $(document).scroll(function() {
        var padding = $("nav").height();
        if ($(document).scrollTop() >= 59) {
            $("nav").css({position: 'fixed', top: 0});
            $("body").css({'padding-top': 59 + padding + "px"});
        } else {
            $("nav").css({position: 'static'});
            $("body").css({'padding-top': '59px'});
        }
    });

    // Affichage de la popup de lancer de dés
    $("#dice").click(function() {
        showPopup($(this).attr('id') + '_popup');
        $("#dice_popup>p>input:text").focus();
        $("#dice_popup>p>input:text").val(1);
    });

    // Naviguation au clavier sur la popup de lancer de dés
    $("#dice_popup>p>input:text").keydown(function(key) {
        if (key.keyCode === 13) {
            checkNbDice($(this));
        }
        if (key.keyCode >= 97 && key.keyCode <= 105) {
            $(this).val(key.keyCode - 96);
        }
    });

    // Lors du clic sur le bouton de lancer de dés, vérification du nombre de dés, puis affichage des résultats 
    $("#dice_popup>button:first-of-type").click(function() {
        checkNbDice($(this).prev("p").children("input:text"));
    });

    // Suppression de la popup de lancer de dé
    $("#dice_popup>button:last-of-type").click(function() {
        removePopUp();
        $("#dice_popup>p>input:text").val(1);
        $("#dice_popup>div>div:first-child").empty();
        $("#dice_popup>div>span").text("??");
    });
    $("body").on("click", "#fade", function() {
        $("#dice_popup>button:last-of-type").click();
    });
});