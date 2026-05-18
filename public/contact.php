<?php
require_once __DIR__ . '/../app/lib/render.php';
require_once app_path('lib/form.php');
require_once app_path('partials/icons.php');
form_session_start();
$pageKey = 'contact';
$site = config('site');

$msg = null; $err = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!form_csrf_check() || !form_honeypot_ok()) {
        $err = 'Security check failed. Please try again.';
    } else {
        $name = form_input('name');
        $email = form_input('email');
        $subject = form_input('subject');
        $message = form_input('message');
        if ($name === '' || !form_valid_email($email) || $message === '') {
            $err = 'Please complete name, valid email, and message.';
        } else {
            form_store_row('contact', compact('name', 'email', 'subject', 'message'));
            $msg = 'Thank you. We have received your message and will respond within 2 business days.';
        }
    }
}
$extraJsonLd = function () {
    render_jsonld_breadcrumb([
        ['name' => 'Home', 'href' => '/'],
        ['name' => 'Contact', 'href' => '/contact'],
    ]);
};
partial('header', compact('pageKey', 'extraJsonLd'));
?>
<section class="page-head">
  <div class="container">
    <nav class="page-head__crumbs" aria-label="Breadcrumb"><a href="/">Home</a> / Contact</nav>
    <h1>Contact SMaRT4Bharat</h1>
    <p>For partnerships, membership, press, or volunteering — reach the coalition directly.</p>
  </div>
</section>

<section class="section section--bg">
  <div class="container" style="max-width:1000px;display:grid;gap:2rem;grid-template-columns:1fr">
    <div class="grid" style="grid-template-columns:1fr;gap:1.25rem">
      <div class="card">
        <span class="card__icon card__icon--saffron" style="width:44px;height:44px"><?php icon('mail', ['width' => 22, 'height' => 22]); ?></span>
        <h3 class="card__title" style="font-size:1.05rem">Email</h3>
        <p class="card__summary"><a href="mailto:<?= e($site['email']) ?>"><?= e($site['email']) ?></a></p>
      </div>
      <div class="card">
        <span class="card__icon card__icon--navy" style="width:44px;height:44px"><?php icon('phone', ['width' => 22, 'height' => 22]); ?></span>
        <h3 class="card__title" style="font-size:1.05rem">Phone</h3>
        <p class="card__summary"><a href="tel:<?= e(preg_replace('/\s+/', '', $site['phone'])) ?>"><?= e($site['phone']) ?></a></p>
      </div>
      <div class="card">
        <span class="card__icon card__icon--saffron" style="width:44px;height:44px"><?php icon('pin', ['width' => 22, 'height' => 22]); ?></span>
        <h3 class="card__title" style="font-size:1.05rem">Address</h3>
        <p class="card__summary"><?= e($site['address']) ?></p>
      </div>
    </div>

    <form method="post" class="form-card reveal" novalidate>
      <h2>Send Us a Message</h2>
      <?php if ($msg): ?><div class="alert alert--ok"><?= e($msg) ?></div><?php endif; ?>
      <?php if ($err): ?><div class="alert alert--err"><?= e($err) ?></div><?php endif; ?>
      <input type="hidden" name="_csrf" value="<?= e(form_csrf_token()) ?>">
      <div class="field field--hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
      <div class="form-grid form-grid--2">
        <div class="field"><label for="c-name">Name</label><input id="c-name" name="name" type="text" required maxlength="120"></div>
        <div class="field"><label for="c-email">Email</label><input id="c-email" name="email" type="email" required maxlength="160"></div>
      </div>
      <div class="field mt-4"><label for="c-subject">Subject</label><input id="c-subject" name="subject" type="text" maxlength="160"></div>
      <div class="field mt-4"><label for="c-message">Message</label><textarea id="c-message" name="message" rows="6" required maxlength="2000"></textarea></div>
      <button type="submit" class="btn btn--primary mt-4">Send Message <span class="arr" aria-hidden="true">→</span></button>
    </form>
  </div>
</section>

<?php partial('footer'); ?>
