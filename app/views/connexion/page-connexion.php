{{ include('layouts/header.php', {
    title: "Connexion - Stampee : Site d'enchère de timbre",
}) }}

<section>
    <h1>Connexion</h1>
    <form class="form" method="post">
                <div class="form__champ">
                <label for="email">Adresse e-mail :</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Veuillez entrer votre email"
                    required
                />
                </div>

                <div class="form__champ">
                <label for="motPasse">Mot de passe :</label>
                <input
                    type="password"
                    id="motPasse"
                    name="motPasse"
                    placeholder="Entrez votre mot de passe"
                    required
                />
                </div>

            <div class="form__btn-conteneur">
                <a class="bouton bouton-accent" href="{{base}}/accueil">
                Annuler
                </a>
                <input class="bouton bouton-classique" value="Se connecter" type="submit">
            </div>
    </form>
</section>
<div>
    <p>Pas encore membre ?</p>
    <a class="bouton bouton-classique" href="{{base}}/membre/page-inscription">
                Annuler
    </a>
</div>

{{ include('layouts/footer.php') }}