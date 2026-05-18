<?php
require_once __DIR__ . '/../app/lib/render.php';
require_once app_path('lib/form.php');
require_once app_path('partials/icons.php');
form_session_start();
$pageKey = 'portal';

$msg = null; $err = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!form_csrf_check() || !form_honeypot_ok()) {
        $err = 'Security check failed.';
    } else {
        $email = form_input('email');
        if (!form_valid_email($email)) {
            $err = 'Please enter a valid email.';
        } else {
            form_store_row('portal-waitlist', ['email' => $email]);
            $msg = 'You are on the waitlist. We will notify you when the Member Portal launches.';
        }
    }
}
partial('header', compact('pageKey'));
?>
<section class="page-head">
  <div class="container">
    <nav class="page-head__crumbs" aria-label="Breadcrumb"><a href="/">Home</a> / Member Portal</nav>
    <h1>Member Portal — Launching Soon</h1>
    <p>A secure space for SMaRT coalition members to access research, training assets, member directory, and shared tools.</p>
  </div>
</section>

<section class="section section--bg">
  <div class="container" style="max-width:560px">
    <div class="form-card reveal text-center">
      <span class="card__icon card__icon--saffron" style="margin:0 auto var(--sp-4)"><?php icon('lock', ['width' => 28, 'height' => 28]); ?></span>
      <h2>Join the Waitlist</h2>
      <p class="muted">Be first to know when the portal opens. Existing members will receive login credentials via email.</p>
      <?php if ($msg): ?><div class="alert alert--ok mt-4"><?= e($msg) ?></div><?php endif; ?>
      <?php if ($err): ?><div class="alert alert--err mt-4"><?= e($err) ?></div><?php endif; ?>
      <form method="post" novalidate class="mt-4">
        <input type="hidden" name="_csrf" value="<?= e(form_csrf_token()) ?>">
        <div class="field field--hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
        <div class="field"><label for="p-email" class="sr-only">Email</label><input id="p-email" name="email" type="email" required placeholder="your@email.com" maxlength="160"></div>
        <button type="submit" class="btn btn--primary mt-4" style="width:100%">Notify Me <span class="arr" aria-hidden="true">→</span></button>
      </form>
    </div>
  </div>
</section>

<?php partial('footer'); ?>
