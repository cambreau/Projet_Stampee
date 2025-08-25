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
              <!-- Prix -->
                <label for="prixPlancher" class="cache">Prix :</label>
                <select id="prixPlancher" class="bouton bouton-classique">
                  <option value="" disabled selected>Filtrer par prix</option>
                  <option class="filtre-prix" value="true">Par prix croissant</option>
                  <option class="filtre-prix" value="false">Par prix décroissant</option>
                </select>
              <!-- Date -->
                <label for="date" class="cache">Date :</label>
                <select id="date" class="bouton bouton-classique">
                  <option value="" disabled selected>Filtrer par date d'enchère</option>
                  <option value="true">Du plus récent</option>
                  <option value="false">Du moins récent</option>
                </select>
              <!-- Statut -->
                <label for="etat" class="cache">Statut :</label>
                <select id="etat" class="bouton bouton-classique TriIndexAssociatif">
                  <option value="" disabled selected>Filtrer par statut</option>
                </select>
              <!-- Couleurs -->
                <label for="couleur" class="cache">Couleur :</label>
                <select id="couleur" class="bouton bouton-classique TriIndexAssociatif">
                  <option value="" disabled selected>Filtrer par statut</option>
                </select>
              <!-- Pays -->
                <label for="pays" class="cache">Par pays :</label>
                <select id="pays" class="bouton bouton-classique TriIndexAssociatif">
                  <option value="" disabled selected>Filtrer par pays</option>
                </select>
              <!-- Favoris -->
                <button class="bouton bouton-classique filtre-booleen" id="favoris" data-filtre-bool="favoris">Favoris</button>
              <!-- Coup de coeur du lord -->
                <button class="bouton bouton-classique filtre-booleen" id="coupCoeurLord" data-filtre-bool="coupCoeurLord">Coup de cœur du lord</button>
            </div>
          </section>
          <div class="conteneur-timbres">
            <!-- Genere par JavaScript -->
          </div>
        </div>
      </div>
</article>
      
{{ include('layouts/footer.php') }}