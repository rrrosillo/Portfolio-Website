<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<?php wp_head(); ?>
</head>

<body>

<header id="site-header" class="top-nav transparent">

  <div class="nav-left">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/portfolio-logo.png" alt="Logo">
  </div>

  <div class="nav-right">

    <nav class="main-nav">

      <?php
      if (has_nav_menu('primary')) {
        wp_nav_menu([
          'theme_location' => 'primary',
          'container' => false,
          'menu_class' => 'nav-menu',
        ]);
      } else {
      ?>
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