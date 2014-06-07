{include file='head_content.tpl' assign=head_content}
{include file='footer.tpl' assign=footer}
<!DOCTYPE html>
<html lang="fr">
    <head>
        {$head_content}
        <link href="css/personnage.css" rel="stylesheet" type="text/css" media="all" />
	<script src="js/personnage.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="big_title">
            <p>un livre</p>
            <p>dont <span>vous</span> &ecirc;tes</p>
            <p>le h&eacute;ros</p>
        </div>
        <h3 class="centre">d&eacute;fis fantastiques /5</h3>
        <h2 class="centre">Le Labyrinthe de la Mort</h2>
        <ul id="personnages" class="centre">
            <li id="new" tabindex="1"><span>+</span>G&eacute;n&eacute;rer un nouveau personnage</li>
            {foreach $perso_vivants as $position => $perso_vivant}
                <li tabindex="{$position + 2}">
                    <div class="nom">{$perso_vivant->nom|escape: 'html'}<span class="tooltip_right" title="Supprimer {$perso_vivant->nom|default:"le personnage"}">Supprimer</span></div>
                    <div class="stats">
                        <div title="Habileté/Habileté Maximum">
                            <span>{$perso_vivant->habilete}</span>/<span class="max">{$perso_vivant->habileteMax}</span>
                            <div>Habilet&eacute;</div>
                        </div>
                        <div title="Endurance/Endurance Maximum">
                            <span>{$perso_vivant->endurance}</span>/<span class="max">{$perso_vivant->enduranceMax}</span>
                            <div>Endurance</div>
                        </div>
                        <div title="Chance/Chance Maximum">
                            <span>{$perso_vivant->chance}</span>/<span class="max">{$perso_vivant->chanceMax}</span>
                            <div>Chance</div>
                        </div>
                    </div>
                    <a href="index.php?controller=Personnage&action=showStatus&nom={$perso_vivant->nom|escape: 'url'}" title="Continuer l'aventure avec {{$perso_vivant->nom}|default:"ce personnage"}" tabindex="-1" class="tooltip_right">À l'aventure !</a>
                </li>
            {/foreach}
            {if count($perso_vivants) == 0}
                <li id="no_perso">Aucun aventurier vivant dans les parages...</li>
            {/if}
        </ul>
        <p class="centre">Cimeti&egrave;re</p>
        <ul id="perso_mort" class="centre">
            {foreach $perso_morts as $position => $perso_mort}
            <li tabindex="{$position + 2}">
                <div class="nom">{$perso_mort->nom|escape: 'html'}<span class="tooltip_right" title="Oublier {$perso_mort->nom|default:"le personnage"}">Supprimer</span></div>
                <div class="stats">
                    <div title="Habileté au moment de la mort">
                        <span>{$perso_mort->habilete}</span>/<span class="max">{$perso_mort->habileteMax}</span>
                        <div>Habilet&eacute;</div>
                    </div>
                    <div title="{$perso_mort->nom|default:"Ce personnage"} n'a plus d'endurance">
                        <span>Mort</span>
                        <div>Endurance</div>
                    </div>
                    <div title="Chance au moment de la mort">
                        <span>{$perso_mort->chance}</span>/<span class="max">{$perso_mort->chanceMax}</span>
                        <div>Chance</div>
                    </div>
                </div>
                <a href="index.php?controller=Personnage&action=showStatus&nom={$perso_mort->nom|escape: 'url'}" title="Consulter l'état de {{$perso_mort->nom}|default:"ce personnage"} à sa mort" tabindex="-1" class="tooltip_right">&Eacute;tat</a>
            </li>
            {/foreach}
            {if count($perso_morts) == 0}
                <li id="no_perso">Le Cimeti&egrave;re est vide... pour l'instant...</li>
            {/if}
        </ul>
        <div class="popup_block" id="new_popup">
            <h1>Nouveau personnage</h1>
            <p title="Habileté : 1d6 + 6, Endurance : 2d6 + 12, Chance : 1d6 +6">Les statistiques du nouveau personnage seront tir&eacute;es au hasard lors de sa cr&eacute;ation.</p>
            <form action="index.php" method="get">
                <h2>Nommez votre aventurier</h2>
                <input title="Insensible à la casse et aux accents" type="text" name="nom" placeholder="Nom" required tabindex="{count($perso_vivants) + 2}" />
                <h2>Choisissez sa potion magique <span>(ira dans le Sac)</span></h2>
                <div class="potions selected" tabindex="{count($perso_vivants) + 3}">
                    <input type="radio" name="potion" value="1" checked="checked" />
                    <img src="./css/img/potionH.png" alt="Potion d'Adresse" />
                    <div>
                        <h3>Potion d'Adresse (x2)</h3>
                        <ul>
                            <li>Rend tous les points de <span class="habilete">Habilet&eacute;</span></li>
                            <li>Utilisable &agrave; n'importe quel moment de l'aventure.</li>
                        </ul>
                    </div>
                </div>
                <div class="potions" tabindex="{count($perso_vivants) + 4}">
                    <input type="radio" name="potion" value="2" />
                    <img src="./css/img/potionE.png" alt="Potion d'Adresse" />
                    <div>
                        <h3>Potion de Vigueur (x2)</h3>
                        <ul>
                            <li>Rend tous les points de <span class="endurance">Endurance</span></li>
                            <li>Utilisable &agrave; n'importe quel moment de l'aventure.</li>
                        </ul>
                    </div>
                </div>
                <div class="potions" tabindex="{count($perso_vivants) + 5}">
                    <input type="radio" name="potion" value="3" />
                    <img src="./css/img/potionC.png" alt="Potion d'Adresse" />
                    <div>
                        <h3>Potion de Bonne Fortune (x2)</h3>
                        <ul>
                            <li><span>+ 1</span> &agrave; <span class="chance">Chance Max</span></li>
                            <li>Rend tous les points de <span class="chance">chance</span></li>
                            <li>Utilisable &agrave; n'importe quel moment de l'aventure.</li>
                        </ul>
                    </div>
                </div>
                <input type="hidden" value="Personnage" name="controller" />
                <input type="hidden" value="createNew" name="action" />
                <input type="hidden" value="2" name="quantite" />
                <input type="reset" value="En fait... non" tabindex="{count($perso_vivants) + 7}"/>
                <input type="submit" value="C'est parti !" tabindex="{count($perso_vivants) + 6}"/>
            </form>
        </div>
{$footer}