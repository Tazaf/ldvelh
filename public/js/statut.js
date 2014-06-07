/**
 * Vérifie si le contenu du champ "Bourse" contient quelque chose de valide.
 * @returns {Boolean} false : Le champ est soit vide, soit invalide. | true : Le champ contient quelque chose de valide.
 */
function bourseOK() {
    var bourse = $(".centre input:text");
    if (bourse.val() === "") {
        bourse.addClass("error");
        notification("error", "Aucun montant indiqué dans la bourse !");
        return false;
    } else if (isNaN(bourse.val())) {
        bourse.addClass("error");
        notification("error", "Le montant dans la bourse n'est pas un nombre !");
        return false;
    } else {
        bourse.removeClass("error");
        return true;
    }
}

/**
 * Vérifie que la valeur de l'endurance d'un personnage est supérieure à 0.
 * Si l'endurance est inférieure à 0, une demande de confirmation est lancée.
 * @returns {Boolean} false : La valeur est inférieure à zéro et la confirmation a été refusée | true : La valeur est supérieure à 0 ou la confirmation a été acceptée.
 */
function enduranceOK() {
    var warning = "Attention ! Un personnage sans endurance meurt et ne peut plus être utilisé.\nCette action est irréversible.\nVoulez-vous vraiment sauver ces changements ?";
    if ($("div:nth-of-type(2).stats>span.actuel").text() != 0 || confirm(warning)) {
        return true;
    } else {
        return false;
    }
}

$(document).ready(function() {

    // Vérification de l'état du personnage
    checkDeath();

    // Décrémentation d'une statistique lors de l'appui sur un bouton "-1"
    $(".centre>div.stats>button:first-of-type").click(function() {
        var elm = $(this).parent("div").children(".actuel");
        var value = elm.text();
        value--;
        if (value < 0) {
            elm.addClass("bad");
            value = 0;
            notification("error", "Statistique déjà à son minimum !");
        } else {
            $(".status_action").prop("disabled", false);
        }
        elm.text(value);
    });

    // Incrémentation d'une statistique lors de l'appui sur un bouton "+1"
    $(".centre>div.stats>button:last-of-type").click(function() {
        var elm = $(this).parent("div").children(".actuel");
        var max = $(this).prev("span.max").text();
        var value = elm.text();
        value++;
        if (value > max) {
            notification("error", "Statistique déjà à son maximum !");
            return false;
        }
        elm.removeClass("bad");
        elm.text(value);
        $(".status_action").prop("disabled", false);
    });

    // Décrémentation du nombre de repas lors de l'appui sur le bouton "-1"
    $(".centre>div:nth-of-type(4)>button:first-of-type").click(function() {
        var elm = $(this).next("span");
        var value = elm.text();
        value--;
        if (value < 0) {
            value = 0;
            notification("error", "Vous n'avez déjà plus de provisions...");
        } else {
            $(".status_action").prop("disabled", false);
        }
        elm.text(value);
    });

    // Incrémentation du nombre de repas lors de l'appui sur le bouton "+1"
    $(".centre>div:nth-of-type(4)>button:last-of-type").click(function() {
        var elm = $(this).parent("div").children(".actuel");
        var value = elm.text();
        value++;
        if (value > 10) {
            value = 10;
            notification("error", "Vous n'avez plus de place dans votre sac pour une provision supplémentaire.");
        } else {
            $(".status_action").prop("disabled", false);
        }
        elm.text(value);
    });

    // Rechargement de la page en cas d'annulation des modifications des statistiques
    $(".centre>button.status_action:first-of-type").click(function() {
        location.reload();
    });

    // Création des évènements clavier pour l'incrémentation ou la décrémentation du contenu de la bourse
    $(".centre input:text").keydown(function(key) {
        var valeur = $(this).val();
        if (key.which === 38) {
            $(this).val(++valeur);
        } else if (key.which === 40) {
            $(this).val(--valeur);
        }
        if (valeur > 100000000) {
            $(this).val(100000000);
            notification("error", "Votre bourse est pleine !");
        } else if (valeur < 0) {
            $(this).val(0);
            notification("error", "Votre bourse est vide !");
        }
        $(".status_action").prop("disabled", false);
    });

    // Enreigstrement des modifications du statut du personnage
    $(".centre>button.status_action:last-of-type").click(function() {
        if (enduranceOK() && bourseOK()) {
            var nom = $("div.centre>h2").text();
            var stats = {};
            stats["habilete"] = $(".centre>div.stats:first-of-type>span.actuel").text();
            stats["endurance"] = $(".centre>div.stats:nth-of-type(2)>span.actuel").text();
            stats["chance"] = $(".centre>div.stats:nth-of-type(3)>span.actuel").text();
            stats["repas"] = $(".centre>div:nth-of-type(4)>span.actuel").text();
            stats["bourse"] = $(".centre input:text").val();
            var values = JSON.stringify(stats);
            $.get("index.php", {controller: "Personnage", action: "modifyAllStats", nom: nom, values: values}, function(data) {
                if (data) {
                    $(".status_action").attr("disabled", "disabled");
                    notification("success", "Modifications sauvegardées !");
                } else {
                    notification("error", "Une erreur est survenue lors de la sauvegarde.");
                }
            });
            checkDeath();
        }
    });

});