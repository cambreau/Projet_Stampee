{{ include('layouts/header.php', {
    title: "Erreur 404",
}) }}

<section class="erreur404">
    <h1 class="erreur404__titre">Erreur 404</h1>
    <p class="erreur404__message">{{message}}</p>
    <picture class="erreur404__illustration">
        <img src="{{asset}}/images/error-404.png" alt="Illustration de la page erreur 404">
    </picture>
</section>

{{ include('layouts/footer.php') }}