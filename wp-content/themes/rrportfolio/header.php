<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header id="site-header" class="top-nav transparent">

  <!-- LEFT -->
  <div class="nav-left">
    <a href="<?php echo home_url(); ?>" class="site-logo">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/portfolio-logo.png" alt="Logo">
    </a>
  </div>

  <!-- RIGHT -->
  <div class="nav-right">

    <!-- MOBILE TOGGLE -->
    <button class="menu-toggle" aria-label="Toggle Menu">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <!-- NAVIGATION -->
    <nav class="main-nav">

      <?php
      if (has_nav_menu('primary')) {

        wp_nav_menu([
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'nav-menu',
        ]);

      } else {
      ?>

        <!-- FALLBACK MENU -->
        <ul class="nav-menu">
          <li><a href="#about-me">About me</a></li>
          <li><a href="#skills">Skills</a></li>
          <li><a href="#portfolio">Portfolio</a></li>
          <li><a href="#contact-me" class="btn-contact">CONTACT ME</a></li>
        </ul>

      <?php } ?>

    </nav>

  </div>

</header>