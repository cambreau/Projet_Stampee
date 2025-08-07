{{ include('layouts/header.php', {
    title: "Stampee : Site d'enchère de timbre",
}) }}

<h1>Bienvenue {{session.membre_nomUtilisateur}}</h1>

{{ include('layouts/footer.php') }}