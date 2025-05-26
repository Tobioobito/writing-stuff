<?php
/*
Plugin Name: Quote of the Day and Random Quote
Description: A Quote of the Day or a Random Quote on your website
Version: 1.2
Author: Alexandre Vaillant
Author URI: http://welovequotes.net
License: GPL2

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// Ajouter un élément de menu dans l'administration
add_action('admin_menu', 'ajouter_menu_mes_citations');

function ajouter_menu_mes_citations() {
    add_menu_page(
        'Mes Citations',         // Titre de la page
        'Mes Citations',         // Texte du menu
        'manage_options',        // Capacité requise pour accéder au menu
        'mes-citations',         // Slug de la page
        'afficher_page_mes_citations' // Fonction pour afficher la page
    );
}


function calculer_modulos_potentiels() {

  global $wpdb; // Accès à l'objet de la base de données WordPress
   $citations = $wpdb->get_results("SELECT * FROM geE_plugin_citations");

   $jour_annee = date("z"); // Obtient la date en int
   $modulo = $jour_annee % count($citations);
   $modulo_counter = 0;

   foreach ($citations as $citation) {

     if (array_search($citation, $citations)+1 >= $modulo) { //commence à partir du numéro modulo et termine à a la fin de la boucle

       $modulo_actuel = $jour_annee+$modulo_counter;
       $modulo_convert = date("d/m", mktime(0, 0, 0, 1, $modulo_actuel)); //Converti le modulo en date
       $citation->modulo = $modulo_convert;
       $citation->modulo_sort = $modulo_actuel;
       $modulo_counter++;

     }
   }
    foreach ($citations as $citation) {

      if (array_search($citation, $citations) < $modulo) { //commence au début et termine quand le numéro du modulo est atteint
        $modulo_actuel++;
        $modulo_convert = date("d/m", mktime(0, 0, 0, 1, $modulo_actuel)); //Converti le modulo en date
        $citation->modulo = $modulo_convert;
        $citation->modulo_sort = $modulo_actuel;
      }
    }

    usort($citations, function ($a, $b) {return $a->modulo_sort > $b->modulo_sort;}); //Permet de placer la ciation actuelle en premiere ligne du tableau
    return $citations;
}

// Fonction pour afficher la page des citations
function afficher_page_mes_citations() {

    $citations = calculer_modulos_potentiels(); ?>

    <h1>Mes Citations (<?php echo count($citations); ?>)</h1>
    <!-- Bouton pour mélanger les citations -->

    <form style="float:right;" method="post" action="">
        <input type="hidden" name="scramble_citations_order_nonce" value="<?php echo wp_create_nonce('scramble_citations_order_nonce'); ?>">
        <button type="submit" name="scramble_citations_order_submit" class="button button-primary">Mélanger ordre</button>
    </form>

  <!-- Formulaire pour ajouter une citation -->

  <form method="post" action="">
    <input type="text" placeholder="Citation" id="citation" name="citation">
    <input type="text" placeholder="Auteur" id="auteur" name="auteur">
    <input type="submit" value="Ajouter une citation">
  </form>


  <br>
  <!-- Tableau pour les citations -->
  <table class="wp-list-table widefat striped">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Citation</th>
            <th scope="col">Auteur</th>
            <th scope="col">Date prévue</th>
						<th scope="col">Suppression</th>
        </tr>
    </thead>
    <tbody id="the-list">
			<?php
      if ($citations) {
				foreach ($citations as $citation) {

          if (array_search($citation, $citations) == 0){
            	    echo '<tr style="font-weight: bold;">';
          } else {
              	  echo '<tr>';
          }
                    echo '<td>' . esc_html($citation->id) . '</td>';
                    echo '<td>' . esc_html($citation->citation) . '</td>';
                    echo '<td>' . esc_html($citation->auteur) . '</td>';
                    echo '<td>'. $citation->modulo .'</td>';
                    echo '<td><form method="post"><input type="hidden" name="citation_id" value="' . esc_attr($citation->id) . '"><button type="submit" name="delete_citation">Supprimer</button></form></td>';
                  echo '</tr>';
        }
			}
      echo  '</tbody>';
    echo  '</table>';
}

// Gestion suppression citation
if (isset($_POST['delete_citation'])) {

    $wpdb->delete('geE_plugin_citations', array('id' => $_POST['citation_id']));  // Supprimer la citation de la base de données
        // Rafraîchir la page pour refléter les modifications
        echo '<meta http-equiv="refresh" content="0">';
}
/*
function supprimer_citation() {
    if (isset($_POST['citation_id'])) {
        $citationId = $_POST['citation_id'];
        // Supprimer la citation correspondante de l'array
        // Utilisez $citationId pour identifier l'élément à supprimer de l'array
        // Répondez avec un message ou un statut approprié
        wp_send_json_success('Citation supprimée avec succès');
    } else {
        wp_send_json_error('ID de citation manquant');
    }
}

add_action('wp_ajax_supprimer_citation', 'supprimer_citation');
*/

    if (!empty($_POST['citation']) && !empty($_POST['auteur'])) {
        global $wpdb;
        $citation = $_POST['citation'];
        $auteur = $_POST['auteur'];

        $wpdb->insert(
            'geE_plugin_citations',
            array(
                'citation' => $citation,
                'auteur' => $auteur,
                'statut' => 1
            ),
            array(
                '%s',
                '%s',
                '%s'
            )
        );
    }


// Mélanger les citations
function scramble_citations_order() {
    global $wpdb;
    $citations = $wpdb->get_results("SELECT * FROM geE_plugin_citations");

    shuffle($citations);

    $wpdb->query("TRUNCATE TABLE geE_plugin_citations;"); //Vider la table

    foreach ($citations as $citation) { //Rajouter les citations melangées

            $wpdb->insert(
                'geE_plugin_citations',
                array(
                    'citation' => $citation->citation,
                    'auteur' => $citation->auteur,
                    'statut' => $citation->statut
                ),
                array(
                    '%s',
                    '%s',
                    '%s'
                )
            );
    }
    //echo "Citations order scrambled successfully.";
}

function handle_scramble_citations_order() {
    if (isset($_POST['scramble_citations_order_submit']) && wp_verify_nonce($_POST['scramble_citations_order_nonce'], 'scramble_citations_order_nonce')) {
        scramble_citations_order();
    }
}
add_action('admin_init', 'handle_scramble_citations_order');

/////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////WIDGET///////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

function welovequotes_add_my_stylesheet() {
	wp_register_style( 'welovequotes-style', plugins_url('quote-of-the-day-and-random-quote.css', __FILE__) );
	wp_enqueue_style( 'welovequotes-style' );
}

add_action( 'wp_enqueue_scripts', 'welovequotes_add_my_stylesheet' );

function get_quote($day_today)
{
  global $wpdb;
  $listOfQuotes = array();
  $citations = $wpdb->get_results("SELECT * FROM geE_plugin_citations");

  foreach ($citations as $citation) {
    array_push($listOfQuotes, "<div class=\"weLoveQuotes quote\">".$citation->citation."</div><div class=\"weLoveQuotes author\">$citation->auteur</div>");
  }
  $number_quote = sizeof($listOfQuotes);
  $reste = $day_today % $number_quote;

	return $listOfQuotes[$reste];
}

function welovequotes_quote_of_the_day()
{
	return get_quote(date('z'));
}

function welovequotes_random_quote()
{
	return get_quote(rand(0, 365));
}

add_shortcode('quoteoftheday', 'welovequotes_quote_of_the_day');
add_shortcode('randomquote', 'welovequotes_random_quote');

class WeLoveQuotes_QuoteOfTheDayWidget extends WP_Widget
{
  function __construct()
  {
	parent::__construct('WeLoveQuotes_QuoteOfTheDayWidget', __('Quote of the Day', 'welovequotes_quoteoftheday' ), array ('description' => __( 'Show a daily quote on your website!', 'welovequotes_quoteoftheday')));
  }

  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => 'Quote of the day' ) );
    $title = $instance['title'];

?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <br /><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];

    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);

    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

    if (!empty($title))
      echo $before_title . $title . $after_title;;

    echo welovequotes_quote_of_the_day();

    echo $after_widget;
  }
}

class WeLoveQuotes_RandomQuoteWidget extends WP_Widget
{
  function __construct()
  {
	parent::__construct('WeLoveQuotes_RandomQuoteWidget', __('Random Quote', 'welovequotes_randomquote' ), array ('description' => __( 'Show a random quote on your website!', 'welovequotes_randomquote')));
  }

  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => 'Random Quote' ) );
    $title = $instance['title'];

?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];

    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);

    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

    if (!empty($title))
      echo $before_title . $title . $after_title;;

    echo welovequotes_random_quote();

    echo $after_widget;
  }
}

function register_WeLoveQuotes_QuoteOfTheDayWidget() {
  register_widget('WeLoveQuotes_QuoteOfTheDayWidget');
}


function register_WeLoveQuotes_RandomQuoteWidget() {
  register_widget('WeLoveQuotes_RandomQuoteWidget');
}

add_action( 'widgets_init', 'register_WeLoveQuotes_QuoteOfTheDayWidget');
add_action( 'widgets_init', 'register_WeLoveQuotes_RandomQuoteWidget');

?>
