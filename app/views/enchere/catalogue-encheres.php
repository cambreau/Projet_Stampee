{{ include('layouts/header.php', {
    title: "Catalogue des enchères - Stampee : Site d'enchère de timbre",
}) }}

<article  class="page" id="catalogue-encheres">
    <h1 class="catalogue-timbre__titre">Notre catalogue de timbres</h1>
      <div class="catalogue-timbre">
        <div class="catalogue-timbre__contenu">
          <section class="filtres">
            <h2 class="filtres__titre">Filtres</h2>
            <div class="filtres__categories">
                <buton class="bouton bouton-classique">Par Prix</buton>
                <buton class="bouton bouton-classique">Par Date d'émission </buton>
                <buton class="bouton bouton-classique">Par Pays d'origine</buton>
                <buton class="bouton bouton-classique">Par Statut</buton>
            </div>
          </section>
          <div class="conteneur-timbres">

          </div>
        </div>
      </div>
</article>
      
{{ include('layouts/footer.php') }}