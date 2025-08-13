{{ include('layouts/header.php', {
    title: "Modification du Profil - Stampee : Site d'enchère de timbre",
}) }}

<div class="atricle-centre">
    <section>
        <h1 class="atricle-centre__titre">Modification du profil</h1>
        <form class="form" method="post">

            <div class="form__champ">
                <label for="nom">Nom :</label>
                <input
                    type="text"
                    id="nom"
                    name="nom"
                    placeholder="Entrez votre nom"
                    value="{{membre.nom}}"
                    required
                />
            </div>
            {% if erreurs.nom is defined %}
                <p class="message__erreur">{{erreurs.nom}}</p>
            {%endif %}

            <div class="form__champ">
                <label for="prenom">Prénom :</label>
                <input
                    type="text"
                    id="prenom"
                    name="prenom"
                    placeholder="Entrez votre prénom"
                    value="{{membre.prenom}}"
                    required
                />
            </div>
            {% if erreurs.prenom is defined %}
                <p class="message__erreur">{{erreurs.prenom}}</p>
            {%endif %}

            <div class="form__champ">
                <label for="email">Adresse e-mail :</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Entrez votre e-mail"
                    value="{{membre.email}}"
                    required
                />
            </div>
            {% if erreurs.email is defined %}
                <p class="message__erreur">{{erreurs.email}}</p>
            {%endif %}


            <div class="form__btn-conteneur">
                <a class="bouton bouton-accent" href="{{base}}/accueil">
                    Annuler
                </a>
                <input class="bouton bouton-classique" type="submit" value="Enregistrer">
            </div>
        </form>
    </section>
</div>

{{ include('layouts/footer.php') }}