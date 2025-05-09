<?php

/**
 * Custom Post Types für den Buchstabenkonfigurator
 * 
 * Registriert die benutzerdefinierten Inhaltstypen, die für den Konfigurator erforderlich sind.
 */

// Direktzugriff vermeiden
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Registiert den Custom Post Type für gespeicherte Konfigurationen.
 */

function bk_register_configuration_cpt()
{
    $labels = array(
        'name' => __('Konfigurationen', 'buchstabenkonfigurator'),
        'singular_name' => __('Konfiguration', 'buchstabenkonfigurator'),
        'add_new_item' => __('Neue hinzufügen', 'buchstabenkonfigurator'),
        'add_new_item' => __('Neue Konfiguration hinzufügen', 'buchstabenkonfigurator'),
        'edit_new_item' => __('Konfiguration bearbeiten', 'buchstabenkonfigurator'),
        'new_item' => __('Neue Konfiguration', 'buchstabenkonfigurator'),
        'view_item' => __('Konfiguration ansehen', 'buchstabenkonfigurator'),
        'search_items' => __('Neue Konfiguration', 'buchstabenkonfigurator'),
        'view_item' => __('Konfiguration ansehen', 'buchstabenkonfigurator'),
        'search_items' => __('Konfigurationen suchen', 'buchstabenkonfigurator'),
        'not_found' => __('Keine Konfigurationen gefunden', 'buchstabenkonfigurator'),
        'not_found_in_trash' => __('Keine Konfigurationen in Papierkorb gefunden', 'buchstabenkonfigurator')
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'configuration'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-editor-textcolor',
        'supports' => array('title', 'custom-fields'),
        'show_in_rest' => true,
    );
    register_post_type('configuration', $args);
}
add_action('init', 'bk_register_configuration_cpt');

/**
 * Registriert Metaboxen und benutzerdefinierte Felder für den CPT Konfiguration
 */

function bk_register_configuration_meta_boxes()
{
    add_meta_box(
        'bk_configuration_details',
        __('Konfigurationsdetails', 'buchstabenkonfigurator'),
        'bk_configuration_details_callback',
        'configuration',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'bk_register_configuration_meta_boxes');

/**
 * Callback zum Anzeigen der Metabox für Konfigurationsdetails
 */
function bk_configuration_details_callback($post)
{
    // Nonce für die Überprüfung hinzufügen
    wp_nonce_field('bk_save_configuration_data', 'bk_configuration_nonce');

    // Aktuelle Werte abrufen
    $letter = get_post_meta($post->ID, '_bk_letter', true);
    $color = get_post_meta($post->ID, '_bk_color', true);
    $material = get_post_meta($post->ID, '_bk_material', true);
    $date_created = get_post_meta($post->ID, '_bk_date_created', true);

    // Formularfelder anzeigen
?>
    <div class="bk-meta-field">
        <label for="bk_letter"><?php _e('Buchstabe', 'buchstabenkonfigurator'); ?></label>
        <input type="text" id="bk_letter" name="bk_letter" value="<?php echo esc_attr($letter); ?>" maxlength="1">
    </div>

    <div class="bk-meta-field">
        <label for="bk_color"><?php _e('Farbe (Cod HEX)', 'buchstabenkonfigurator'); ?></label>
        <input type="text" id="bk_color" name="bk_color" value="<?php echo esc_attr($color); ?>">
        <?php if (!empty($color)) : ?>
            <span class="bk-color-preview" style="background-color: <?php echo esc_attr($color); ?>"></span>
        <?php endif; ?>
    </div>

    <div class="bk-meta-field">
        <label for="bk_material"><?php _e('Material', 'buchstabenkonfigurator'); ?></label>
        <select id="bk_material" name="bk_material">
            <option value="matt" <?php selected($material, 'matt'); ?>><?php _e('Matt', 'buchstabenkonfigurator'); ?></option>
            <option value="glanzend" <?php selected($material, 'glanzend'); ?>><?php _e('Glänzend', 'buchstabenkonfigurator'); ?></option>
        </select>
    </div>

    <?php if (!empty($date_created)): ?>
        <div class="bk-meta-field">
            <label><?php _e('Erstellungsdatum', 'buchstabenkonfigurator'); ?></label>
            <span><?php echo date_i18n(get_option('date_format') . '' . get_option('time_format'), $date_created); ?></span>
        </div>
    <?php endif; ?>
<?php
}

/**
 * Speichert die Metadaten der Konfiguration
 */
function bk_save_configuration_meta($post_id)
{
    // Nonce überprüfen
    if (!isset($_POST['bk_configuration_nonce']) || !wp_verify_nonce($_POST['bk_configuration_nonce'], 'bk_save_configuration_data')) {
        return;
    }

    // Autosave überprüfen
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Berechtigungen überprüfen
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Buchstabe speichern
    if (isset($_POST['bk_letter'])) {
        update_post_meta($post_id, '_bk_letter', sanitize_text_field($_POST['bk_letter']));
    }

    // Farbe speichern
    if (isset($_POST['bk_color'])) {
        update_post_meta($post_id, '_bk_color', sanitize_text_field($_POST['bk_color']));
    }

    // Material speichern
    if (isset($_POST['bk_material'])) {
        update_post_meta($post_id, '_bk_material', sanitize_text_field($_POST['bk_material']));
    }

    // Wenn es ein neuer Eintrag ist, Erstellungsdatum speichern
    if (!get_post_meta($post_id, '_bk_date_created', true)){
        update_post_meta($post_id, '_bk_date_created', time());
    }
}
add_action('save_post_configuration', 'bk_save_configuration_meta');
