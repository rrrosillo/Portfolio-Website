<?php

function rrportfolio_theme_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  register_nav_menu('main-menu', 'Main Menu');
}
add_action('after_setup_theme', 'rrportfolio_theme_setup');

function rrportfolio_assets() {
  wp_enqueue_style('main', get_template_directory_uri() . '/assets/css/style.css');
  wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'rrportfolio_assets');

function rrportfolio_icons() {
  wp_enqueue_style(
    'font-awesome',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css'
  );
}
add_action('wp_enqueue_scripts', 'rrportfolio_icons');