<footer class="site-footer" data-aos="fade-up" data-aos-duration="500">
  <div class="footer-container">
    <div class="footer-brand">
      <h3>LandPage</h3>
      <p>Belajar lebih mudah dan fleksibel di platform kami.</p>
      <div class="social-icons">
        <a href="#" target="_blank" aria-label="Facebook"><i class="fab fa-facebook fa-2x"></i></a>
        <a href="#" target="_blank" aria-label="Instagram"><i class="fab fa-instagram fa-2x"></i></a>
        <a href="#" target="_blank" aria-label="TikTok"><i class="fab fa-tiktok fa-2x"></i></a>
        <a href="#" target="_blank" aria-label="X/Twitter"><i class="fab fa-x-twitter fa-2x"></i></a>
      </div>
    </div>

    <div class="footer-links">
      <h4>Menu</h4>
      <ul>
        <li><a href="{{ route('home.index') }}">Home</a></li>
        <li><a href="{{ route('course.index') }}">Categories</a></li>
        <li><a href="{{ route('about.index') }}">About</a></li>
      </ul>
    </div>

    <div class="footer-contact">
      <h4>Contact</h4>
      <ul>
        <li><i class="fas fa-envelope mr-2"></i> support@landpage.com</li>
        <li><i class="fas fa-phone-alt mr-2"></i> +62 812-3456-7890</li>
        <li><i class="fas fa-map-marker-alt mr-2"></i> Jakarta, Indonesia</li>
      </ul>
    </div>
  </div>

  <div class="footer-bottom">
    <p>&copy; {{ date('Y') }} LandPage. All rights reserved.</p>
  </div>

 
</footer>
