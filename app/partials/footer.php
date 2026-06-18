<?php
$site = config('site');
require_once app_path('partials/icons.php');
?>
</main>

<footer class="site-footer" role="contentinfo">
  <div class="container">
    <div class="site-footer__top">
      <div class="site-footer__brand">
        <a href="/" class="brand" aria-label="<?= e($site['name']) ?> home">
          <img src="<?= e(asset('/assets/img/logo.png')) ?>" alt="" class="brand__mark" width="44" height="44">
          <span class="brand__text">
            <span class="brand__name" style="color:#fff"><?= e($site['name']) ?></span>
            <span class="brand__sub" style="color:rgba(255,255,255,0.55)">For Research &amp; Training</span>
          </span>
        </a>
        <p>India's network of independent Bharatiya voices. Free to join. Built to last.</p>
        <div class="site-footer__socials" aria-label="Social links">
          <a href="<?= e($site['social']['twitter']) ?>" aria-label="Twitter" rel="noopener"
            target="_blank"><?php icon('twitter', ['width' => 18, 'height' => 18]); ?></a>
          <a href="<?= e($site['social']['facebook']) ?>" aria-label="Facebook" rel="noopener"
            target="_blank"><?php icon('facebook', ['width' => 18, 'height' => 18]); ?></a>
          <a href="<?= e($site['social']['youtube']) ?>" aria-label="YouTube" rel="noopener"
            target="_blank"><?php icon('youtube', ['width' => 18, 'height' => 18]); ?></a>
          <a href="<?= e($site['social']['instagram']) ?>" aria-label="Instagram" rel="noopener"
            target="_blank"><?php icon('instagram', ['width' => 18, 'height' => 18]); ?></a>
        </div>
      </div>

      <div>
        <h4>Quick Links</h4>
        <ul>
          <li><a href="/about">About Us</a></li>
          <li><a href="/pillars">Our Pillars</a></li>
          <li><a href="/directory">Directory</a></li>
          <li><a href="/resources">Resources</a></li>
          <li><a href="/news-events">News &amp; Events</a></li>
        </ul>
      </div>

      <div>
        <h4>Engage</h4>
        <ul>
          <li><a href="/join">Join the Coalition</a></li>
          <li><a href="/donate">Support Our Cause</a></li>
          <li><a href="/my-account">Member Portal</a></li>
          <li><a href="/faq">FAQ</a></li>
          <li><a href="/contact">Contact</a></li>
        </ul>
      </div>

      <div>
        <h4 class="is-saffron">Contact Us</h4>
        <ul>
          <li class="site-footer__contact-row"><?php icon('mail', ['width' => 18, 'height' => 18]); ?><a
              href="mailto:<?= e($site['email']) ?>"><?= e($site['email']) ?></a></li>
          <li class="site-footer__contact-row"><?php icon('phone', ['width' => 18, 'height' => 18]); ?><a
              href="tel:<?= e(preg_replace('/\s+/', '', $site['phone'])) ?>"><?= e($site['phone']) ?></a></li>
          <li class="site-footer__contact-row">
            <?php icon('pin', ['width' => 18, 'height' => 18]); ?><span><?= e($site['address']) ?></span>
          </li>
        </ul>
      </div>
    </div>

    <div class="site-footer__bottom">
      <span>&copy; <?= date('Y') ?> Samachar Manyata Association for Research and Training. All rights reserved.</span>
      <span>Powered by <a href="https://dashandots.com" target="_blank">Dashandots Technology</a></span>
    </div>
  </div>
</footer>

<script src="<?= e(asset('/assets/js/main.js')) ?>" defer></script>
</body>

</html>