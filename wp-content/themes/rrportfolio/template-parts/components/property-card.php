<div class="property-card">

  <div class="property-image">
    <?php the_post_thumbnail('medium'); ?>
  </div>

  <div class="property-content">
    <h3><?php the_title(); ?></h3>
    <p class="desc"><?php the_excerpt(); ?></p>

    <div class="property-meta">
      <span>🛏 <?php the_field('growmodo_property_bedrooms'); ?> Bedroom</span>
      <span>🛁 <?php the_field('growmodo_property_bathrooms'); ?> Bathroom</span>
      <span>🏠 <?php the_field('growmodo_property_type'); ?></span>
    </div>

    <div class="property-footer">
      <div class="price">$<?php the_field('growmodo_property_price'); ?></div>
      <a href="<?php the_permalink(); ?>" class="btn-primary small">
        View Property Details
      </a>
    </div>
  </div>

</div>