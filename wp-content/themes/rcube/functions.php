<?php

// Enqueue styles & scripts
function growmodo_assets() {
  wp_enqueue_style('main-css', get_template_directory_uri() . '/assets/css/style.css');
  wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', [], false, true);
  wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css');
  wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'growmodo_assets');

// Theme support
function growmodo_theme_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');

  register_nav_menus([
    'primary' => 'Primary Menu'
  ]);
}
add_action('after_setup_theme', 'growmodo_theme_setup');

// Custom Post Type: Property
function growmodo_property_cpt() {
  register_post_type('property', [
    'label' => 'Properties',
    'public' => true,
    'has_archive' => true,
    'menu_icon' => 'dashicons-building',
    'supports' => ['title', 'editor', 'thumbnail']
  ]);
}
add_action('init', 'growmodo_property_cpt');

// Custom Post Type - Testimonial
function growmodo_testimonial_cpt() {
  register_post_type('testimonial', [
    'label' => 'Testimonials',
    'public' => true,
    'menu_icon' => 'dashicons-testimonial',
    'supports' => ['title', 'editor']
  ]);
}
add_action('init', 'growmodo_testimonial_cpt');

// Custom Post Type - FAQ
function growmodo_faq_cpt() {

  register_post_type('faq', [
    'label' => 'FAQs',
    'public' => true,
    'menu_icon' => 'dashicons-editor-help',
    'supports' => ['title', 'editor'],
    'show_in_rest' => true
  ]);

}
add_action('init', 'growmodo_faq_cpt');