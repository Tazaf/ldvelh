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
        <link href="css/combat.css" rel="stylesheet" type="text/css" media="all" />
	<script src="js/combat.js" type="text/javascript"></script>
    </head>
    <body>
        {$barre_navigation}
        <div class="centre">
            <div id="select_battle">
                <label for="paragraphes">Paragraphe n° </label>
                <select name="paragraphe">
                    {foreach $paragraphes as $paragraphe}
                    <option value="{$paragraphe.numero}">{$paragraphe.numero}</option>
                    {/foreach}
                </select>
                <button>Démarrer le combat</button>
            </div>
            <div id="combat"></div>
            <div id="combat_log">
                {if count($combat_log) eq "0"}
                <div id="no_combat">{$personnage->nom|escape: 'html'} n'a pas encore combattu.</div>
                {/if}
                {foreach $combat_log as $combat}
                <div>
                    {if $combat.victoire eq "1"}
                    <p class="victoire">Victoire !</p>
                    <p>A vaincu <span class="monstre_nom">{$combat.nom}</span> <span class="habilete">{$combat.habilete}</span><span class="endurance">{$combat.endurance}</span> au paragraphe {$combat.paragraphe_numero}</p>
                    {else}
                    <p class="defaite">Défaite...</p>
                    <p>A été vaincu par <span class="monstre_nom">{$combat.nom}</span> <span class="habilete">{$combat.habilete}</span><span class="endurance">{$combat.endurance}</span> au paragraphe {$combat.paragraphe_numero}</p>
                    {/if}
                </div>
                {/foreach}
            </div>
        </div>
{$footer}