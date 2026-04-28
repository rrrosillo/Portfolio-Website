<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<?php wp_head(); ?>
</head>

<body>

<header class="nav">
  <div class="container nav-inner">

    <div class="logo">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png">
    </div>

    <nav>
      <a href="#">About me</a>
      <a href="#">Skills</a>
      <a href="#">Portfolio</a>
      <a class="btn" href="#">Contact Me</a>
    </nav>

  </div>
</header>