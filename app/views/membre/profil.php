{{ include('layouts/header.php', {
    title: "Profil - Stampee : Site d'enchère de timbre",
}) }}

<article>
    <h1>{{ membre.nomUtilisateur }}, bienvenue sur votre profil</h1>
    <form method="POST" action="{{ base }}/connexion/deconnexion">
        <input type="submit" value="Se deconnecter" class="bouton bouton-accent"/>
    </form>
    <section class="profil__section">
        <h2>Mes informations personnelles</h2>
        <div class="profil__liste-informations">
            <p class="profil__information"><span>Nom d'utilisateur :</span> {{ membre.nomUtilisateur }}</p>
            <p class="profil__information"><span>Nom :</span> {{ membre.nom }}</p>
            <p class="profil__information"><span>Prénom :</span> {{ membre.prenom }}</p>
            <p class="profil__information"><span>Adresse courriel :</span> {{ membre.email }}</p>
            <p class="profil__information"><span>Mot de passe :</span> ********</p>
            <div class="profil__conteneur-btn">
            <a class="bouton bouton-classique" href="/membre/page-modifier?id={{ membre.id }}">Modifier</a>
            <a class="bouton bouton-accent" href="/membre/supprimer?id={{ membre.id }}">Supprimer</a>
        </div>
        </div>
       
    </section>
</article>

{{ include('layouts/footer.php') }}