{{ include('layouts/header.php', {
    title: "Profil - Stampee : Site d'enchère de timbre",
}) }}

<article  class="page" id="profil">
    <div class="profil__entete">
        <h1>{{ membre.nomUtilisateur }}, bienvenue sur votre profil</h1>
        <form method="POST" action="{{ base }}/connexion/deconnexion">
            <input type="submit" value="Se deconnecter" class="bouton bouton-accent"/>
        </form>
    </div>
    <div class="profil__division">
        <section class="profil__section">
            <h2>Mes informations personnelles</h2>
            <div class="profil__liste-informations">
                <p class="profil__information"><span>Nom d'utilisateur :</span> {{ membre.nomUtilisateur }}</p>
                <p class="profil__information"><span>Nom :</span> {{ membre.nom }}</p>
                <p class="profil__information"><span>Prénom :</span> {{ membre.prenom }}</p>
                <p class="profil__information"><span>Adresse courriel :</span> {{ membre.email }}</p>
                <p class="profil__information"><span>Mot de passe :</span> ********</p>
                <div class="profil__conteneur-btn">
                <a class="bouton bouton-classique" href="{{base}}/membre/page-modifier?id={{ membre.id }}">Modifier</a>
                <a class="bouton bouton-accent" href="{{base}}/membre/supprimer?id={{ membre.id }}">Supprimer</a>
            </div>
            </div>
        </section>
        <picture class="profil__image">
            <img src="{{asset}}/images/image-profil.png">
        </picture>
        <section class="profil__section">
            <h2>Mes timbres</h2>
            <div class="conteneur-timbres">
                
            </div>
        </section>
      
</div>
</article>

{{ include('layouts/footer.php') }}