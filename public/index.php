<?php
require_once __DIR__ . '/../app/lib/render.php';
require_once app_path('partials/icons.php');

$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$routes = [
    '/about' => 'about.php',
    '/pillars' => 'pillars.php',
    '/directory' => 'directory.php',
    '/resources' => 'resources.php',
    '/news-events' => 'news-events.php',
    '/contact' => 'contact.php',
    '/join' => 'join.php',
    '/donate' => 'donate.php',
    '/member-portal' => 'member-portal.php',
    '/my-account' => 'my-account.php',
    '/faq' => 'faq.php',
];
if (isset($routes[$requestPath])) {
    require __DIR__ . '/' . $routes[$requestPath];
    exit;
}

$pageKey = 'home';
$site = config('site');
$challenges = load_data('challenges');
$pillars = load_data('pillars');
$timeline = load_data('timeline');
$features = load_data('features');
$faq = load_data('faq');

$extraJsonLd = function () use ($faq) {
    render_jsonld_faq(array_slice($faq, 0, 5));
};

partial('header', compact('pageKey', 'extraJsonLd'));
?>

<!-- ============ HERO ============ -->
<section class="hero" aria-labelledby="hero-title">
  <div class="hero__paisley" aria-hidden="true"></div>
  <div class="hero__chakra-bg" aria-hidden="true">
    <?= file_get_contents(app_root() . '/public/assets/img/chakra.svg') ?>
  </div>
  <div class="container hero__inner">
    <div class="reveal">
      <span class="hero__eyebrow"><span class="dot"></span> A Force Multiplier for Bharatiya Media</span>
      <h1 class="hero__title" id="hero-title">
        Empowering
        <span class="accent">The Voice of <span class="accent-blue">The Nation</span></span>
      </h1>
      <p class="hero__lede">Samachar Manyata Association for Research and Training (SMaRT) unites 350+ independent nationalistic media platforms across 10 Bharatiya languages — research, financial synergy, amplification.</p>
      <div class="hero__cta">
        <a href="/join" class="btn btn--navy btn--lg">Join the Coalition <span class="arr" aria-hidden="true">→</span></a>
        <a href="/donate" class="btn btn--primary btn--lg">Support Our Cause <span class="arr" aria-hidden="true">→</span></a>
      </div>
      <div class="hero__trust">
        <span><strong><?= e((string)$site['stats']['portals']) ?>+</strong> Portals Connected</span>
        <span><strong><?= e($site['stats']['reach']) ?></strong> Combined Reach</span>
        <span><strong><?= e((string)$site['stats']['journalists']) ?>+</strong> Journalists Trained</span>
        <span><strong>Global</strong> Reach</span>
      </div>
    </div>
    <div class="hero__art reveal" aria-hidden="true">
      <img src="<?= e(asset('/assets/img/hero-media-desk.png')) ?>" alt="" loading="eager" decoding="async">
    </div>
  </div>
</section>

<!-- ============ CHALLENGES ============ -->
<section class="section section--bg" aria-labelledby="ch-title">
  <div class="container">
    <div class="section__head reveal">
      <span class="section__eyebrow">Challenges We Solve</span>
      <h2 class="section__title" id="ch-title">The Challenges We Solve</h2>
      <p class="section__lede">Independent nationalistic media faces three persistent barriers. SMaRT exists to dismantle each one.</p>
    </div>
    <div class="card-grid card-grid--3">
      <?php foreach ($challenges as $i => $c): ?>
      <article class="card reveal" style="transition-delay:<?= $i * 60 ?>ms">
        <div class="card__icon card__icon--<?= e($c['tone']) ?>" aria-hidden="true">
          <?php icon($c['icon'], ['width' => 28, 'height' => 28]); ?>
        </div>
        <h3 class="card__title"><?= e($c['title']) ?></h3>
        <p class="card__summary"><?= e($c['summary']) ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ MISSION + FORCE MULTIPLIER ============ -->
<section class="section" aria-labelledby="mission-title">
  <div class="container">
    <div class="mission">
      <div class="reveal">
        <span class="mission__eyebrow">Our Mission</span>
        <h2 class="mission__title" id="mission-title">The SMaRT Initiative</h2>
        <h3 class="mission__subhead">About Us</h3>
        <p>SMaRT is the conduit that connects independent nationalistic media platforms. We bridge the gap between isolated voices and a fragmented digital landscape, creating a unified front.</p>
        <p>We provide the infrastructure, research, training, and financial synergy needed to amplify credible narratives and empower the voice of the nation.</p>
        <a href="/about" class="btn btn--ghost btn--sm mt-4">Read Our Story <span class="arr" aria-hidden="true">→</span></a>
      </div>
      <div class="mission__diagram reveal" aria-hidden="true">
        <?= file_get_contents(app_root() . '/public/assets/img/force-multiplier.svg') ?>
      </div>
    </div>
  </div>
</section>

<!-- ============ PILLARS ============ -->
<section class="section section--bg" aria-labelledby="pillars-title">
  <div class="container">
    <div class="section__head reveal">
      <span class="section__eyebrow">Our Pillars of Support</span>
      <h2 class="section__title" id="pillars-title">What We Provide to Our Members</h2>
    </div>
    <div class="card-grid card-grid--3">
      <?php foreach ($pillars as $i => $p): ?>
      <article class="card pillar-card reveal" style="transition-delay:<?= $i * 80 ?>ms">
        <div class="card__icon card__icon--<?= $p['color'] === 'saffron' ? 'saffron' : 'navy' ?>" aria-hidden="true">
          <?php icon($p['icon'], ['width' => 28, 'height' => 28]); ?>
        </div>
        <h3 class="card__title">
          <span class="devnum" aria-hidden="true"><?= e($p['devanagari']) ?></span>&nbsp; <?= e($p['title']) ?>
        </h3>
        <div class="pillar-card__divider"></div>
        <p class="card__summary"><?= e($p['summary']) ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ TIMELINE ============ -->
<section class="section" aria-labelledby="tl-title">
  <div class="container">
    <div class="section__head reveal">
      <span class="section__eyebrow">From Vision to Force Multiplier</span>
      <h2 class="section__title" id="tl-title">SMaRT&rsquo;s Journey</h2>
      <p class="section__lede">From 25 founding members on Dusherra 2020 to a coalition of 350+ portals reaching 400M+ Bharatiyas.</p>
    </div>
    <div class="timeline">
      <?php foreach ($timeline as $i => $t): ?>
      <article class="tl-card reveal" style="transition-delay:<?= $i * 80 ?>ms">
        <div class="tl-card__icon" aria-hidden="true"><?php icon($t['icon'], ['width' => 36, 'height' => 36]); ?></div>
        <span class="tl-card__year"><?= e($t['year']) ?></span>
        <span class="tl-card__devyear" lang="hi"><?= e($t['devanagari']) ?></span>
        <p class="tl-card__meta">
          <strong><?= e((string)$t['members']) ?>+ Members</strong>
          Reach <?= e($t['reach']) ?><br>
          <span class="muted"><?= e($t['note']) ?></span>
        </p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ FEATURES (navy) ============ -->
<section class="features" aria-labelledby="ft-title">
  <div class="container">
    <div class="section__head reveal">
      <span class="section__eyebrow">Built for Impact. Designed for Media.</span>
      <h2 class="section__title" id="ft-title">Powerful Features for a Stronger Network</h2>
    </div>
    <div class="card-grid card-grid--4">
      <?php foreach ($features as $i => $f): ?>
      <article class="feature-card reveal" style="transition-delay:<?= $i * 70 ?>ms">
        <span class="feature-card__icon" aria-hidden="true"><?php icon($f['icon'], ['width' => 24, 'height' => 24]); ?></span>
        <div>
          <h3><?= e($f['title']) ?></h3>
          <p><?= e($f['summary']) ?></p>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ COALITION BANNER ============ -->
<section class="coalition" aria-labelledby="co-title">
  <div class="container">
    <div class="reveal">
      <h2 id="co-title">Stronger Together. Impact Beyond Measure.</h2>
      <p>Join the movement. Support the mission. Be the voice of change.</p>
      <div class="coalition__cta">
        <a href="/join" class="btn btn--navy btn--lg">Join the Coalition</a>
        <a href="/donate" class="btn btn--ghost btn--lg">Support Our Cause</a>
      </div>
    </div>
  </div>
</section>

<!-- ============ KPI STRIP ============ -->
<section class="kpi-strip" aria-label="Impact metrics">
  <div class="container kpi-grid">
    <div class="kpi"><span class="kpi__icon"><?php icon('users', ['width' => 38, 'height' => 38]); ?></span><div><span class="kpi__num" data-count="<?= e((string)$site['stats']['portals']) ?>" data-suffix="+">0</span><span class="kpi__label">Portals Connected</span></div></div>
    <div class="kpi"><span class="kpi__icon"><?php icon('amplify', ['width' => 38, 'height' => 38]); ?></span><div><span class="kpi__num"><?= e($site['stats']['reach']) ?></span><span class="kpi__label">Combined Reach</span></div></div>
    <div class="kpi"><span class="kpi__icon"><?php icon('book', ['width' => 38, 'height' => 38]); ?></span><div><span class="kpi__num" data-count="<?= e((string)$site['stats']['journalists']) ?>" data-suffix="+">0</span><span class="kpi__label">Journalists Trained</span></div></div>
    <div class="kpi"><span class="kpi__icon"><?php icon('globe', ['width' => 38, 'height' => 38]); ?></span><div><span class="kpi__num">1 Mission</span><span class="kpi__label">Empowering Bharat</span></div></div>
    <div class="kpi-strip__brand">
      <img src="<?= e(asset('/assets/img/logo.svg')) ?>" alt="" width="36" height="36">
      <span>SMaRT4Bharat</span>
    </div>
  </div>
</section>

<!-- ============ FAQ ============ -->
<section class="section" aria-labelledby="faq-title">
  <div class="container">
    <div class="section__head reveal">
      <span class="section__eyebrow">Answers</span>
      <h2 class="section__title" id="faq-title">Frequently Asked Questions</h2>
      <p class="section__lede">Quick answers about the coalition, membership, and how we work.</p>
    </div>
    <div class="faq-list">
      <?php foreach (array_slice($faq, 0, 5) as $i => $item): ?>
      <details class="faq-item reveal" <?= $i === 0 ? 'open' : '' ?>>
        <summary><?= e($item['q']) ?></summary>
        <p><?= e($item['a']) ?></p>
      </details>
      <?php endforeach; ?>
    </div>
    <p class="text-center mt-6"><a href="/faq" class="btn btn--ghost btn--sm">See all FAQs <span class="arr" aria-hidden="true">→</span></a></p>
  </div>
</section>

<?php partial('footer'); ?>
