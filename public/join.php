<?php
require_once __DIR__ . '/../app/lib/render.php';
require_once app_path('lib/form.php');
require_once app_path('partials/icons.php');
form_session_start();
$pageKey = 'join';

$msg = null; $err = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!form_csrf_check() || !form_honeypot_ok()) {
        $err = 'Security check failed. Please try again.';
    } else {
        $name = form_input('name');
        $portal = form_input('portal');
        $url = form_input('url');
        $email = form_input('email');
        $phone = form_input('phone');
        $language = form_input('language');
        $state = form_input('state');
        $about = form_input('about');
        $type = form_input('type');
        if ($name === '' || $portal === '' || !form_valid_email($email) || $about === '') {
            $err = 'Please complete name, portal name, valid email, and a short description.';
        } else {
            form_store_row('join', compact('name', 'portal', 'url', 'email', 'phone', 'language', 'state', 'type', 'about'));
            $msg = 'Application received. The editorial jury will review and respond within 7 business days.';
        }
    }
}
$extraJsonLd = function () {
    render_jsonld_breadcrumb([
        ['name' => 'Home', 'href' => '/'],
        ['name' => 'Join', 'href' => '/join'],
    ]);
};
partial('header', compact('pageKey', 'extraJsonLd'));
$langs = ['Tamil','Telugu','Malayalam','Hindi','Kannada','Odia','Bengali','Gujarati','Sanskrit','English','Multilingual'];
?>
<section class="page-head">
  <div class="container">
    <nav class="page-head__crumbs" aria-label="Breadcrumb"><a href="/">Home</a> / Join</nav>
    <h1>Join the Coalition</h1>
    <p>Apply to become an Approved Nationalistic Portal. Access research, training, financial synergy, and a 400M+ amplification network.</p>
  </div>
</section>

<section class="section section--bg">
  <div class="container" style="max-width:760px">
    <form method="post" class="form-card reveal" novalidate>
      <?php if ($msg): ?><div class="alert alert--ok"><?= e($msg) ?></div><?php endif; ?>
      <?php if ($err): ?><div class="alert alert--err"><?= e($err) ?></div><?php endif; ?>
      <input type="hidden" name="_csrf" value="<?= e(form_csrf_token()) ?>">
      <div class="field field--hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
      <div class="form-grid form-grid--2">
        <div class="field"><label for="j-name">Your Name</label><input id="j-name" name="name" type="text" required maxlength="120"></div>
        <div class="field"><label for="j-portal">Portal / Channel Name</label><input id="j-portal" name="portal" type="text" required maxlength="160"></div>
        <div class="field"><label for="j-email">Email</label><input id="j-email" name="email" type="email" required maxlength="160"></div>
        <div class="field"><label for="j-phone">Phone</label><input id="j-phone" name="phone" type="tel" maxlength="40"></div>
        <div class="field"><label for="j-url">Website / Channel URL</label><input id="j-url" name="url" type="url" maxlength="240"></div>
        <div class="field"><label for="j-language">Primary Language</label>
          <select id="j-language" name="language">
            <option value="">Select…</option>
            <?php foreach ($langs as $l): ?><option><?= e($l) ?></option><?php endforeach; ?>
          </select>
        </div>
        <div class="field"><label for="j-state">State</label><input id="j-state" name="state" type="text" maxlength="80"></div>
        <div class="field"><label for="j-type">Type</label>
          <select id="j-type" name="type">
            <option>Portal</option><option>Podcast</option><option>YouTube Channel</option><option>Newsletter</option><option>Other</option>
          </select>
        </div>
      </div>
      <div class="field mt-4"><label for="j-about">Tell us about your work</label><textarea id="j-about" name="about" rows="6" required maxlength="2000" placeholder="What does your platform cover? Average monthly reach? Editorial focus?"></textarea></div>
      <button type="submit" class="btn btn--primary mt-4">Submit Application <span class="arr" aria-hidden="true">→</span></button>
    </form>
  </div>
</section>

<?php partial('footer'); ?>
