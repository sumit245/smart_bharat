<?php
require_once __DIR__ . '/../app/lib/render.php';
require_once app_path('partials/icons.php');
$pageKey = 'resources';
$extraJsonLd = function () {
    render_jsonld_breadcrumb([
        ['name' => 'Home', 'href' => '/'],
        ['name' => 'Resources', 'href' => '/resources'],
    ]);
};
partial('header', compact('pageKey', 'extraJsonLd'));

$resources = [
    ['icon' => 'book', 'title' => 'Research Papers', 'desc' => 'Peer-reviewed studies on Bharatiya media, civilisational journalism, and editorial standards across 10 languages.'],
    ['icon' => 'amplify', 'title' => 'Training Modules', 'desc' => 'Fact-checking, investigative methods, civilisational studies, and editorial workshops for coalition members.'],
    ['icon' => 'list', 'title' => 'Translate Books', 'desc' => 'Translation pipeline for important Indic texts and contemporary nationalist scholarship.'],
    ['icon' => 'chart', 'title' => 'Software &amp; Tools', 'desc' => 'Shared editorial CMS, analytics, transcription, and translation utilities for member portals.'],
    ['icon' => 'mail', 'title' => 'Newsletters &amp; Briefings', 'desc' => 'Weekly editorial briefings and member spotlights delivered to your inbox.'],
    ['icon' => 'users', 'title' => 'Mentorship Programmes', 'desc' => 'Senior editors and journalists mentoring next-generation Bharatiya media entrepreneurs.'],
];
?>
<section class="page-head">
  <div class="container">
    <nav class="page-head__crumbs" aria-label="Breadcrumb"><a href="/">Home</a> / Resources</nav>
    <h1>Resources for Bharatiya Media</h1>
    <p>Research, training, translation, and tools — built to elevate the quality of nationalistic discourse.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="card-grid card-grid--3">
      <?php foreach ($resources as $i => $r): ?>
      <article class="card reveal" style="transition-delay:<?= $i * 60 ?>ms">
        <div class="card__icon card__icon--<?= $i % 2 ? 'navy' : 'saffron' ?>"><?php icon($r['icon'], ['width' => 28, 'height' => 28]); ?></div>
        <h3 class="card__title"><?= $r['title'] ?></h3>
        <p class="card__summary"><?= $r['desc'] ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php partial('footer'); ?>
