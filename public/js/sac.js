$(document).ready(function() {

    /**
     * Vérification de la validité du champ "quantité"
     * @returns {Boolean} false : le champ est invalide | true : le champ est vaide.
     */
    function quantiteOK() {
        var quantite = $("#new_equip>input:text");
        if (isNaN(quantite.val())) {
            notification("error", "La quantité n'est pas un nombre !");
            quantite.val(1);
            quantite.addClass("error").focus();
            return false;
        }
        return true;
    }

    // Vérification de l'état du personnage.
    checkDeath();

    // Utilisation d'une potion sur un personnnage et application de ses effets
    $("div.centre>div.potion>div.use").click(function() {
        var nom = $("div.centre>h2").text();
        var id = $(this).siblings("div.nom").attr("data-rel");
        var nom_possession = $(this).siblings("div.nom")[0].childNodes[0].data;
        var quantite = $(this).siblings("div.nom").children("span.quantite");
        var possession = $(this).parent();
        $.get("index.php", {controller: "Possession", action: "useOne", nom: nom, id: id}, function(data) {
            if (data) {
                var new_quantite = quantite.text() - 1;
                notification("success", nom + " a utilisé une " + nom_possession + " avec succès !");
                if (new_quantite <= 0) {
                    possession.remove();
                } else {
                    quantite.text(new_quantite);
                }
                // Affichage de l'effet des potions
                switch (nom_possession) {
                    case "Potion de Bonne Fortune":
                        var stat = $("#chance");
                        var new_max = Number($("span.max", stat).text()) + 1;
                        $("span.max, span.actuel", stat).text(new_max);
                        break;
                    case "Potion d'Adresse":
                        $("#habilete>span.actuel").text($("#habilete>span.max").text());
                        break;
                    case "Potion de Vigueur":
                        $("#endurance>span.actuel").text($("#endurance>span.max").text());
                        break;
                }
            } else {
                notification("error", "Oops ! " + nom + " semble ne pas pouvoir utiliser une " + nom_possession);
            }
        });
    });

    // Suppression d'une possession du sac à dos
    $("div.centre>div>div.remove").click(function() {
        var nom = $("div.centre>h2").text();
        var id = $(this).siblings("div.nom").attr("data-rel");
        var nom_possession = $(this).siblings("div.nom")[0].childNodes[0].data;
        var quantite = $(this).siblings("div.nom").children("span.quantite");
        var possession = $(this).parent();
        $.get("index.php", {controller: "SacADos", action: "changePossessionQuantity", nom: nom, id: id, valeur: -1}, function(data) {
            if (data) {
                var new_quantite = quantite.text() - 1;
                notification("success", nom + " s'est séparé(e) d'un exemplaire de : " + nom_possession);
                if (new_quantite <= 0) {
                    possession.remove();
                } else {
                    quantite.text(new_quantite);
                }
            } else {
                notification("error", "Oops ! " + nom + " ne veut pas se séparer de : " + nom_possession);
            }
        });
    });

    // Récupération des possessions disponibles
    $("div.centre>button").click(function() {
        $.getJSON("index.php", {controller: "Possession", action: "getAll"}, function(data) {
            for (var i = 0; i < data.length; i++) {
                var option = $("<option>").attr("value", data[i].id).text(data[i].nom);
                switch (data[i].type_nom) {
                    case "potion":
                        $("#possession_potions").append(option);
                        break;
                    case "equipement":
                        $("#possession_equip").append(option);
                        break;
                    case "bijoux":
                        $("#possession_bijoux").append(option);
                        break;
                    default :
                        notification("error", "Une erreur est survenue lors de l'acquisition des possessions.");
                }
            }
        });
        $("#new_equip").show();
        $(this).hide();
    });

    // Annulation de l'ajout d'une possession.
    $("input:reset").click(function() {
        $("#new_equip").hide();
        $("div.centre>button").show();
        $("#possession_potions, #possession_equip, #possession_bijoux").empty();
    });

    // Validation de l'ajout d'une possession après validation de la quantité par la méthode quantiteOK()
    $("#new_equip").submit(function(event) {
        if (!quantiteOK()) {
            event.preventDefault();
            return false;
        }
    });
});