        <div id="small_title">
            <p><a href="index.php?controller=Personnage&action=showAll" title="Retour à la sélection du personnage"><span>LD<span>V</span>ELH</span></a> - Le Labyrinthe de la Mort</p>
        </div>
        <div id="dice_popup" class="popup_block">
            <h1>Lancer de dés</h1>
            <p>
                <label>Nombre (1~9) de D6 : </label>
                <input type="text" maxlength="1" placeholder="0" />
            </p>
            <button>Lancer</button>
            <h2>Résultats</h2>
            <div>
                <div>
                </div>
                <span>??</span>
                <div>Total</div>
            </div>
            <button>Quitter</button>
        </div>
        <nav>
            <ul class="centre">
                <li {if $onglet eq 'statut'}class="actif"{/if} title="Afficher le statut de {$personnage->nom|escape: 'html'}"><a href="index.php?controller=Personnage&action=showStatus&nom={$personnage->nom|escape: 'url'}">Statut</a></li>
                <li {if $onglet eq 'sac'}class="actif"{/if} title="Afficher le contenu du sac de {$personnage->nom|escape: 'html'}"><a href="index.php?controller=SacADos&action=showBagContent&nom={$personnage->nom|escape: 'url'}">Sac</a></li>
                <li {if $onglet eq 'combat'}class="actif"{/if} title="Afficher les combats de {$personnage->nom|escape: 'html'}"><a href="index.php?controller=Combat&action=showCombatLog&nom={$personnage->nom|escape: 'url'}">Combat</a></li>
                <li id="dice" class="tooltip_right" title="Effectuer un ou des lancers de D6">Dés</li>
            </ul>
        </nav>
        <div class="centre">
            <h2>{$personnage->nom|escape: 'html'}</h2>
            {if $onglet neq 'statut'}
            <div id="fast_stat">
                <div id="habilete"><span class="actuel">{$personnage->habilete}</span><span class="max">{$personnage->habileteMax}</span></div>
                <div id="endurance"><span class="actuel">{$personnage->endurance}</span><span class="max">{$personnage->enduranceMax}</span></div>
                <div id="chance"><span class="actuel">{$personnage->chance}</span><span class="max">{$personnage->chanceMax}</span></div>
            </div>
            {/if}
        </div>