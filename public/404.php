<?php
http_response_code(404);
require_once __DIR__ . '/../app/lib/render.php';
$pageKey = 'home';
partial('header', compact('pageKey'));
?>
<section class="page-head">
  <div class="container">
    <h1>Page Not Found</h1>
    <p>The page you are looking for has moved or no longer exists.</p>
    <p class="mt-4"><a href="/" class="btn btn--primary">Return Home <span class="arr" aria-hidden="true">→</span></a></p>
  </div>
</section>
<?php partial('footer'); ?>
