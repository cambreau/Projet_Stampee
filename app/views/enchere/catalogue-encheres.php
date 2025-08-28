{{ include('layouts/header.php', {
    title: "Catalogue des enchères - Stampee : Site d'enchère de timbre",
}) }}

<article  class="page" id="catalogue-encheres">
    <h1 class="catalogue-enchere__titre">Notre catalogue des enchères</h1>
      <div class="catalogue-enchere">
        <div class="catalogue-enchere__contenu">
          <section class="filtres">
            <h2 class="filtres__titre">Filtres</h2>
            <div class="filtres__categories">
              <form class="form-filtres">
                <!-- Statut -->
                <fieldset>
                  <legend>Statut de l'enchère <svg width="30" height="30" viewBox="0 0 24 24">
                    <path d="M7 10l5 5 5-5H7z"/>
                  </svg>
                </legend>
                  <div class="filtre__toogle-liste cache" data-ouvert="false">
                      <label class="filtre__option">
                        <input class="parIndex" type="checkbox" name="statut" data-filtre-sur="enchere" value="En cours">
                         En cours
                      </label>
                      <label class="filtre__option">
                        <input class="parIndex" type="checkbox" name="statut" data-filtre-sur="enchere" value="À venir">
                        À venir
                      </label>
                      <label class="filtre__option">
                        <input class="parIndex" type="checkbox" name="statut" data-filtre-sur="enchere" value="Terminée">
                        Terminée
                      </label>
                  </div>
                </fieldset>
                <!-- Condition -->
                <fieldset>
                  <legend>Condition <svg width="30" height="30" viewBox="0 0 24 24">
                    <path d="M7 10l5 5 5-5H7z"/>
                  </svg>
                </legend>
                  <div class="filtre__toogle-liste cache" data-ouvert="false">
                    {%for etat in etats %}
                      <label class="filtre__option">
                        <input class="parIndex" data-filtre-sur="timbre" type="checkbox" name="etatId" value="{{etat.id}}">
                      {{etat.nom}}
                      </label>
                    {%endfor%}
                  </div>
                </fieldset>
                <!-- Couleur -->
                <fieldset>
                  <legend>Couleur <svg width="30" height="30" viewBox="0 0 24 24">
                    <path d="M7 10l5 5 5-5H7z"/>
                  </svg>
                </legend>
                  <div class="filtre__toogle-liste cache" data-ouvert="false">
                    {%for couleur in couleurs %}
                      <label class="filtre__option">
                        <input class="parIndex" data-filtre-sur="timbre" type="checkbox" name="couleursId" value="{{couleur.id}}">
                        {{couleur.nom}}
                      </label>
                    {%endfor%}
                  </div>
                </fieldset>
                <!-- Pays -->
                <fieldset>
                  <legend>Pays <svg width="30" height="30" viewBox="0 0 24 24">
                    <path d="M7 10l5 5 5-5H7z"/>
                  </svg>
                </legend>
                  <div class="filtre__toogle-liste cache" data-ouvert="false">
                    {%for unPays in pays %}
                      <label class="filtre__option">
                        <input class="parIndex" data-filtre-sur="timbre" type="checkbox" name="paysId" value="{{unPays.id}}">
                        {{unPays.nom}}
                      </label>
                    {%endfor%}
                  </div>
                </fieldset>
                <!-- Coup de coeur du Lord -->
                  <label class="filtre__option legend">
                    <input class="parIndex" data-filtre-sur="enchere" type="checkbox" name="coupCoeurLord" value="1" >
                    Coup de coeur du Lord
                  </label> 
                    <!-- Favoris -->
                 {% if session.membre_id is defined %}
                  <label class="filtre__option legend siSession">
                    <input class="parIndex" data-filtre-sur="enchere" type="checkbox" name="favoris" value="1">
                    Favoris
                  </label>
                 {% endif %}
                  <button type="button" class="bouton bouton-classique">Appliquer</button>
                </form>
            </div>
          </section>
          <div class="conteneur-timbres">
            <!-- Genere par JavaScript -->
          </div>
        </div>
      </div>
</article>
      
{{ include('layouts/footer.php') }}