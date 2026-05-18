<?php
require_once __DIR__ . '/../app/lib/render.php';
require_once app_path('partials/icons.php');
$pageKey = 'faq';
$faq = load_data('faq');
$extraJsonLd = function () use ($faq) {
    render_jsonld_faq($faq);
    render_jsonld_breadcrumb([
        ['name' => 'Home', 'href' => '/'],
        ['name' => 'FAQ', 'href' => '/faq'],
    ]);
};
partial('header', compact('pageKey', 'extraJsonLd'));
?>
<section class="page-head">
  <div class="container">
    <nav class="page-head__crumbs" aria-label="Breadcrumb"><a href="/">Home</a> / FAQ</nav>
    <h1>Frequently Asked Questions</h1>
    <p>What is SMaRT? Who can join? How does the coalition support members? Answers below.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="faq-list">
      <?php foreach ($faq as $i => $item): ?>
      <details class="faq-item reveal" <?= $i === 0 ? 'open' : '' ?>>
        <summary><?= e($item['q']) ?></summary>
        <p><?= e($item['a']) ?></p>
      </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php partial('footer'); ?>
