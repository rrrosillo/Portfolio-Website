<div class="testimonial-card">

  <!-- STARS -->
  <div class="stars">
    ⭐⭐⭐⭐⭐
  </div>

  <!-- TITLE -->
  <h3><?php the_title(); ?></h3>

  <!-- CONTENT -->
  <p class="testimonial-text">
    <?php the_excerpt(); ?>
  </p>

  <!-- USER -->
  <div class="testimonial-user">
    <img src="<?php the_field('growmodo_testimonial_avatar'); ?>" alt="User">

    <div class="testimonial-info">
      <strong><?php the_field('growmodo_testimonial_name'); ?></strong>
      <span><?php the_field('growmodo_testimonial_location'); ?></span>
    </div>
  </div>

</div>