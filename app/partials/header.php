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
  <link rel="icon" type="image/svg+xml" href="<?= e(asset('/assets/img/logo.svg')) ?>">
  <link rel="apple-touch-icon" href="<?= e(asset('/assets/img/logo.svg')) ?>">
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

  <main id="main">
