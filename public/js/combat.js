$(document).ready(function() {
    /**
     * Calcule la Force d'Attaque (FA) du monstre ou du personnage.
     * Le calcul s'effectue de la manière suivante : 2d6 + valeur d'habileté du personnage ou du monstre.
     * @param {Number} habilete La valeur d'habileté du personnage ou du monstre.
     * @returns {Number}
     */
    function calcFA(habilete) {
        var FA = 0;
        var dices = throwDice(2);
        for (i = 0; i < dices.length; i++) {
            FA += dices[i];
        }
        return FA + habilete;
    }

    /**
     * Affiche une entrée dans le log du combat en cours.
     * @param {jQuery Object} log_entry Un objet jquery contenant l'entrée du log.
     * @returns {void}
     */
    function addLogEntry(log_entry) {
        var log = $("#combat>div.log");
        log.prepend(log_entry);
    }

    /**
     * Applique les effets des malus liés au paragraphe
     * @param {Number} valeur La valeur du malus a appliquer
     * @param {String} caracteristique La caracteristique sur laquelle s'applique le malus
     * @returns {void}
     */
    function applyMalus(valeur, caracteristique) {
        var elm = $("#" + caracteristique + ">span.actuel");
        elm.data("default", elm.text());
        var newValue = Number(elm.text()) + valeur;
        elm.addClass("bad").text(newValue);
    }

    /**
     * Créé et affiche un bloc de combat terminé dans la liste des combats effectués par le personnage
     * @param {Boolena} resultat Le résultat du combat. 1 pour une victoire, 0 pour une défaite
     * @param {Number} id L'identifiant du monstre dont on cherche à afficher les informations dans le combat_log
     * @param {Number} numero Le numero du paragraphe où s'est déroulé le combat
     * @returns {void}
     */
    function createCombatLog(resultat, id, numero) {
        $("#no_combat").remove();
        $.getJSON("index.php", {controller: "Monstre", action: "getOne", id: id}, function(data) {
            var titre = resultat === 1 ? $("<p>").addClass("victoire").text("Victoire !") : $("<p>").addClass("defaite").text("Défaite...");
            var text_before = resultat === 1 ? "A vaincu " : "A été vaincu par ";
            var nom = $("<span>").addClass("monstre_nom").text(data.nom);
            var habilete = $("<span>").addClass("habilete").text(data.habilete);
            var endurance = $("<span>").addClass("endurance").text(data.endurance);
            var text_after = " au paragraphe " + numero;
            var texte = $("<p>").append(text_before).append(nom).append(habilete).append(endurance).append(text_after);
            $("#combat_log").prepend($("<div>").append(titre).append(texte));
        });
    }

    /**
     * Remets les valeurs par défaut des statistiques affectées par un ou des malus
     * @returns {void}
     */
    function resetStats() {
        $("#fast_stat>div>span.actuel").each(function() {
            if ($(this).data("default")) {
                $(this).text($(this).data("default"));
                $(this).removeClass("bad");
            }
        });
    }

    /**
     * Sauve le statut du personnage à la fin du combat
     * @returns {void}
     */
    function saveStatus() {
        var nom = $("div.centre>h2").text();
        var valeur = $("#endurance>span.actuel").text();
        $("#endurance>span.actuel").data("default", valeur);
        $.get("index.php", {controller: "Personnage", action: "modifyOneStat", nom: nom, stat: "endurance", valeur: valeur}, function(data) {
            if (data) {
                notification("success", "Status de " + nom + " sauvegardé !");
            } else {
                notification("error", "Quel tricheur, ce " + nom + ". Il ne veut pas sauver son status.");
            }
        });
    }

    // Vérification de l'état du personnage
    checkDeath();

    // Sauvegarde de l'endurance actuelle
    $("#endurance>span.actuel").data("default", $("#endurance>span.actuel").text());

    // Récupération des données du paragraphe choisit lors du clic sur le bouton "Démarrer le combat"
    $("#select_battle>button").click(function() {
        var numero = $("#select_battle>select").val();
        $.getJSON("index.php", {controller: "Paragraphe", action: "getParagrapheData", numero: numero}, function(data) {
            $("#combat").empty().show();
            var paragraphe = $("<p>").text("Paragraphe " + data.numero).data("numero", data.numero);
            if (data.malus !== null) {
                var caracteristique = $("<span>").addClass(data.malus.caracteristique).text(data.malus.caracteristique);
                var malus = $("<div>").attr("id", "malus").text(data.malus.modificateur + " " + data.malus.valeur + " à ").append(caracteristique);
                applyMalus(Number(data.malus.modificateur + data.malus.valeur), data.malus.caracteristique);
            } else {
                var malus = $("<div>").attr("id", "malus").text("Aucun");
            }
            paragraphe.append(malus);
            var battle = $("<button>").attr({id: "battle", title: "Lancer un nouvel assaut."}).text("Combattre !");
            var monstres = $("<ul>").addClass("monstres").append(battle);
            $(data.monstres).each(function() {
                var nom = $("<span>").addClass("monstre_nom").text(this.nom).data("id", this.id)
                var habilete = $("<span>").addClass("habilete").attr("title", "Habileté de " + this.nom).text(this.habilete);
                var endurance = $("<span>").addClass("endurance").attr("title", "Endurance actuelle de " + this.nom).text(this.endurance).data("default", this.endurance);
                var monstre = $("<li>").append(nom).append(habilete).append(endurance);
                monstres.append(monstre);
            });
            $("li:first-of-type", monstres).addClass("courant");
            var legend = $("<div>").addClass("legend").text("Suivi du combat");
            var log = $("<div>").addClass("log");
            var cancel = $("<button>").attr("id", "cancel").text("Annuler");
            $("#combat").append(paragraphe).append(monstres).append(legend).append(log).append(cancel);
            $("#select_battle").hide();
            $("#battle").focus();
        });
    });

    // Exécution d'un tour du combat.
    $("#combat").on("click", "#battle", function() {
        $(this).trigger("battle");
        var caracteristique = $("<span>").addClass("endurance").text("endurance");
        // Récupération des données du monstre
        var monstre = $("#combat>ul.monstres>li.courant");
        var nom_M = $("span.monstre_nom", monstre).text();
        var H_M = Number($("span.habilete", monstre).text());
        var E_M = $("span.endurance", monstre);
        // Récupération des données du personnage
        var nom_P = $("div.centre>h2").text();
        var H_P = Number($("#habilete>span.actuel").text());
        var E_P = $("#endurance>span.actuel");
        // Calcul des Forces d'Attaque (FA)
        var FA_M = calcFA(H_M);
        var FA_P = calcFA(H_P);
        // Résolution du tour de combat
        if (FA_P > FA_M) {
            var NewE_M = (E_M.text() - 2) < 0 ? 0 : E_M.text() - 2;
            E_M.text(NewE_M);
            var results = $("<span>").text(" (" + nom_P + " : " + FA_P + " > " + FA_M + " : " + nom_M + ")");
            var log_entry = $("<p>").addClass("log_entry").text(nom_M + " perd 2 ").append(caracteristique).append(results);
        } else if (FA_M > FA_P) {
            var NewE_P = (E_P.text() - 2) < 0 ? 0 : E_P.text() - 2;
            E_P.text(NewE_P);
            var results = $("<span>").text(" (" + nom_P + " : " + FA_P + " < " + FA_M + " : " + nom_M + ")");
            var log_entry = $("<p>").addClass("log_entry").text(nom_P + " perd 2 ").append(caracteristique).append(results);
        } else {
            var log_entry = $("<p>").addClass("log_entry").text(nom_P + " a esquivé le coup de " + nom_M + " !");
        }
        // Affichage du résultat du tour
        addLogEntry(log_entry);
        // Vérification de l'avancée du combat
        if (E_M.text() === "0") {
            $(this).trigger("victory", [nom_M, nom_P]);
        } else if (E_P.text() === "0") {
            $(this).trigger("defeat", [nom_M, nom_P]);
        }
    });

    // Modification du bouton d'annulation en bouton de fuite.
    $("#combat").on("battle", "#battle", function() {
        $("#cancel").text("Fuir !");
    });

    // Retour à l'état de départ lors du clic sur le bouton d'annulation.
    $("#combat").on("click", "#cancel", function() {
        resetStats();
        $("#select_battle").show();
        $("#combat").empty().hide();
        removeTooltip($(this));
    });

    // Lors de l'enclenchement de l'évènement victoire, désactivation du bouton "Combat" et affichage du message de victoire.
    // S'il reste des monstres, apparition du bouton "Monstre suivant"
    // Si ne reste plus de combat, fin du combat.
    $("#combat").on("victory", "#battle", function(e, monstre, perso) {
        $(this).prop("disabled", true);
        $(".tooltip").remove();
        var log_entry = $("<p>").addClass("log_entry victory").text("Victoire ! " + perso + " a vaincu " + monstre + " !");
        addLogEntry(log_entry);
        if ($("#combat>ul.monstres>li.courant").next("li").length !== 0) {
            $("#cancel").attr("id", "next_battle").text("Prochain adversaire");
        } else {
            $("#cancel").attr("id", "victory").text("Fin du combat");
        }
    });

    // Lors de l'enclenchement de l'évènement défaite, désactivation du bouton "Combat" et affichage du message de défaite.
    $("#combat").on("defeat", "#battle", function(e, monstre, perso) {
        removeTooltip($(this));
        var log_entry = $("<p>").addClass("log_entry defeat").text("Défaite... " + monstre + " a vaincu " + perso + "...");
        addLogEntry(log_entry);
        var retry = $("<button>").attr("id", "retry").text("Retenter le combat");
        $("#combat").append(retry);
        $("#cancel").attr("id", "defeat").text("Accepter son destin...");
        $(this).prop("disabled", true);
    });

    // Lors du clic sur le bouton "next battle", passage au monstre suivant et réactivation du bouton "Combat"
    $("#combat").on("click", "#next_battle", function() {
        $("#combat>ul.monstres>li.courant").removeClass("courant").addClass("vaincu").next().addClass("courant");
        $("#battle").prop("disabled", false).focus();
        $(this).attr("id", "cancel").text("Fuir !");
    });

    // Lors du clic sur le bouton "Retenter le combat", suppression du log et remise à zéro des stats monstre et perso
    $("#combat").on("click", "#retry", function() {
        $("#combat>div.log").empty();
        var endurance_monstre = $("#combat>ul.monstres>li>span.endurance");
        endurance_monstre.text(endurance_monstre.data("default"));
        var endurance_perso = $("#endurance>span.actuel");
        endurance_perso.text(endurance_perso.data("default"));
        $("#battle").prop("disabled", false).focus();
        $("#defeat").attr("id", "cancel").text("Fuite !");
        $(this).remove();
    });

    // Lors du clic sur le bouton de fin de combat, sauvegarde du combat dans le log des combats et rechargement de la page.
    $("#combat").on("click", "#victory, #defeat", function() {
        var nom = $("div.centre>h2").text();
        var numero = $("#combat>p:first-child").data("numero");
        saveStatus();
        resetStats();
        if ($(this).attr("id") === "victory") {
            var victoire = 1;
            $("#select_battle>select>option[value=" + numero + "]").remove();
        } else {
            var victoire = 0;
            checkDeath();
        }
        $("#combat>ul.monstres>li").each(function() {
            var id = $("span.monstre_nom", this).data("id");
            $.get("index.php", {
                controller: "Combat",
                action: "addOneForPersona",
                victoire: victoire,
                id: id,
                numero: numero,
                nom: nom
            });
            createCombatLog(victoire, id, numero);
        });
        $("#combat").empty().hide();
        $("#select_battle").show();
    });
});