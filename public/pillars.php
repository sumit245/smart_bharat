<?php
require_once __DIR__ . '/../app/lib/render.php';
require_once app_path('partials/icons.php');
$pageKey = 'pillars';
$pillars = load_data('pillars');
$extraJsonLd = function () {
    render_jsonld_breadcrumb([
        ['name' => 'Home', 'href' => '/'],
        ['name' => 'Our Pillars', 'href' => '/pillars'],
    ]);
};
partial('header', compact('pageKey', 'extraJsonLd'));
?>
<section class="page-head">
  <div class="container">
    <nav class="page-head__crumbs" aria-label="Breadcrumb"><a href="/">Home</a> / Our Pillars</nav>
    <h1>What SMaRT Does for Its Members</h1>
    <p>Five active programmes. One free membership.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php foreach ($pillars as $i => $p): ?>
    <div class="mission reveal" id="<?= e($p['key']) ?>" style="margin-bottom:var(--sp-10)">
      <div class="<?= $i % 2 === 1 ? 'order-2' : '' ?>">
        <span class="devnum" style="font-size:1.75rem"><?= e($p['devanagari']) ?></span>
        <h2 style="margin-top:0.5rem"><?= e($p['title']) ?></h2>
        <p class="muted"><?= e($p['description']) ?></p>
        <ul style="margin-top:1rem;list-style:none;padding:0;display:grid;gap:0.75rem">
          <?php foreach ($p['details'] as $d): ?>
          <li style="display:flex;gap:0.75rem;align-items:flex-start">
            <span style="color:var(--c-saffron-deep);flex-shrink:0;margin-top:4px"><?php icon('check', ['width' => 18, 'height' => 18, 'stroke-width' => 2.2]); ?></span>
            <span><?= e($d) ?></span>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="card" style="background:linear-gradient(135deg,#FFF7EC 0%,#FFFFFF 100%);min-height:280px;display:grid;place-items:center">
        <div style="width:140px;height:140px;color:var(--c-saffron-deep)">
          <?php icon($p['icon'], ['width' => 140, 'height' => 140, 'stroke-width' => 1.2]); ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<?php partial('footer'); ?>
