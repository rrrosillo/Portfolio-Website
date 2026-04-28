<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<!-- TOP BAR -->
<div class="top-bar">
  <div class="container">
    <p>✨ Discover Your Dream Property with Estatien</p>
    <span class="close-top">×</span>
  </div>
</div>

<!-- HEADER -->
<header class="main-header">
  <div class="container header-flex">

    <!-- LOGO -->
    <div class="logo">
      <a href="<?php echo home_url(); ?>">
        <img src="../wp-content/uploads/2026/04/Logo.png" alt="Growmodo Theme Logo - Estatien Logo" class="estatien-logo"/>
      </a>
    </div>

    <!-- MENU -->
    <nav class="nav-menu">
      <?php
        wp_nav_menu([
          'theme_location' => 'primary',
          'container' => false,
          'menu_class' => 'menu'
        ]);
      ?>
    </nav>

    <!-- CTA -->
    <div class="header-cta">
      <a href="/contact" class="btn-primary">Contact Us</a>
    </div>

  </div>
</header>