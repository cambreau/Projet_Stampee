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
                    required
                />
            </div>

            <div class="form__champ">
                <label for="nom">Nom :</label>
                <input
                    type="text"
                    id="nom"
                    name="nom"
                    placeholder="Entrez votre nom"
                    required
                />
            </div>

            <div class="form__champ">
                <label for="prenom">Prénom :</label>
                <input
                    type="text"
                    id="prenom"
                    name="prenom"
                    placeholder="Entrez votre prénom"
                    required
                />
            </div>

            <div class="form__champ">
                <label for="email">Adresse e-mail :</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Entrez votre e-mail"
                    required
                />
            </div>

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