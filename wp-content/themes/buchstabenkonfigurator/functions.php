<?php
/**
 * Buchstabenkonfigurator - Hauptfunktionen
 *
 * @package Buchstabenkonfigurator
 */

 // Direktzugriff vermeiden

 if(!defined('ABSPATH')){
    exit;
 }

 // Konstanten definieren
 define('BK_VERSION','1.0.0');
 define('BK_PATH', get_template_directory());
 define('BK_URL', get_template_directory_uri());

 /**
 * Stile und Skripte registrieren und einreihen
 */
 function bk_enqueue_scripts(){
    wp_enqueue_style(
        'buchstabenkonfigurator-style',
        get_stylesheet_uri() . '/assets/css/main.css',
        array(),
        BK_VERSION
    );
    
    //Production Umgebung
    if(!WP_DEBUG) {
        wp_enqueue_style(
            'buchstabenkonfigurator-style',
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
 function bk_theme_setup(){
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