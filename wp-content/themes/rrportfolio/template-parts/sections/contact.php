<section class="featured-properties">
  <div class="container">

    <!-- HEADER -->
    <div class="section-header">
      <div>
        <h2>Featured Properties</h2>
        <p>Explore our handpicked selection of premium properties.</p>
      </div>

      <a href="/properties" class="btn-outline">View All Properties</a>
    </div>

    <!-- GRID -->
    <div class="property-grid">

      <?php
      $query = new WP_Query([
        'post_type' => 'property',
        'posts_per_page' => 6
      ]);

      while($query->have_posts()) : $query->the_post(); ?>
        
        <div class="property-grid__item">
          <?php get_template_part('template-parts/components/property-card', 'property'); ?>
        </div>

      <?php endwhile; wp_reset_postdata(); ?>

    </div>

  </div>
</section>