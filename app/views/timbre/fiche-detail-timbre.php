{{ include('layouts/header.php', {
    title: "Timbre - Stampee : Site d'enchère de timbre",
}) }}

      <h1>Fiche détaillée du timbre</h1>
      <section class="detail-timbre">
        <div class="detail-timbre__images-btn">
          <div class="detail-timbre__images">
            <picture class="detail-timbre__image-principale">
              <img
                class="img img-bordure"
                src="{{asset}}/images/images-timbre/{{imagePrincipale.lien}}"
                alt="Image principale du timbre {{timbre.nom}}"
              />
            </picture>
            <div class="detail-timbre__galerie">
            {%for image in imageTimbre %}
              <picture class="detail-timbre__galerie__miniature">
                <img
                  class="img img-bordure"
                  src="{{asset}}/images/images-timbre/{{image.lien}}"
                  alt="Image miniature du timbre {{timbre.nom}}"
              /></picture>
            {%endfor%}
            </div>
          </div>
          <form class="form-offre">
            <label for="offre" class="cache">Offre</label>
            <input
              class="bouton-grand"
              type="number"
              id="offre"
              name="offre"
              placeholder="Votre offre en CAD"
              min="1"
              step="0.01"
              required
            />
            <button class="bouton bouton-accent bouton-grand">
              Faire une offre
            </button>
          </form>
        </div>
        <div class="detail-timbre__infos">
          <header class="detail-timbre__entete">
            <div class="detail-timbre__premiere-ligne">
              <h2 class="detail-timbre__titre">
              {{timbre.nom}}
              </h2>
              <a href="#"
                ><img
                  class="icon"
                  src="{{asset}}/images/icon/alerte-ajout.webp"
                  alt="Icône alerte"
              /></a>
            </div>
          </header>
          <div class="detail-timbre__infos__contenu">
            <div class="detail-timbre__prix">
              <span class="detail-timbre__prix-label">Prix :</span>
              <span class="detail-timbre__prix-valeur">75 CAD CAD</span>
            </div>
            <div class="detail-timbre__compteur">
              Enchère se termine dans :
              <span class="detail-timbre__temps">⏳ 2j : 1h : 39 m</span>
            </div>
            <section class="detail-timbre__details">
              <h3>Les caractéristiques du timbre</h3>
              <ul class="detail-timbre__details__liste">
                <li class="detail-timbre__details__detail">
                  <span class="detail-timbre__details__intitule">Pays :</span>
                  {{timbre.pays}}
                </li>
                <li class="detail-timbre__details__detail">
                  <span class="detail-timbre__details__intitule"
                    >Date d’émission :</span
                  >
                  {{timbre.dateEmission}}
                </li>
                <li class="detail-timbre__details__detail">
                  <span class="detail-timbre__details__intitule"
                    >Condition :</span
                  >
                  {{timbre.etat}}
                </li>
                <li class="detail-timbre__details__detail">
                  <span class="detail-timbre__details__intitule"
                    >Certifié :</span
                  >
                  Oui
                </li>
                <li class="detail-timbre__details__detail">
                  <span class="detail-timbre__details__intitule">Tirage :</span>
                  {{timbre.tirage}}
                </li>
                <li class="detail-timbre__details__detail">
                  <span class="detail-timbre__details__intitule"
                    >Couleurs :</span
                  >
                  {{timbre.couleur}}
                </li>
                <li class="detail-timbre__details__detail">
                  <span class="detail-timbre__details__intitule"
                    >Dimensions :</span
                  >
                  {{timbre.dimensions}}
                </li>
              </ul>
            </section>
          </div>
        </div>
      </section>

{{ include('layouts/footer.php') }}