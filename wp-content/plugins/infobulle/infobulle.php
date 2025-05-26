<?php

/**
 * Plugin Name: Mes Infobulles
 * Description: Description de votre plugin
 * Version: 1.0
 * Author: Vailalex
 * Author URI: URL de votre site
 */

ob_start();
// Ajouter un élément de menu dans l'administration
add_action('admin_menu', 'ajouter_menu_mes_infobulles');

function ajouter_menu_mes_infobulles() {
    add_menu_page(
        'Mes Infobulles',         // Titre de la page
        'Mes Infobulles',         // Texte du menu
        'manage_options',        // Capacité requise pour accéder au menu
        'mes-infobulles',         // Slug de la page
        'afficher_page_mes_infobulles' // Fonction pour afficher la page
    );
}

function register_edit_infobulle_page() {
    add_submenu_page(
        null,
        'Edit Infobulle',
        'Edit Infobulle',
        'manage_options',
        'edit_infobulle',
        'display_edit_infobulle_page'
    );
}
add_action('admin_menu', 'register_edit_infobulle_page');


function handle_infobulle_update($infobulle_id) {
    global $wpdb;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_infobulle'])) {
        $mot = wp_unslash($_POST['mot']);
        $contenu = wp_unslash($_POST['contenu']);
        $type = wp_unslash($_POST['type']);
        $article = wp_unslash($_POST['article']);
        $numero_iteration = wp_unslash($_POST['numero_iteration']);
        $style_position = wp_unslash($_POST['style_position']);

        // Update the infobulle in the database
        $update = $wpdb->update(
            "geE_plugin_infobulles",
            array(
                'mot' => $mot,
                'contenu' => $contenu,
                'type' => $type,
                'article' => $article,
                'numero_iteration' => $numero_iteration,
                'style_position' => $style_position
            ),
            array('id' => $infobulle_id)
        );

        if ($update !== false) {
            // Add a success message with the executed SQL query
            $sql_query = $wpdb->last_query;
            add_settings_error(
                'infobulle_messages',
                'infobulle_message',
                sprintf(__('Update successful. Executed query: %s', 'textdomain'), $sql_query),
                'success'
            );
        } else {
            // Add an error message to display on the form page
            $sql_error_message = $wpdb->last_error;
            add_settings_error(
                'infobulle_messages',
                'infobulle_message',
                sprintf(__('Update failed: %s', 'textdomain'), $sql_error_message),
                'error'
            );
        }
    }
}


function display_edit_infobulle_page() {
    if (!isset($_GET['infobulle_id'])) {
        echo '<p>Invalid Infobulle ID.</p>';
        return;
    }

    $infobulle_id = intval($_GET['infobulle_id']);
    global $wpdb;

    // Retrieve the infobulle data from the database
    $infobulle = $wpdb->get_row($wpdb->prepare("SELECT * FROM geE_plugin_infobulles WHERE id = %d", $infobulle_id));

    if (!$infobulle) {
        echo '<p>Infobulle not found.</p>';
        return;
    }

    // Check if the form is submitted and handle the update
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_infobulle'])) {
        handle_infobulle_update($infobulle_id);
        // Retrieve the updated data from the database
        $infobulle = $wpdb->get_row($wpdb->prepare("SELECT * FROM geE_plugin_infobulles WHERE id = %d", $infobulle_id));
    }

    $options = array('Autre', 'Définition', 'Exemple', 'Lexicon', 'Source', 'Supplément');
        $posts = get_posts(array('numberposts' => -1,
                             'post_status' => array('publish', 'private')));

    ?>

    <div class="wrap">
        <div style="display: flex;">
            <h1 style="margin-right: 50px; margin-bottom: 20px;">Edit Infobulle</h1>
            <div style="margin-top: 20px;"><?php settings_errors('infobulle_messages'); ?></div>
        </div>
        <form method="post">
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="mot">Mot</label></th>
                    <td><input name="mot" type="text" id="mot" value="<?php echo esc_attr($infobulle->mot); ?>" class="regular-text" required></td>
                </tr>
                <tr>
                    <th scope="row"><label for="contenu">Contenu</label></th>
                    <td><textarea name="contenu" id="contenu" rows="5" class="large-text" required><?php echo esc_textarea($infobulle->contenu); ?></textarea></td>
                </tr>
                <tr>
                    <th scope="row"><label for="type">Type</label></th>
                    <td>
                        <select id="type" name="type" required>
                            <?php foreach ($options as $option) : ?>
                                <option value="<?php echo esc_attr($option); ?>" <?php selected($infobulle->type, $option); ?>><?php echo esc_html($option); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="article">Article</label></th>
                    <td>
                        <select id="article" name="article" required>
                            <?php foreach ($posts as $post) : ?>
                                <option value="<?php echo esc_attr($post->ID); ?>" <?php selected($infobulle->article, $post->ID); ?>><?php echo esc_html($post->post_title); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="numero_iteration">Numéro d'itération</label></th>
                    <td><input name="numero_iteration" type="number" id="numero_iteration" value="<?php echo esc_attr($infobulle->numero_iteration); ?>" class="regular-text" required></td>
                </tr>
                <tr>
                    <th scope="row"><label for="style_position">Style de position</label></th>
                    <td><input name="style_position" type="text" id="style_position" value="<?php echo esc_attr($infobulle->style_position); ?>" class="regular-text" required></td>
                </tr>
            </table>
            <p class="submit"><button type="submit" name="update_infobulle" class="button button-primary">Update Infobulle</button></p>
        </form>
        <p>
            <a href="<?php echo esc_url(admin_url('admin.php?page=mes-infobulles')); ?>" class="button">Retour</a>
        </p>
    </div>

    <?php
}

/*

ALTER TABLE gee_plugin_infobulles ADD CONSTRAINT FK_article_postID FOREIGN KEY (article) REFERENCES wp_posts (ID) ON DELETE CASCADE ON UPDATE CASCADE;

*/
function gerer_insertion_infobulle() {
    global $wpdb;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Handle delete
        if (isset($_POST['delete_infobulle'])) {
            $infobulle_id = intval($_POST['infobulle_id']);
            $delete = $wpdb->delete('geE_plugin_infobulles', array('id' => $infobulle_id));

            if ($delete !== false) {
                add_settings_error(
                    'infobulle_messages',
                    'infobulle_message',
                    __('Infobulle deleted successfully.', 'textdomain'),
                    'success'
                );
            } else {
                $sql_error_message = $wpdb->last_error;
                add_settings_error(
                    'infobulle_messages',
                    'infobulle_message',
                    sprintf(__('Delete failed: %s', 'textdomain'), $sql_error_message),
                    'error'
                );
            }
        }

        // Handle insert
        if (isset($_POST['insert_infobulle'])) {
            $mot = wp_unslash($_POST['mot']);
            $contenu = wp_unslash($_POST['contenu']);
            $article = wp_unslash($_POST['article']);
            $type = wp_unslash($_POST['type']);
            $numero_iteration = wp_unslash($_POST['numero_iteration']);
            $style_position = wp_unslash($_POST['style_position']);

            $insert = $wpdb->insert(
                'geE_plugin_infobulles',
                array(
                    'mot' => $mot,
                    'contenu' => $contenu,
                    'article' => $article,
                    'type' => $type,
                    'numero_iteration' => $numero_iteration,
                    'style_position' => $style_position,
                ),
                array(
                    '%s',
                    '%s',
                    '%d',
                    '%s',
                    '%d',
                    '%s'
                )
            );

            if ($insert !== false) {
                $sql_query = $wpdb->last_query;
                add_settings_error(
                    'infobulle_messages',
                    'infobulle_message',
                    sprintf(__('Insert successful. Executed query: %s', 'textdomain'), $sql_query),
                    'success'
                );
            } else {
                $sql_error_message = $wpdb->last_error;
                add_settings_error(
                    'infobulle_messages',
                    'infobulle_message',
                    sprintf(__('Insert failed: %s', 'textdomain'), $sql_error_message),
                    'error'
                );
            }
        }
    }
}

function afficher_page_mes_infobulles() {
    // Handle form submissions
    gerer_insertion_infobulle();

    global $wpdb;

    // Retrieve posts and infobulles
        $posts = get_posts(array('numberposts' => -1,
                             'post_status' => array('publish', 'private')));
    $infobulles = $wpdb->get_results("SELECT * FROM geE_plugin_infobulles ORDER BY id DESC");
    $num_infobulles = count($infobulles);
    ?>

    <div style="display: flex;">
        <h1 style="margin-right: 50px; margin-bottom: 20px;">Mes infobulles (<?php echo $num_infobulles; ?>)</h1>
        <div style="margin-top: 20px;"><?php settings_errors('infobulle_messages'); ?></div>
    </div>

    <form method="post" action="">
        <input type="text" placeholder="Mot" id="mot" name="mot" required>
        <input type="text" placeholder="Contenu" id="contenu" name="contenu" required>
        <select id="article" name="article" required>
            <?php foreach($posts as $post): ?>
                <option value="<?php echo esc_attr($post->ID); ?>">
                    <?php echo esc_html($post->post_title); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="number" placeholder="Numéro Itération" value="1" id="numero_iteration" name="numero_iteration" required>
        <select id="style_position" name="style_position" required>
            <option value="hd">hd</option>
        </select>
        <select id="type" name="type" required>
            <option value="Autre">Autre</option>
            <option value="Définition">Définition</option>
            <option value="Exemple">Exemple</option>
            <option value="Lexicon">Lexicon</option>
            <option value="Source">Source</option>
            <option value="Supplément">Supplément</option>
        </select>
        <input type="submit" name="insert_infobulle" value="Ajouter une infobulle">
    </form>

    <br>

    <table class="wp-list-table widefat striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Mot</th>
                <th scope="col">Contenu</th>
                <th scope="col">Article</th>
                <th scope="col">Type</th>
                <th scope="col">Numéro Itération</th>
                <th scope="col">Style Position</th>
                <th scope="col">Edition</th>
                <th scope="col">Suppression</th>
            </tr>
        </thead>
        <tbody id="the-list">
            <?php if ($infobulles): ?>
                <?php foreach ($infobulles as $infobulle): ?>
                    <tr>
                        <td><?php echo esc_html($infobulle->id); ?></td>
                        <td><?php echo esc_html($infobulle->mot); ?></td>
                        <td><?php echo esc_html($infobulle->contenu); ?></td>
                        <td><?php echo esc_html(get_the_title($infobulle->article)); ?></td>
                        <td><?php echo esc_html($infobulle->type); ?></td>
                        <td><?php echo esc_html($infobulle->numero_iteration); ?></td>
                        <td><?php echo esc_html($infobulle->style_position); ?></td>
                        <td><a href="<?php echo admin_url('admin.php?page=edit_infobulle&infobulle_id=' . esc_attr($infobulle->id)); ?>">Edit</a></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="infobulle_id" value="<?php echo esc_attr($infobulle->id); ?>">
                                <button type="submit" name="delete_infobulle">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <?php
}

?>
