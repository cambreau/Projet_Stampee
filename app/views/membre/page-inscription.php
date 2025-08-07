{{ include('layouts/header.php', {
    title: "Inscription - Stampee : Site d'enchère de timbre",
}) }}

<div class="page-inscription">
    <section>
        <h1 class="page-inscription__titre">Inscription</h1>
        <form class="form" method="post" action="">
            <div class="form__champ">
                <label for="nomUtilisateur">Nom d'utilisateur :</label>
                <input
                    type="text"
                    id="nomUtilisateur"
                    name="nomUtilisateur"
                    placeholder="Choisissez un nom d'utilisateur"
                    {% if membre.nomUtilisateur is defined %}
                        value="{{membre.nomUtilisateur}}"
                    {%endif %}
                    required
                />
            </div>
            {% if erreurs.nomUtilisateur is defined %}
                <p class="message__erreur">{{erreurs.nomUtilisateur}}</p>
            {%endif %}

            <div class="form__champ">
                <label for="nom">Nom :</label>
                <input
                    type="text"
                    id="nom"
                    name="nom"
                    placeholder="Entrez votre nom"
                    {% if membre.nom is defined %}
                        value="{{membre.nom}}"
                    {%endif %}
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
                    {% if membre.prenom is defined %}
                        value="{{membre.prenom}}"
                    {%endif %}
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
                    {% if membre.email is defined %}
                        value="{{membre.email}}"
                    {%endif %}
                    required
                />
            </div>
            {% if erreurs.email is defined %}
                <p class="message__erreur">{{erreurs.email}}</p>
            {%endif %}

            <div class="form__champ">
                <label for="motDePasse">Mot de passe :</label>
                <input
                    type="password"
                    id="motDePasse"
                    name="motDePasse"
                    placeholder="Choisissez un mot de passe"
                    required
                />
            </div>
            {% if erreurs.motDePasse is defined %}
                <p class="message__erreur">{{erreurs.motDePasse}}</p>
            {%endif %}

            <div class="form__champ">
                <label for="confirmationMotPasse">Confirmez le mot de passe :</label>
                <input
                    type="password"
                    id="confirmationMotPasse"
                    name="confirmationMotPasse"
                    placeholder="Confirmez votre mot de passe"
                    required
                />
            </div>
            {% if erreurs.confirmationMotPasse is defined %}
                <p class="message__erreur">{{erreurs.confirmationMotPasse}}</p>
            {%endif %}

            <div class="form__btn-conteneur">
                <a class="bouton bouton-accent" href="{{base}}/accueil">
                    Annuler
                </a>
                <input class="bouton bouton-classique" type="submit" value="S'inscrire">
            </div>
        </form>
    </section>
</div>

{{ include('layouts/footer.php') }}