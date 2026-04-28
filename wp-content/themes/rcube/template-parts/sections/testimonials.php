<section class="testimonials">
  <div class="container">

    <!-- HEADER -->
    <div class="section-header">
      <div>
        <h2>What Our Clients Say</h2>
        <p>Real stories from satisfied clients who found their dream properties.</p>
      </div>
    </div>

    <!-- GRID -->
    <div class="testimonials-grid">

      <?php
      $query = new WP_Query([
        'post_type' => 'testimonial',
        'posts_per_page' => 6
      ]);

      while($query->have_posts()) : $query->the_post(); ?>
        <?php get_template_part('template-parts/components/testimonial-card', 'testimonial'); ?>
      <?php endwhile; wp_reset_postdata(); ?>

    </div>

  </div>
</section>