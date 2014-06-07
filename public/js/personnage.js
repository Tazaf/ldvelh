$(document).ready(function() {

    /**
     * Permet de faire passer une div potions à l'état "sélectionné" lors du clic sur cette div.
     * Supprime l'état "sélectionné" des autres div potions.
     * @param {jQuery Object} context La div potion que l'on souhaite faire passer à l'état sélectionné.
     * @returns {void} Ne retourne rien.
     */
    function changeSelectedPotion(context) {
        var siblings = context.siblings("div.potions.selected");
        siblings.removeClass("selected");
        context.addClass("selected");
        $("input:radio", context).prop("checked", true);
        $("input:radio", siblings).prop("checked", false);
    }

    /**
     * Vérifie si le nom du nouveau personnage est disponible.
     * Si le nom n'est pas disponible, une notification d'erreur apparaît.
     * @returns {boolean} Retourne false pour empêcher l'action d'envoi du formulaire (si appelé par un bouton d'envoi de formulaire).
     */
    function checkNom() {
        var champ = $("#new_popup>form>input:text");
        var nom = $.trim(champ.val());
        champ.val(nom);
        $.get("index.php", {controller: "Personnage", action: "checkOne", nom: champ.val()}, function(data) {
            if (data) {
                notification("error", champ.val() + ' est déjà pris.');
                champ.addClass("error");
                champ.val("");
                champ.focus();
            } else {
                champ.removeClass("error");
            }
        });
    }

    /**
     * Ajoute un li spécial indiquant l'absence de personnage à l'affichage.
     * @param {Number} etat L'état du personnage à afficher. Si 1 : alors affichage de l'absence de persos vivants. Si 0 : affichage de l'absence de persos morts.
     * @returns {void} Ne retourne rien
     */
    function showNoPerso(etat) {
        if (etat === 1) {
            var li = $("<li>").attr("id", "no_perso").text("Aucun aventurier vivant dans les parages...");
            $("#personnages").append(li);
        } else {
            var li = $("<li>").attr("id", "no_perso").text("Le Cimetière est vide... pour l'instant...");
            $("#perso_mort").append(li);
        }
    }

    /**
     * Supprime un personnage de la liste de personnages vivants ou morts
     * @param {jQuery Object} context L'objet jQuery qui a appelé cette fonction
     * @param {Number} etat L'état du personnage à supprimer. 1 : personnage vivant, 0 : personnage mort.
     * @returns {void} Ne retourne rien
     */
    function deletePerso(context, etat) {
        var nom = context.parent("div")[0].childNodes[0].data;
        if (confirm("Voulez-vous supprimer " + nom + " ?")) {
            var fiche = context.parents("li");
            $.get("index.php", {controller: "Personnage", action: "deleteOne", nom: nom}, function(data) {
                if (data) {
                    $(".tooltip").remove();
                    var siblings = fiche.siblings().size();
                    fiche.remove();
                    if ((siblings === 1 && etat === 1) || (siblings === 0 && etat === 0)) {
                        showNoPerso(etat);
                    }
                    notification("success", nom + ' est mort(e) et oublié(e).');
                } else {
                    notification("error", 'Oops ! ' + nom + ' refuse de disparaître...');
                }
            });
        }
    }

// ASSIGNATION DES ÉVENEMENTS    

    // Au clic sur le bouton "Générer un personnage", ouverture du popup de création
    $('#new').click(function() {
        showPopup($(this).attr('id') + "_popup");
        $("#new_popup>form>input:text").focus();
    });

    // Si le bouton "Générer un personnage" a le focus et la touche "Entrée" est pressée, ouverture du popup de création du personnage.
    $("#new").keydown(function(key) {
        if (key.keyCode === 13) {
            showPopup($(this).attr('id') + "_popup");
            $("#new_popup>form>input:text").focus();
        }
    });

    // Lors de la perte de focus du champ texte du nom, vérification de la validité du nom entré
    $("#new_popup>form>input:text").blur(function() {
        checkNom();
    });

    // Lors de l'appui sur la touche "Esc" depuis la popup de création de personnage, fermeture de la popup de création de personnage et réinitialisation du champ "nom"
    $("#new_popup").keydown(function(key) {
        if (key.keyCode === 27) {
            $("input:reset").click();
        }
    });
    
    // lors du clic sur le fond noi, suppression de la popup
    $("body").on("click", "#fade", function() {
        $("input:reset").click();
    });

    // Au clic sur une potion dans la création de personnage, selection de cette potion
    $("#new_popup>form>.potions").click(function() {
        changeSelectedPotion($(this));
    });

    // Au clic sur le bouton Supprimer d'un personnage, vivant ou mort, suppression de ce personnage de la BD et de la page HTML
    $("#personnages>li>div:first-of-type>span:last-of-type").click(function() {
        deletePerso($(this), 1);
    });
    $("#perso_mort>li>div:first-of-type>span:last-of-type").click(function() {
        deletePerso($(this), 0);
    });

    // Au clic sur le bouton reset du popup de création de personnage, fermeture de la popup
    $("#new_popup>form>input:reset").click(function() {
        removePopUp();
    });

    // Mis en place de la navigation clavier pour le choix des potions.
    $("#new_popup>form>.potions").keydown(function(key) {
        if (key.keyCode === 13) {
            changeSelectedPotion($(this));
        }
    });
});