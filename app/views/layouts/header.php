<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{titre}}</title>
    <link rel="icon" href="{{asset}}/images/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Raleway:ital,wght@0,100..1150;1,100..1150&display=swap"
      rel="stylesheet"
    />
    <meta
      name="description"
      content="Catalogue d'enchères de timbres et de cartes postales de collection. Découvrez des enchères passionnantes et enrichissez votre collection avec STAMPEE."
    />
    <meta
      name="keywords"
      content="enchères, timbres, cartes postales, collection, STAMPEE"
    />
    <meta name="author" content="STAMPEE" />
    <link rel="stylesheet" href="{{asset}}/styles/style.css" />
    <script type="module" src="{{asset}}/scripts/index.js"></script>
  </head>
  <body>
    <header class="entete">
      <div class="entete__principale">
        <a href="{{base}}/accueil" class="logo"> 
          <img src="{{asset}}/images/logo-stampee.webp" alt="Logo de STAMPEE" />
        </a>
        <nav class="navigation-principale__responsive">
          <picture class="navigation-principale__bouton-declencheur">
            <img
              class="icon_petit"
              src="{{asset}}/images/icon/menu-hamburger.webp"
              alt="Menu Hamburger"
            />
          </picture>
          <ul class="navigation-principale__menu cache">
            <li>
              <a href="#" class="bouton bouton-accent bouton-menu-responsive"
                ><img
                  class="icon"
                  src="{{asset}}/images/icon/calendrier.webp"
                  alt="icon calendrier"
                />
                Calendrier enchères
              </a>
            </li>
            {% if session.membre_nomUtilisateur is not defined %}
            <li>
            <a class="bouton bouton-classique bouton-menu-responsive" href="{{base}}/connexion/page-connexion"> Connexion </a>
            </li>
            {%endif%}
            <li class="navigation-principale__menu__item">
              <form method="get">
                <label for="devise_responsive" class="cache">Devise</label>
                <select name="devise_responsive" id="devise_responsive">
                  <option value="CAD">$ CAD</option>
                  <option value="EUR">€ Euro</option>
                  <option value="USD">$ US</option>
                  <option value="GBP">£ Livre</option>
                  <option value="JPY">¥ Yen</option>
                </select>
                <button type="submit" class="cache">Changer</button>
              </form>
            </li>
            <li class="navigation-principale__menu__item">
              <form method="get">
                <label for="langue_responsive" class="cache">Langue</label>
                <select name="langue_responsive" id="langue_responsive">
                  <option value="fr">Français</option>
                  <option value="en">English</option>
                  <option value="es">Español</option>
                  <option value="de">Deutsch</option>
                  <option value="it">Italiano</option>
                  <option value="pt">Português</option>
                  <option value="zh">中文</option>
                  <option value="ja">日本語</option>
                </select>
                <button type="submit" class="cache">Changer</button>
              </form>
            </li>
            {% if session.membre_nomUtilisateur is defined %}
            <li class="navigation-principale__menu__item">
              <a href="{{base}}/membre/profil">Profil</a>
            </li>
            <li class="navigation-principale__menu__item">
              <a href="#">Mes alertes</a>
            </li>
            {%endif%}
            <li class="navigation-principale__menu__item">
              <a href="{{base}}/accueil">Accueil</a>
            </li>
            <li class="navigation-principale__menu__item">
              <a href="#">À propos du Lord Stampee</a>
            </li>
            <li class="navigation-principale__menu__item">
              <a href="#">Nos timbres</a>
            </li>
            <li class="navigation-principale__menu__item">
              <a href="#">Demander une expertise</a>
            </li>
            <li class="navigation-principale__menu__item">
              <a href="#">Nous contacter</a>
            </li>
          </ul>
        </nav>
        <form class="recherche" method="get">
          <label for="recherche" class="cache">Recherche</label>
          <input
            id="recherche"
            name="recherche"
            type="text"
            placeholder="Quel timbre cherchez-vous?"
          />
          <button class="recherche__bouton" type="submit">
            <img
              src="{{asset}}/images/icon/loupe.webp"
              alt="Icône de recherche"
              class="img recherche__bouton__loupe"
            />
          </button>
        </form>

        <div class="entete__actions">
          <a href="#" class="bouton bouton-accent"
            ><img
              class="icon"
              src="{{asset}}/images/icon/calendrier.webp"
              alt="icon calendrier"
            />
            Calendrier enchères
          </a>
          <div class="entete__actions secondaire">
            <form method="get">
              <label for="devise" class="cache">Devise</label>
              <select name="devise" id="devise" class="bouton bouton-fond">
                <option value="CAD">$ CAD</option>
                <option value="EUR">€ Euro</option>
                <option value="USD">$ US</option>
                <option value="GBP">£ Livre</option>
                <option value="JPY">¥ Yen</option>
              </select>
              <button type="submit" class="cache">Changer</button>
            </form>
            <form method="get">
              <label for="langue" class="cache">Langue</label>
              <select name="langue" id="langue" class="bouton bouton-fond">
                <option value="fr">Français</option>
                <option value="en">English</option>
                <option value="es">Español</option>
                <option value="de">Deutsch</option>
                <option value="it">Italiano</option>
                <option value="pt">Português</option>
                <option value="zh">中文</option>
                <option value="ja">日本語</option>
              </select>
              <button type="submit" class="cache">Changer</button>
            </form>
            {% if session.membre_nomUtilisateur is defined %}
            <a class="bouton bouton-fond" href="{{base}}/membre/profil"> Profil </a>
            <a href="#" class="bouton bouton-fond icon"
              ><img
                class="img"
                src="{{asset}}/images/icon/alerte.webp"
                alt="Icône alerte"
            /></a>
            {%endif%}
            {% if session.membre_nomUtilisateur is not defined %}
            <a class="bouton bouton-fond" href="{{base}}/connexion/page-connexion"> Connexion </a>
            {%endif%}
          </div>
        </div>
      </div>
      <nav class="navigation-principale">
        <ul class="navigation-principale__menu">
          <li class="navigation-principale__menu__item">
            <a href="{{base}}/accueil">Accueil</a>
          </li>
          <li class="navigation-principale__menu__item">
            <a href="#">À propos du Lord Stampee</a>
          </li>
          <li class="navigation-principale__menu__item">
            <a href="#">Nos timbres</a>
          </li>
          <li class="navigation-principale__menu__item">
            <a href="#">Demander une expertise</a>
          </li>
          <li class="navigation-principale__menu__item">
            <a href="#">Nous contacter</a>
          </li>
        </ul>
      </nav>
    </header>

    <main>