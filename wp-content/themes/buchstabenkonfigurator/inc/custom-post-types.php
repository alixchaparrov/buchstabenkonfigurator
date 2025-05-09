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
        'add_new' => __('Neue hinzufügen', 'buchstabenkonfigurator'),
        'add_new_item' => __('Neue Konfiguration hinzufügen', 'buchstabenkonfigurator'),
        'edit_item' => __('Konfiguration bearbeiten', 'buchstabenkonfigurator'),
        'new_item' => __('Neue Konfiguration', 'buchstabenkonfigurator'),
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

    //Standarwerte setzen
    if (empty($letter)) $letter = 'A';
    if (empty($color)) $color = '#4a6da7';
    if (empty($material)) $material = 'matt';

    //Farbpaletten definieren
    $color_palettes = array(
        'grundfarben' => array(
            'name' => __('Grundfarben', 'buchstabenkonfigurator'),
            'colors' => array(
                array('name' => __('Verkehrsrot', 'buchstabenkonfigurator'), 'code' => '#d32f2f'),
                array('name' => __('Verkehrsblau', 'buchstabenkonfigurator'), 'code' => '#1976d2'),
                array('name' => __('Verkehrsgrün', 'buchstabenkonfigurator'), 'code' => '#388e3c'),
                array('name' => __('Sonnengelb', 'buchstabenkonfigurator'), 'code' => '#fbc02d'),
                array('name' => __('Violett', 'buchstabenkonfigurator'), 'code' => '#7b1fa2'),
            )
        ),
        'pastell' => array(
            'name' => __('Pastell', 'buchstabenkonfigurator'),
            'colors' => array(
                array('name' => __('Pastellrot', 'buchstabenkonfigurator'), 'code' => '#f8bbd0'),
                array('name' => __('Pastellblau', 'buchstabenkonfigurator'), 'code' => '#b3e5fc'),
                array('name' => __('Pastellgrün', 'buchstabenkonfigurator'), 'code' => '#c8e6c9'),
                array('name' => __('Pastellgelb', 'buchstabenkonfigurator'), 'code' => '#fff9c4'),
                array('name' => __('Pastellviolett', 'buchstabenkonfigurator'), 'code' => '#e1bee7'),
            )
        ),
        'metallisch' => array(
            'name' => __('Metallisch', 'buchstabenkonfigurator'),
            'colors' => array(
                array('name' => __('Silber', 'buchstabenkonfigurator'), 'code' => '#cfd8dc'),
                array('name' => __('Gold', 'buchstabenkonfigurator'), 'code' => '#ffd700'),
                array('name' => __('Bronze', 'buchstabenkonfigurator'), 'code' => '#cd7f32'),
                array('name' => __('Kupfer', 'buchstabenkonfigurator'), 'code' => '#b87333'),
            )
        ),
        'neon' => array(
            'name' => __('Neon', 'buchstabenkonfigurator'),
            'colors' => array(
                array('name' => __('Neongrün', 'buchstabenkonfigurator'), 'code' => '#76ff03'),
                array('name' => __('Neonpink', 'buchstabenkonfigurator'), 'code' => '#ff4081'),
                array('name' => __('Neongelb', 'buchstabenkonfigurator'), 'code' => '#ffea00'),
                array('name' => __('Neonorange', 'buchstabenkonfigurator'), 'code' => '#ff6d00'),
            )
        ),
    );


    // Formularfelder anzeigen
?>
    <div class="bk-meta-container">
        <!-- Buchstabenvorschau -->
        <div class="bk-letter-preview <?php echo $material === 'glanzend' ? 'glanzend-effect' : ''; ?>" style="color: <?php echo esc_attr($color); ?>">
            <?php echo esc_html($letter); ?>
        </div>
        
        <div class="bk-meta-field">
            <label for="bk_letter"><?php _e('Buchstabe', 'buchstabenkonfigurator'); ?></label>
            <input type="text" id="bk_letter" name="bk_letter" value="<?php echo esc_attr($letter); ?>" maxlength="1">
            <div class="bk-field-hint"><?php _e('Ein einzelner Buchstabe (A-Z)', 'buchstabenkonfigurator'); ?></div>
        </div>

        <div class="bk-meta-field">
            <label for="bk_color"><?php _e('Farbe', 'buchstabenkonfigurator'); ?></label>
            
            <!-- Farbfamilien-Auswahl -->
            <div class="color-family-selector">
                <select id="color-family-select">
                    <?php foreach ($color_palettes as $family_key => $family): ?>
                        <option value="<?php echo esc_attr($family_key); ?>">
                            <?php echo esc_html($family['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Farbpaletten -->
            <?php foreach ($color_palettes as $family_key => $family): ?>
                <div class="color-palette" data-family="<?php echo esc_attr($family_key); ?>" style="display: <?php echo ($family_key === array_key_first($color_palettes)) ? 'flex' : 'none'; ?>">
                    <?php foreach ($family['colors'] as $color_data): ?>
                        <div class="color-option <?php echo ($color === $color_data['code']) ? 'active' : ''; ?>" 
                             data-color="<?php echo esc_attr($color_data['code']); ?>" 
                             title="<?php echo esc_attr($color_data['name']); ?>"
                             style="background-color: <?php echo esc_attr($color_data['code']); ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
            
            <input type="hidden" id="bk_color" name="bk_color" value="<?php echo esc_attr($color); ?>">
            <div class="selected-color-info">
                <span class="color-preview" style="background-color: <?php echo esc_attr($color); ?>"></span>
                <span class="color-code"><?php echo esc_html($color); ?></span>
            </div>
            
            <div class="bk-field-hint"><?php _e('Wählen Sie eine Farbe aus den verfügbaren Paletten', 'buchstabenkonfigurator'); ?></div>
        </div>

        <div class="bk-meta-field">
            <label for="bk_material"><?php _e('Material', 'buchstabenkonfigurator'); ?></label>
            <select id="bk_material" name="bk_material">
                <option value="matt" <?php selected($material, 'matt'); ?>><?php _e('Matt', 'buchstabenkonfigurator'); ?></option>
                <option value="glanzend" <?php selected($material, 'glanzend'); ?>><?php _e('Glänzend', 'buchstabenkonfigurator'); ?></option>
            </select>
            <div class="bk-field-hint"><?php _e('Oberflächenbeschaffenheit des Buchstabens', 'buchstabenkonfigurator'); ?></div>
        </div>

        <?php if (!empty($date_created)): ?>
            <div class="bk-meta-field">
                <label><?php _e('Erstellungsdatum', 'buchstabenkonfigurator'); ?></label>
                <span class="date-display"><?php echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), $date_created); ?></span>
            </div>
        <?php endif; ?>
    </div>
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
    if (!get_post_meta($post_id, '_bk_date_created', true)) {
        update_post_meta($post_id, '_bk_date_created', time());
    }
}
add_action('save_post_configuration', 'bk_save_configuration_meta');

/**
 * Fügt benutzerdefinierte Spalten zur Konfigurationliste hinzu
 */

function bk_add_configuration_columns($columns)
{

    $new_columns = array();

    // Spalten neu anordnen mit unseren benutzerdefinierten Spalten
    foreach ($columns as $key => $value) {
        if ($key === 'title') {
            $new_columns[$key] = $value;
            $new_columns['letter'] = __('Buchstabe', 'buchstabenkonfigurator');
            $new_columns['color'] = __('Farbe', 'buchstabenkonfigurator');
            $new_columns['material'] = __('Material', 'buchstabenkonfigurator');
        } elseif ($key === 'date') {
            $new_columns['created'] = __('Erstellt am', 'buchstabenkonfigurator');
            $new_columns[$key] = $value;
        } else {
            $new_columns[$key] = $value;
        }
    }
    return $new_columns;
}
add_filter('manage_configuration_posts_columns', 'bk_add_configuration_columns');

/**
 * Zeigt Inhalte für benutzerdefinierte Spalten an
 */

function bk_display_configuration_columns($column, $post_id)
{
    switch ($column) {
        case 'letter':
            $letter = get_post_meta($post_id, '_bk_letter', true);
            echo esc_html($letter);
            break;

        case 'color':
            $color = get_post_meta($post_id, '_bk_color', true);
            if (!empty($color)) {
                echo '<span style="display:inline-block; width:20px; height:20px; background-color:' . esc_attr($color) . '; vertical-align:middle; border:1px solid #ddd;"></span> ';
                echo esc_html($color);
            }
            break;

        case 'material':
            $material = get_post_meta($post_id, '_bk_material', true);
            if ($material === 'matt') {
                echo __('Matt', 'buchstabenkonfigurator');
            } else if ($material === 'glanzend') {
                echo __('Glänzend', 'buchstabenkonfigurator');
            }
            break;

        case 'created':
            $date = get_post_meta($post_id, '_bk_date_created', true);
            if (!empty($date)) {
                echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), $date);
            }
            break;
    }
}
add_action('manage_configuration_posts_custom_column', 'bk_display_configuration_columns', 10, 2);
/**
 * Macht die benutzerdefinierten Spalten sortierbar
 */
function bk_sortable_configuration_columns($columns)
{
    $columns['letter'] = 'letter';
    $columns['color'] = 'color';
    $columns['material'] = 'material';
    $columns['created'] = 'created';

    return $columns;
}
add_filter('manage_edit-configuration_sortable_columns', 'bk_sortable_configuration_columns');

/**
 * Sortierlogik für benutzerdefinierte Spalten
 */

function bk_configuration_columns_orderby($query)
{
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    $orderby = $query->get('orderby');

    if ('letter' === $orderby) {
        $query->set('meta_key', '_bk_letter');
        $query->set('orderby', 'meta_value');
    }

    if ('color' === $orderby) {
        $query->set('meta_key', '_bk_color');
        $query->set('orderby', 'meta_value');
    }

    if ('material' === $orderby) {
        $query->set('meta_key', '_bk_material');
        $query->set('orderby', 'meta_value');
    }

    if ('created' === $orderby) {
        $query->set('meta_key', '_bk_date_created');
        $query->set('orderby', 'meta_value_num');
    }
}
add_action('pre_get_posts', 'bk_configuration_columns_orderby');
