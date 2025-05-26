<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
jQuery(document).ready(function( $ ){ //Chargement de la page	
// Fonction pour ajouter un bloc div invisible avant un autre élément
function ajouterDivInvisibleAvant(elementCible) {
    // Créer un nouvel élément div
    var nouveauDiv = document.createElement('div');

    // Appliquer la classe 'sticky-marker' au nouveau div
    nouveauDiv.className = 'sticky-marker';

    // Appliquer le style pour rendre le div visible
    nouveauDiv.style.display = 'block'; // S'assurer qu'il a une dimension visible

    // Insérer le div juste avant l'élément cible
    elementCible.parentNode.insertBefore(nouveauDiv, elementCible);
}


// Fonction pour gérer le scroll et l'ajout/retrait de la classe is-sticky
function gererScroll() {

// Sélectionner tous les sticky-widgets, le sticky-marker, le footer, ainsi que les éléments primary, secondary, et main-navigation
var stickyWidgets = document.querySelectorAll('.sticky-widget');
var stickyMarker = document.querySelector('.sticky-marker');
var footer = document.querySelector('.site-footer');  // Sélectionner le footer avec la classe site-footer
var primary = document.getElementById('primary');  // Élément avec l'ID primary
var secondary = document.getElementById('secondary');  // Élément avec l'ID secondary
var mainNavigation = document.querySelector('.main-navigation');  // Sélectionner l'élément avec la classe main-navigation

// Obtenir l'élément précédent de sticky-marker
var previousElement = stickyMarker.previousElementSibling;
var styles = window.getComputedStyle(previousElement);

// Obtenir dynamiquement les marges-bottom de l'élément précédent du sticky-marker
var espaceEntreWidgets = parseFloat(styles.marginBottom);  // Utiliser le margin-bottom comme écart entre les widgets
var margeAvantFooter = parseFloat(styles.marginBottom);  // Utiliser la même valeur comme marge avant le footer

// Ajouter la hauteur de la main-navigation
var hauteurMainNavigation = mainNavigation ? mainNavigation.offsetHeight : 0;

// Initialiser la hauteur cumulative avec la hauteur de la navigation et l'espacement des widgets
var hauteurCumulativeBase = hauteurMainNavigation + espaceEntreWidgets;

if (stickyWidgets.length > 0 && stickyMarker && footer && primary && secondary) {
    // Fonction de gestion du scroll
    window.addEventListener('scroll', function() {
        // Vérifier si la page est petite ou grande en comparant les hauteurs de primary et secondary
        var pageEstPetite = primary.offsetHeight <= secondary.offsetHeight;

        if (pageEstPetite) {
            // Si la page est petite, désactiver le sticky
            stickyWidgets.forEach(function(stickyWidget) {
                stickyWidget.classList.remove('is-sticky');
                stickyWidget.style.position = '';  // Réinitialiser la position
                stickyWidget.style.top = '';  // Réinitialiser la position top
                stickyWidget.style.width = '';  // Réinitialiser la largeur
            });
            return;  // Ne pas exécuter le reste du code si la page est petite
        }

        // Si sticky-marker est au-dessus ou atteint le viewport
        var stickyMarkerPosition = stickyMarker.getBoundingClientRect();
        var footerPosition = footer.getBoundingClientRect();
        var distanceDepuisHaut = stickyMarkerPosition.top;

        var hauteurPage = window.innerHeight || document.documentElement.clientHeight;  // Hauteur du viewport

        // Réinitialiser la hauteur cumulative à chaque scroll pour éviter l'accumulation incorrecte
        var hauteurCumulative = hauteurCumulativeBase;

        if (distanceDepuisHaut <= hauteurCumulative) {
            stickyWidgets.forEach(function(stickyWidget, index) {
                var largeurInitiale = stickyWidget.offsetWidth;  // Conserver la largeur actuelle
                var hauteurWidget = stickyWidget.offsetHeight;

                // Ajouter la classe is-sticky
                stickyWidget.classList.add('is-sticky');
                stickyWidget.style.width = largeurInitiale + 'px';  // Fixer la largeur au moment où is-sticky est ajouté
                stickyWidget.style.position = 'fixed';  // Appliquer la position fixe
                stickyWidget.style.top = hauteurCumulative + 'px';  // Utiliser la valeur dynamique de hauteurCumulative

                // Gestion du premier widget
                if (index === 0) {
                    var secondWidget = stickyWidgets[1];  // Obtenir le second widget
                    var secondWidgetTop = parseFloat(secondWidget.style.top);

                    // Calculer la limite où le premier widget doit s'arrêter (juste avant le second widget)
                    var positionLimite = secondWidgetTop - hauteurWidget - espaceEntreWidgets;

                    if (hauteurCumulative >= positionLimite) {
                        // Bloquer le premier widget avant le second widget
                        stickyWidget.style.top = positionLimite + 'px';
                    }
                }

                // Gestion du second widget (dernier)
                if (index === 1) {
                    var widgetBottomPosition = hauteurCumulative + hauteurWidget;

                    // Vérifier si le second widget doit se bloquer avant le footer
                    if (footerPosition.top <= widgetBottomPosition + margeAvantFooter) {
                        // Bloquer le second widget juste avant le footer
                        stickyWidget.style.top = (footerPosition.top - hauteurWidget - margeAvantFooter) + 'px';
                    } else {
                        // Sinon, il reste à sa position normale
                        stickyWidget.style.top = hauteurCumulative + 'px';
                    }
                }

                // Ajouter la hauteur du widget actuel + l'espace entre les widgets à la hauteur cumulative
                hauteurCumulative += hauteurWidget + espaceEntreWidgets;
            });
        } else {
            // Retirer la classe is-sticky et réinitialiser la largeur en pourcentage
            stickyWidgets.forEach(function(stickyWidget) {
                stickyWidget.classList.remove('is-sticky');
                stickyWidget.style.position = '';  // Réinitialiser la position
                stickyWidget.style.top = '';  // Réinitialiser la position top
                stickyWidget.style.width = '';  // Réinitialiser la largeur pour récupérer le style dynamique
            });
        }
    });
}


}

// Sélectionner le premier élément avec la classe 'sticky-widget'
var elementCible = document.querySelector('.sticky-widget');

if (elementCible) {
    // Ajouter le div invisible avant sticky-widget
    ajouterDivInvisibleAvant(elementCible);

    // Sélectionner le sticky-marker
    var stickyMarker = document.querySelector('.sticky-marker');

gererScroll();

} else {
    console.log("Aucun élément avec la classe 'sticky-widget' n'a été trouvé.");
}
});</script>
<!-- end Simple Custom CSS and JS -->
