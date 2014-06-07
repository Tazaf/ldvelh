{include file='head_content.tpl' assign=head_content}
{include file='nav.tpl' assign=barre_navigation}
{include file='footer.tpl' assign=footer}
<!DOCTYPE html>
<html lang="fr">
    <head>
        {$head_content}
        <!-- CSS et JS pour la barre de naviguation -->
        <link href="css/nav.css" rel="stylesheet" type="text/css" media="all" />
	<script src="js/nav.js" type="text/javascript"></script>
        <!-- CSS et JS pour la fiche de personnage -->
        <link href="css/statut.css" rel="stylesheet" type="text/css" media="all" />
	<script src="js/statut.js" type="text/javascript"></script>
    </head>
    <body>
        {$barre_navigation}
        <div class="centre">
            <button disabled="disabled" class="status_action">Annuler</button>
            <button disabled="disabled" class="status_action">Sauver</button>
            <h3>Caractéristiques</h3>
            <div class="stats">
                <span>Habileté</span>
                <button>- 1</button>
                <span class="actuel">{$personnage->habilete}</span>
                <span class="max">{$personnage->habileteMax}</span>
                <button>+ 1</button>
            </div>
            <div class="stats">
                <span>Endurance</span>
                <button>- 1</button>
                <span class="actuel">{$personnage->endurance}</span>
                <span class="max">{$personnage->enduranceMax}</span>
                <button>+ 1</button>
            </div>
            <div class="stats">
                <span>Chance</span>
                <button>- 1</button>
                <span class="actuel">{$personnage->chance}</span>
                <span class="max">{$personnage->chanceMax}</span>
                <button>+ 1</button>
            </div>
            <h3>Provisions</h3>
            <div>
                <span>Repas</span>
                <button>- 1</button>
                <span class="actuel">{$personnage->repas}</span>
                <button>+ 1</button>
            </div>
            <h3>Bourse</h3>
            <div>
                <span>Pièce(s) d'or</span>
                <input type="text" name="bourse" value="{$personnage->bourse}" class="actuel tooltip_right" maxlength="9" title="Flèche haute : +1 | Flèche basse : -1"/>
            </div>
        </div>
{$footer}