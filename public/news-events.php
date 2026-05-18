<?php
require_once __DIR__ . '/../app/lib/render.php';
require_once app_path('partials/icons.php');
$pageKey = 'news';
$news = load_data('news');
$extraJsonLd = function () {
    render_jsonld_breadcrumb([
        ['name' => 'Home', 'href' => '/'],
        ['name' => 'News & Events', 'href' => '/news-events'],
    ]);
};
partial('header', compact('pageKey', 'extraJsonLd'));
?>
<section class="page-head">
  <div class="container">
    <nav class="page-head__crumbs" aria-label="Breadcrumb"><a href="/">Home</a> / News &amp; Events</nav>
    <h1>News &amp; Events</h1>
    <p>Coalition milestones, member spotlights, and upcoming events.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="news-grid">
      <?php foreach ($news as $i => $n): ?>
      <article class="news-card reveal" style="transition-delay:<?= $i * 60 ?>ms">
        <span class="news-card__tag"><?= e($n['tag']) ?></span>
        <span class="news-card__date"><time datetime="<?= e($n['date']) ?>"><?= e(date('d M Y', strtotime($n['date']))) ?></time> · <?= e($n['author']) ?></span>
        <h3><?= e($n['title']) ?></h3>
        <p><?= e($n['summary']) ?></p>
        <a href="#" class="btn btn--ghost btn--sm">Read more <span class="arr" aria-hidden="true">→</span></a>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php partial('footer'); ?>
