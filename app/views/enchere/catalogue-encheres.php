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
                <buton class="bouton bouton-classique">Par prix</buton>
                <buton class="bouton bouton-classique">Par date d'émission </buton>
                <buton class="bouton bouton-classique">Par pays d'origine</buton>
                <buton class="bouton bouton-classique">Par statut</buton>
            </div>
          </section>
          <div class="conteneur-timbres">

          </div>
        </div>
      </div>
</article>
      
{{ include('layouts/footer.php') }}