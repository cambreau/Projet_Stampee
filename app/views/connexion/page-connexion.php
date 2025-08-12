{{ include('layouts/header.php', {
    title: "Connexion - Stampee : Site d'enchère de timbre",
}) }}

<div class="atricle-centre">
    <section >
        <h1 class="atricle-centre__titre">Connexion</h1>
        <section class="message">
            {% if msgCreation is defined %}
                <p class="message__contenu message__succes"><img class="icon" src="{{asset}}/images/icon/succes.png" alt="logo succes">{{msgCreation}}</p>
            {%endif%}
            {% if message is defined %}
                <p class="message__contenu message__erreur"><img class="icon" src="{{asset}}/images/icon/erreur.png" alt="logo erreur">{{message}}</p>
            {%endif%}
        </section>
        <form class="form" method="post" action="/connexion/page-connexion">
            <div class="form__champ">
                <label for="email">Nom d'utilisateur :</label>
                <input
                    type="text"
                    id="nomUtilisateur"
                    name="nomUtilisateur"
                    placeholder="Votre nom d'utilisateur"
                    required
                />
            </div>
            {% if erreurs.nomUtilisateur is defined %}
                <p class="message__erreur">{{erreurs.nomUtilisateur}}</p>
            {%endif %}

            <div class="form__champ">
                <label for="motPasse">Mot de passe :</label>
                <input
                    type="password"
                    id="motDePasse"
                    name="motDePasse"
                    placeholder="Entrez votre mot de passe"
                    required
                />
            </div>
            {% if erreurs.motDePasse is defined %}
              <p class="message__erreur">{{erreurs.motDePasse}}</p>
            {%endif %}

            <div class="form__btn-conteneur">
                <a class="bouton bouton-accent" href="{{base}}/accueil">
                    Annuler
                </a>
                <input class="bouton bouton-classique" value="Se connecter" type="submit">
            </div>
        </form>
    </section>
    <p class="atricle-centre__inscription">Pas encore membre ?</p>
    <a class="bouton bouton-classique bouton-medium" href="{{base}}/membre/page-inscription">
                S'inscrire
    </a>
</div>

{{ include('layouts/footer.php') }}