<?php

/**
 * Buchstabenkonfigurator - Hauptfunktionen
 *
 * @package Buchstabenkonfigurator
 */

// Direktzugriff vermeiden

if (!defined('ABSPATH')) {
    exit;
}

// Konstanten definieren
define('BK_VERSION', '1.0.0');
define('BK_PATH', get_template_directory());
define('BK_URL', get_template_directory_uri());

/**
 * Erforderliche Dateien einbinden
 */
require_once BK_PATH . '/inc/custom-post-types.php';

/**
 * Stile und Skripte registrieren und einreihen
 */
function bk_enqueue_scripts()
{
    wp_enqueue_style(
        'buchstabenkonfigurator-style',
        get_stylesheet_uri(),
        array(),
        BK_VERSION
    );

    //Production Umgebung - Minifizierte Version
    if (!WP_DEBUG) {
        wp_enqueue_style(
            'buchstabenkonfigurator-main',
            get_template_directory_uri() . '/assets/css/main.min.css',
            array(),
            BK_VERSION
        );
    }
}
add_action('wp_enqueue_scripts', 'bk_enqueue_scripts');

/**
 * Konfigurieren Sie das Thema
 */
function bk_theme_setup()
{
    // Unterstützung für Titel
    add_theme_support('title-tag');
    // Unterstützung für Miniaturansichten
    add_theme_support('post-thumbnails');
    // HTML5-Unterstützung
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}
add_action('after_setup_theme', 'bk_theme_setup');

/**
 * Admin-Scripts und -Styles laden
 */
function bk_enqueue_admin_scripts($hook) {
    global $post_type;
    
    // Nur auf den Seiten des CPT 'configuration' laden
    if (($hook == 'post.php' || $hook == 'post-new.php') && $post_type === 'configuration') {
        // Admin-Styles laden
        wp_enqueue_style(
            'bk-admin-styles',
            get_template_directory_uri() . '/assets/css/admin.css',
            array(),
            BK_VERSION
        );

        // jQuery UI für Colorpicker
        wp_enqueue_style('wp-jquery-ui-dialog');
        
        // Admin-Script laden
        wp_enqueue_script(
            'bk-admin-script',
            get_template_directory_uri() . '/assets/js/admin.js',
            array('jquery','jquery-ui-core'),
            BK_VERSION,
            true
        );

        // Lokalisiere das Script mit nonce und URLs
        wp_localize_script('bk-admin-script', 'bkAdmin', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('bk_admin_nonce'),
            'themeUrl' => get_template_directory_uri()
        ));
    }
}
add_action('admin_enqueue_scripts', 'bk_enqueue_admin_scripts');