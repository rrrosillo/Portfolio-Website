<?php get_template_part('template-parts/sections/cta'); ?>
<footer class="footer">
  <div class="container footer-grid">

    <!-- LOGO / ABOUT -->
    <div class="footer-col">
      <h3>Estatein</h3>
      <p>
        Discover your dream property with ease. We provide trusted real estate solutions.
      </p>
    </div>

    <!-- LINKS -->
    <div class="footer-col">
      <h4>Home</h4>
      <ul>
        <li><a href="#">Hero Section</a></li>
        <li><a href="#">Features</a></li>
        <li><a href="#">Properties</a></li>
        <li><a href="#">Testimonials</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>About</h4>
      <ul>
        <li><a href="#">Our Story</a></li>
        <li><a href="#">Team</a></li>
        <li><a href="#">Careers</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>Contact</h4>
      <ul>
        <li><a href="#">Email Us</a></li>
        <li><a href="#">Call Us</a></li>
      </ul>
    </div>

    <!-- NEWSLETTER -->
    <div class="footer-col newsletter">
      <h4>Subscribe</h4>
      <form>
        <input type="email" placeholder="Enter your email">
        <button>→</button>
      </form>
    </div>

  </div>

  <!-- BOTTOM -->
  <div class="footer-bottom">
    <div class="container">
      <p>© <?php echo date('Y'); ?> Estatein. All rights reserved.</p>
    </div>
  </div>

  <?php wp_footer(); ?>
</footer>