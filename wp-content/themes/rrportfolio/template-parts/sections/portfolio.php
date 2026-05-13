<section id="portfolio" class="portfolio-section">

  <div class="container">

    <div class="heading-box">
      <h2>PORTFOLIO</h2>
    </div>

    <!-- MOBILE FILTER TOGGLE -->
    <button class="portfolio-filter-toggle">
      <span>FILTER PROJECTS</span>
      <span class="filter-icon">+</span>
    </button>

    <!-- FILTERS -->
    <div class="portfolio-filters">

      <button class="active" data-filter="all">ALL</button>

      <?php
      $terms = get_terms([
        'taxonomy' => 'project_category',
        'hide_empty' => true,
      ]);

      foreach ($terms as $term): ?>

        <button data-filter="<?php echo esc_attr($term->slug); ?>">
          <?php echo esc_html(strtoupper($term->name)); ?>
        </button>

      <?php endforeach; ?>

    </div>

    <!-- GRID -->
    <div id="portfolio-grid" class="portfolio-grid">

      <?php
      $query = new WP_Query([
        'post_type' => 'project',
        'posts_per_page' => -1,
      ]);

      while ($query->have_posts()): $query->the_post(); ?>

        <div class="portfolio-item">

          <a href="<?php the_field('project_link'); ?>" target="_blank">

            <!-- IMAGE -->
            <div class="portfolio-image">
              <?php the_post_thumbnail('large'); ?>
            </div>

            <!-- OVERLAY -->
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

      <?php endwhile; wp_reset_postdata(); ?>

    </div>

  </div>

</section>