<?php

function rrportfolio_theme_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  register_nav_menu('main-menu', 'Main Menu');
}
add_action('after_setup_theme', 'rrportfolio_theme_setup');

function rrportfolio_assets() {
   // GSAP
  wp_enqueue_script('gsap','https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js',[],null,true);
  // MAIN CSS
  wp_enqueue_style('main', get_template_directory_uri() . '/assets/css/style.css');
  // MAIN JS
  wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', ['gsap'], null, true);

  // AJAX URL
  wp_localize_script('tg-main', 'tg_ajax', [
    'ajax_url' => admin_url('admin-ajax.php')
  ]);
}
add_action('wp_enqueue_scripts', 'rrportfolio_assets');

function rrportfolio_icons() {
  wp_enqueue_style(
    'font-awesome',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css'
  );
}
add_action('wp_enqueue_scripts', 'rrportfolio_icons');

function rrportfolio_register_projects_cpt() {
    register_post_type('project', [
        'labels' => [
            'name' => 'Projects',
            'singular_name' => 'Project'
        ],
        'public' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => ['title', 'thumbnail'],
        'has_archive' => true,
    ]);

    register_taxonomy('project_category', 'project', [
        'label' => 'Categories',
        'hierarchical' => true,
        'rewrite' => ['slug' => 'project-category']
    ]);
}
add_action('init', 'rrportfolio_register_projects_cpt');

function rrportfolio_filter_projects() {

  $category = $_POST['category'];

  $args = [
    'post_type' => 'project',
    'posts_per_page' => -1
  ];

  if ($category !== 'all') {
    $args['tax_query'] = [
      [
        'taxonomy' => 'project_category',
        'field' => 'slug',
        'terms' => $category
      ]
    ];
  }

  $query = new WP_Query($args);

  if ($query->have_posts()):
    while ($query->have_posts()): $query->the_post(); ?>

      <div class="portfolio-item">
        <a href="<?php the_field('project_link'); ?>">
          <?php the_post_thumbnail('large'); ?>
        </a>
      </div>

    <?php endwhile;
  endif;

  wp_die();
}

add_action('wp_ajax_tg_filter_projects', 'rrportfolio_filter_projects');
add_action('wp_ajax_nopriv_tg_filter_projects', 'rrportfolio_filter_projects');

add_image_size('portfolio-thumb', 600, 400, true);