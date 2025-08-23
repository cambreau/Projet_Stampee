{{ include('layouts/header.php', {
    title: "Timbre - Stampee : Site d'enchère de timbre",
}) }}

<article class="page" id="fiche-detail-enchere">
      <h1>Fiche détaillée du timbre</h1>
      <section class="detail-timbre">
        <div class="detail-timbre__partie">
          <div class="detail-timbre__image-principale">
            <div id="myresult" class="img-zoom-result"></div>
            <picture class="detail-timbre__image-principale__image img-zoom-container">
              <img
                class="img img-bordure" id="myimage";
                src="{{asset}}/images/images-timbre/{{imagePrincipale.lien}}"
                alt="Image principale du timbre {{timbre.nom}}"
              />
            </picture>
          </div> 
          {%if imageTimbre %} 
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
          {% endif %}
        </div>  
        <section class="detail-timbre__partie"> 
          <div>
            <header class="detail-timbre__entete">
                <div class="detail-timbre__premiere-ligne">
                  <h2 class="detail-timbre__titre">
                  {{timbre.nom}}
                  </h2>
                  <a href="#"
                    ><img
                      class="icon alerte-ajout"
                      src="{{asset}}/images/icon/alerte-ajout.webp"
                      alt="Icône alerte" data-timbre-id="{{timbre.id}}"
                  /></a>
                </div>
            </header>
            {%if enchere is defined %}
              <div class="detail-timbre__infos-enchere">
                <div class="detail-timbre__prix">
                  <span class="detail-timbre__prix-label">Prix :</span>
                  <span class="detail-timbre__prix-valeur">{{enchere.prixPlancher}} CAD</span>
                </div>
                <div class="detail-timbre__temps" data-date-fin="{{enchere.dateFin}}" data-date-debut="{{enchere.dateDebut}}">
                  
                </div>
                <div class="detail-timbre__mises" data-enchere-id="{{enchere.id}}" data-membre-id="{{session.membre_id}}">
                  <div class="conteneur-mises">
                    <!-- Genere par JavaScript -->
                  </div>
                </div> 
              </div>  
            {%endif%}
          </div>
          <section class="detail-timbre__details">
                <h3>Les caractéristiques du timbre</h3>
                <ul class="detail-timbre__details__liste">
                  <li class="detail-timbre__details__detail">
                    <span class="detail-timbre__details__intitule">Pays :</span>
                    {{timbre.pays.nom}}
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
                    {{timbre.etat.nom}}
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
                    {{timbre.couleur.nom}}
                  </li>
                  <li class="detail-timbre__details__detail">
                    <span class="detail-timbre__details__intitule"
                      >Dimensions :</span
                    >
                    {{timbre.dimension}}
                  </li>
                </ul>
          </section>
         
        </section>   
      </section>
</article>

{{ include('layouts/footer.php') }}