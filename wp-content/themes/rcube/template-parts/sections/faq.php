<section class="faq">
  <div class="container">

    <!-- HEADER -->
    <div class="section-header">
      <div>
        <h2>Frequently Asked Questions</h2>
        <p>Find answers to common questions about our services.</p>
      </div>
    </div>

    <!-- SLIDER -->
    <div class="swiper faq-slider">
      <div class="swiper-wrapper">

        <?php
        $query = new WP_Query([
          'post_type' => 'faq',
          'posts_per_page' => -1
        ]);

        $count = 0;

        if($query->have_posts()):
          while($query->have_posts()): $query->the_post();

            // Open slide every 3 items
            if($count % 3 == 0): ?>
              <div class="swiper-slide">
                <div class="faq-slide-grid">
            <?php endif; ?>

              <div class="faq-card">
                <div class="faq-question">
                  <h3><?php the_title(); ?></h3>
                  <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                  <p><?php echo get_the_content(); ?></p>
                </div>
              </div>

            <?php
            $count++;

            // Close slide every 3 items
            if($count % 3 == 0): ?>
                </div>
              </div>
            <?php endif;

          endwhile;

          // Close last slide if not divisible by 3
          if($count % 3 != 0): ?>
              </div>
            </div>
          <?php endif;

          wp_reset_postdata();
        endif;
        ?>

      </div>

      <!-- NAV -->
      <div class="slider-nav">
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
      </div>

    </div>

  </div>
</section>