<?php
$site = config('site');
$nav = config('nav');
$pageKey = $pageKey ?? 'home';
require_once app_path('partials/icons.php');
?>
<!DOCTYPE html>
<html lang="en-IN">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="robots" content="index,follow,max-image-preview:large">
  <link rel="icon" type="image/png" href="<?= e(asset('/assets/img/logo.png')) ?>">
  <link rel="apple-touch-icon" href="<?= e(asset('/assets/img/logo.png')) ?>">
  <link rel="manifest" href="/manifest.webmanifest">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preload" as="style"
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Montserrat:wght@400;500;600;700&family=Tiro+Devanagari+Hindi&display=swap">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Montserrat:wght@400;500;600;700&family=Tiro+Devanagari+Hindi&display=swap">
  <link rel="stylesheet" href="<?= e(asset('/assets/css/tokens.css')) ?>">
  <link rel="stylesheet" href="<?= e(asset('/assets/css/base.css')) ?>">
  <link rel="stylesheet" href="<?= e(asset('/assets/css/components.css')) ?>">
  <?php
  require_once app_path('lib/seo.php');
  render_head($pageKey);
  render_jsonld_organization();
  render_jsonld_website();
  if (!empty($extraJsonLd) && is_callable($extraJsonLd)) {
    $extraJsonLd();
  }
  ?>
</head>

<body>
  <a href="#main" class="skip-link">Skip to content</a>
  <div class="tricolor" aria-hidden="true"></div>

  <header class="site-header" role="banner">
    <div class="container container--wide site-header__inner">
      <a href="/" class="brand" aria-label="<?= e($site['name']) ?> home">
        <img src="<?= e(asset('/assets/img/logo.png')) ?>" alt="SMaRT Logo" class="brand__mark" width="44" height="44">
        <span class="brand__text">
          <span class="brand__name"><?= e($site['name']) ?></span>
          <span class="brand__sub">For Research &amp; Training</span>
        </span>
      </a>

      <nav class="nav" aria-label="Primary">
        <ul class="nav__list">
          <?php foreach ($nav as $item): ?>
            <li><a class="nav__link <?= is_active($item['href']) ? 'is-active' : '' ?>"
                href="<?= e($item['href']) ?>"><?= e($item['label']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>

      <div class="header__cta">
        <a href="/my-account" class="btn btn--ghost btn--sm">
          <?php icon('lock', ['width' => 16, 'height' => 16]); ?>
          Member Portal
        </a>
        <a href="/join" class="btn btn--primary btn--sm">Join the Coalition</a>
      </div>

      <button class="nav-toggle" type="button" aria-label="Toggle navigation" aria-controls="nav-drawer"
        aria-expanded="false">
        <span class="nav-toggle__bar" aria-hidden="true"></span>
      </button>
    </div>
  </header>

  <aside id="nav-drawer" class="nav-drawer" aria-label="Site menu">
    <button type="button" class="nav-drawer__close" aria-label="Close menu">
      <?php icon('close', ['width' => 22, 'height' => 22]); ?>
    </button>
    <nav aria-label="Primary mobile">
      <ul class="nav__list">
        <?php foreach ($nav as $item): ?>
          <li><a class="nav__link <?= is_active($item['href']) ? 'is-active' : '' ?>"
              href="<?= e($item['href']) ?>"><?= e($item['label']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <div class="nav-drawer__cta">
      <a href="/my-account" class="btn btn--ghost-light">Member Portal</a>
      <a href="/join" class="btn btn--primary">Join the Coalition</a>
    </div>
  </aside>

  <!-- ===== 5th Anniversary Popup ===== -->
  <div id="anniv-popup" class="anniv-overlay" role="dialog" aria-modal="true" aria-labelledby="anniv-title" hidden>
    <div class="anniv-backdrop"></div>
    <div class="anniv-card">

      <!-- Sparkle particles -->
      <div class="anniv-sparks" aria-hidden="true">
        <?php for ($i = 1; $i <= 18; $i++): ?>
          <span class="spark spark--<?= $i ?>"></span>
        <?php endfor; ?>
      </div>

      <!-- Close -->
      <button class="anniv-close" id="anniv-close" aria-label="Close anniversary popup" type="button">
        <?php icon('close', ['width' => 20, 'height' => 20]); ?>
      </button>

      <!-- Gold arc -->
      <div class="anniv-arc" aria-hidden="true">
        <svg viewBox="0 0 560 140" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M20 130 Q280 -20 540 130" stroke="url(#arcGold)" stroke-width="2.5" stroke-linecap="round" fill="none"/>
          <defs>
            <linearGradient id="arcGold" x1="0" y1="0" x2="560" y2="0" gradientUnits="userSpaceOnUse">
              <stop offset="0%" stop-color="#B8860B" stop-opacity="0"/>
              <stop offset="30%" stop-color="#FFD700"/>
              <stop offset="50%" stop-color="#FFC107"/>
              <stop offset="70%" stop-color="#FFD700"/>
              <stop offset="100%" stop-color="#B8860B" stop-opacity="0"/>
            </linearGradient>
          </defs>
        </svg>
      </div>

      <!-- Logo mark -->
      <div class="anniv-logo">
        <img src="<?= e(asset('/assets/img/logo.png')) ?>" alt="SMaRT logo" width="80" height="80">
      </div>

      <!-- Badge -->
      <div class="anniv-badge" aria-hidden="true">5TH YEAR</div>

      <!-- Headline -->
      <h2 id="anniv-title" class="anniv-title">
        <span class="anniv-title__smart">SMaRT</span>
        <span class="anniv-title__summit">Summit</span>
      </h2>

      <!-- Anniversary line -->
      <div class="anniv-rule">
        <span class="anniv-rule__line"></span>
        <span class="anniv-rule__text">5TH ANNIVERSARY</span>
        <span class="anniv-rule__line"></span>
      </div>

      <!-- Sub copy -->
      <p class="anniv-sub">Five years of backing India's most authentic voices.<br>One summit to celebrate every voice that stood firm.</p>

      <!-- CTAs -->
      <div class="anniv-ctas">
        <a href="/join" class="btn btn--primary anniv-btn-join">Join the Summit</a>
        <button type="button" class="anniv-btn-skip" id="anniv-skip">Maybe Later</button>
      </div>

    </div>
  </div>
  <!-- ===== /5th Anniversary Popup ===== -->

  <main id="main">
