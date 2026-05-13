<?php

function rrportfolio_theme_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  register_nav_menu('main-menu', 'Main Menu');
}
add_action('after_setup_theme', 'rrportfolio_theme_setup');

function rrportfolio_assets() {
   // GSAP
  wp_enqueue_script('gsap','https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js',array(),false,true);
  wp_enqueue_script('gsap-scroll','https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/ScrollTrigger.min.js',array('gsap'),false,true);
  // MAIN CSS
  wp_enqueue_style('main', get_template_directory_uri() . '/assets/css/style.css');
  // MAIN JS
  wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', array('gsap'), false, true);

  // AJAX URL
  wp_localize_script('main-js', 'rrportfolio_ajax', [
    'ajax_url' => admin_url('admin-ajax.php'),
    'theme_url' => get_template_directory_uri()
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

   // Debug: check if POST is received
  if (empty($_POST)) {
    echo 'NO POST DATA';
    wp_die();
  }

  $category = isset($_POST['category']) 
    ? sanitize_text_field($_POST['category']) 
    : 'all';

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

  <a href="<?php the_field('project_link'); ?>" target="_blank">

    <div class="portfolio-image">
      <?php the_post_thumbnail('large'); ?>
    </div>

    <!-- HOVER OVERLAY -->
    <div class="portfolio-overlay">
      <div class="overlay-content">
        <h3><?php the_title(); ?></h3>

        <p>
          <?php echo esc_html(get_field('project_overlay_subtitle')); ?>
        </p>

        <span class="view-btn">VIEW PROJECT</span>
      </div>
    </div>

  </a>

</div>

    <?php endwhile;
  else:
    echo '<p style="color:white;">No projects found</p>';
  endif;

  wp_die();
}

add_action('wp_ajax_rrportfolio_filter_projects', 'rrportfolio_filter_projects');
add_action('wp_ajax_nopriv_rrportfolio_filter_projects', 'rrportfolio_filter_projects');


function rrportfolio_register_menus() {
  register_nav_menus([
    'primary' => 'Primary Menu'
  ]);
}
add_action('after_setup_theme', 'rrportfolio_register_menus');

add_image_size('portfolio-thumb', 600, 400, true);