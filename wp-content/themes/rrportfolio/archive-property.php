<?php get_header(); ?>

<div class="container">
  <h1>All Properties</h1>

  <div class="grid">
    <?php while(have_posts()) : the_post(); ?>
      <?php get_template_part('template-parts/property', 'card'); ?>
    <?php endwhile; ?>
  </div>
</div>

<?php get_footer(); ?>