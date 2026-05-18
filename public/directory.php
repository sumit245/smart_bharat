<?php
require_once __DIR__ . '/../app/lib/render.php';
require_once app_path('partials/icons.php');
$pageKey = 'directory';
$dir = load_data('directory');
$langs = array_values(array_unique(array_column($dir, 'language')));
$types = array_values(array_unique(array_column($dir, 'type')));
sort($langs); sort($types);
$extraJsonLd = function () {
    render_jsonld_breadcrumb([
        ['name' => 'Home', 'href' => '/'],
        ['name' => 'Directory', 'href' => '/directory'],
    ]);
};
partial('header', compact('pageKey', 'extraJsonLd'));
?>
<section class="page-head">
  <div class="container">
    <nav class="page-head__crumbs" aria-label="Breadcrumb"><a href="/">Home</a> / Directory</nav>
    <h1>Approved Nationalistic Portals</h1>
    <p>Curated, vetted media portals across 10 Bharatiya languages and 10 states. Filter by language and type to discover authentic voices.</p>
  </div>
</section>

<section class="section section--bg">
  <div class="container">
    <div class="dir-controls">
      <input type="search" id="dir-search" placeholder="Search portal by name…" aria-label="Search directory">
      <select id="dir-lang" aria-label="Filter by language">
        <option value="">All languages</option>
        <?php foreach ($langs as $l): ?><option value="<?= e($l) ?>"><?= e($l) ?></option><?php endforeach; ?>
      </select>
      <select id="dir-type" aria-label="Filter by type">
        <option value="">All types</option>
        <?php foreach ($types as $t): ?><option value="<?= e($t) ?>"><?= e($t) ?></option><?php endforeach; ?>
      </select>
    </div>

    <div class="dir-grid">
      <?php foreach ($dir as $d): ?>
      <article class="dir-card reveal" data-name="<?= e($d['name']) ?>" data-lang="<?= e($d['language']) ?>" data-type="<?= e($d['type']) ?>">
        <span class="dir-card__tag"><?= e($d['type']) ?></span>
        <h3><?= e($d['name']) ?></h3>
        <div class="dir-card__meta">
          <span><?php icon('globe', ['width' => 14, 'height' => 14]); ?> <?= e($d['language']) ?></span>
          <span><?php icon('pin', ['width' => 14, 'height' => 14]); ?> <?= e($d['state']) ?></span>
        </div>
        <p class="mt-4"><a href="<?= e($d['url']) ?>" class="btn btn--ghost btn--sm">Visit Portal <span class="arr" aria-hidden="true">→</span></a></p>
      </article>
      <?php endforeach; ?>
    </div>

    <p class="text-center mt-8 muted">Showing a sample of 350+ approved member portals. Full directory available in the Member Portal.</p>
  </div>
</section>

<?php partial('footer'); ?>
