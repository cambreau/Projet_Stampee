{{ include('layouts/header.php', {
    title: "Ajouter un timbre - Stampee : Site d'enchère de timbre",
}) }}
<section>
    <h1>Modification du timbre :</h1>
    <h2>{{timbre.nom}}</h2>
    <form class="form" method="post" enctype="multipart/form-data">  
        <div class="form__champ">
            <label for="dateEmission">Date d'émission :</label>
            <input
                type="date"
                id="dateEmission"
                name="dateEmission"
                value="{{ timbre.dateEmission }}"
                required
            />
        </div>
        {% if erreurs.dateEmission is defined %}
            <p class="message__erreur">{{ erreurs.dateEmission }}</p>
        {% endif %}

        <div class="form__champ">
            <label for="certifie">Certifié :</label>
            <input
                type="checkbox"
                id="certifie"
                name="certifie"
                value="1"
                {% if timbre.certifie is defined and timbre.certifie %}
                    checked
                {% endif %}
            />
        </div>

        <div class="form__champ">
            <label for="tirage">Tirage :</label>
            <input
                type="number"
                id="tirage"
                name="tirage"
                placeholder="Nombre d'exemplaires"
                value="{{ timbre.tirage }}"
                required
            />
        </div>
        {% if erreurs.tirage is defined %}
            <p class="message__erreur">{{ erreurs.tirage }}</p>
        {% endif %}

        <div class="form__champ">
            <label for="dimension">Dimension :</label>
            <input
                type="text"
                id="dimension"
                name="dimension"
                placeholder="Dimensions (ex: 10x15 cm)"
                value="{{ timbre.dimension }}"
                required
            />
        </div>
        {% if erreurs.dimension is defined %}
            <p class="message__erreur">{{ erreurs.dimension }}</p>
        {% endif %}

        <div class="form__champ">
            <label for="couleursId">Couleur :</label>
            <select id="couleursId" name="couleursId">
                <option value="">-- Sélectionnez une couleur --</option>
                {% for couleur in couleurs %}
                    <option value="{{ couleur.id }}"
                        {% if timbre.couleursId is defined and timbre.couleursId == couleur.id %}
                            selected
                        {% endif %}
                    >
                        {{ couleur.nom }}
                    </option>
                {% endfor %}
            </select>
        </div>
        {% if erreurs.couleursId is defined %}
            <p class="message__erreur">{{ erreurs.couleursId }}</p>
        {% endif %}

        <div class="form__champ">
            <label for="paysId">Pays :</label>
            <select id="paysId" name="paysId">
                <option value="">-- Sélectionnez un pays --</option>
                {% for unPays in pays %}
                    <option value="{{ unPays.id }}"
                        {% if timbre.paysId is defined and timbre.paysId == unPays.id %}
                            selected
                        {% endif %}
                    >
                        {{ unPays.nom }}
                    </option>
                {% endfor %}
            </select>
        </div>
        {% if erreurs.paysId is defined %}
            <p class="message__erreur">{{ erreurs.paysId }}</p>
        {% endif %}

    
        <div class="form__champ">
            <label for="etatId">État :</label>
            <select id="etatId" name="etatId">
                <option value="">-- Sélectionnez un état --</option>
                {% for etat in etats %}
                    <option value="{{ etat.id }}"
                        {% if timbre.etatId is defined and timbre.etatId == etat.id %}
                            selected
                        {% endif %}
                    >
                        {{ etat.nom }}
                    </option>
                {% endfor %}
            </select>
        </div>
        {% if erreurs.etatId is defined %}
            <p class="message__erreur">{{ erreurs.etatId }}</p>
        {% endif %}

        <input type="file" id="images" name="images[]" accept="image/*" multiple />
        {% if erreursImage is defined %}
            {% for erreur in erreursImage %}
            <p class="message__erreur">{{ erreur }}</p>
            {% endfor %}
        {% endif %}



        <div class="form__btn-conteneur">
            <a class="bouton bouton-accent" href="{{ base }}/accueil">
                Annuler
            </a>
            <input class="bouton bouton-classique" type="submit" value="Enregistrer">
        </div>
    </form>
</section>

{{ include('layouts/footer.php') }}