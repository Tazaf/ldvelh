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
        <link href="css/sac.css" rel="stylesheet" type="text/css" media="all" />
	<script src="js/sac.js" type="text/javascript"></script>
    </head>
    <body>
        {$barre_navigation}
        <div class="centre">
            <button id="equip">Ajouter un objet au sac</button>
            <form id="new_equip" action="index.php" method="get">
                <select name="possession_id">
                    <optgroup id="possession_potions" label="Potions">
                    </optgroup>
                    <optgroup id="possession_equip" label="Équipements">
                    </optgroup>
                    <optgroup id="possession_bijoux" label="Bijoux">
                    </optgroup>
                </select>
                <label class="tooltip_right" title="99 max." for="quantite">Quantité</label>
                <input class="tooltip_right" title="99 max." type="text" name="quantite" maxlength="2" value="1" required />
                <input type="hidden" name="controller" value="SacADos" />
                <input type="hidden" name="action" value="addPossession" />
                <input type="hidden" name="nom" value="{$personnage->nom|escape: 'url'}" />
                <input type="submit" value="Ajouter" />
                <input type="reset" value="Annuler" />
            </form>
            <h3>Potion(s)</h3>
            {foreach $contenu as $emplacement}
                {if $emplacement.possession->type eq "potion"}
                    <div class="{$emplacement.possession->type}">
                        <div class="nom" data-rel="{$emplacement.possession->id}">{$emplacement.possession->nom}<span class="quantite">{$emplacement.quantite}</span></div>
                        {if count($emplacement.possession->effets) > 0}
                            <ul>
                                {foreach $emplacement.possession->effets as $effet}
                                    {if $effet->valeur eq 0}
                                        <li>Rend tous les points de <span class="{$effet->caracteristique}">{$effet->caracteristique}</span></li>
                                    {else}
                                    <li>{$effet->modificateur} {$effet->valeur} à <span class="{$effet->caracteristique}">{$effet->caracteristique}</span></li>
                                    {/if}
                                {/foreach}
                            </ul>
                            <div class="use">Utiliser</div>
                        {else}
                            <ul>
                                <li>Aucun effet</li>
                            </ul>
                            <div class="remove">Retirer</div>
                        {/if}
                   </div>
                {/if}
            {/foreach}
            <h3>Équipement(s)</h3>
            {foreach $contenu as $emplacement}
                {if $emplacement.possession->type eq "equipement"}
                    <div class="{$emplacement.possession->type}">
                        <div class="nom" data-rel="{$emplacement.possession->id}">{$emplacement.possession->nom}<span class="quantite">{$emplacement.quantite}</span></div>
                        <ul>
                        {if count($emplacement.possession->effets) > 0}
                            {foreach $emplacement.possession->effets as $effet}
                                {if $effet->valeur eq 0}
                                    <li>Rends tous les points de <span class="{$effet->caracteristique}">{$effet->caracteristique}</span></li>
                                {else}
                                <li>{$effet->modificateur} {$effet->valeur} à <span class="{$effet->caracteristique}">{$effet->caracteristique}</span></li>
                                {/if}
                            {/foreach}
                        {else}
                            <li>Aucun effet</li>
                        {/if}
                        </ul>
                        <div class="remove">Retirer</div>
                   </div>
                {/if}
            {/foreach}
            <h3>Bijou(x)</h3>
            {foreach $contenu as $emplacement}
                {if $emplacement.possession->type eq "bijoux"}
                    <div class="{$emplacement.possession->type}">
                        <div class="nom" data-rel="{$emplacement.possession->id}">{$emplacement.possession->nom}<span class="quantite">{$emplacement.quantite}</span></div>
                        <ul>
                        {if count($emplacement.possession->effets) > 0}
                            {foreach $emplacement.possession->effets as $effet}
                                {if $effet->valeur eq 0}
                                    <li>Rends tous les points de <span class="{$effet->caracteristique}">{$effet->caracteristique}</span></li>
                                {else}
                                <li>{$effet->modificateur} {$effet->valeur} à <span class="{$effet->caracteristique}">{$effet->caracteristique}</span></li>
                                {/if}
                            {/foreach}
                        {else}
                            <li>Aucun effet</li>
                        {/if}
                        </ul>
                        <div class="remove">Retirer</div>
                   </div>
                {/if}
            {/foreach}
        </div>
{$footer}