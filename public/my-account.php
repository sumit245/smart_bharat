<?php
require_once __DIR__ . '/../app/lib/render.php';
require_once app_path('lib/form.php');
require_once app_path('partials/icons.php');
form_session_start();

$pageKey = 'account';
$msg = null;
$err = null;
$activePanel = 'join';

$languages = ['Assamese','Bengali','Bodo','English','Gujarati','Gondi','Garo','Dogri','Hindi','Kashmiri','Konkani','Kurukh','Khandeshi','Khasi','Latin','Malayalam','Marathi','Maithili','Meitei','Mundari','Nepali','Punjabi','Tamil','Telugu','Tripuri','Tibetan','Tulu','Urdu','Kannada','Sanskrit','Santali','Sindhi','Odia','Multilingual'];
$audiences = ['More than 10000000 (>= 10MN)','300000 - 9999999 (>= 3 lacs)','100000 - 299999 (>= 1 lacs)','Less than 100000 (< 1 lac)'];
$modes = [
    'news_website' => 'News Website / Portal',
    'youtube' => 'YouTube Channel',
    'cartoonist' => 'Cartoonist / Creative',
    'meme_page' => 'Meme Page',
    'print_media' => 'Print Media',
    'knowledge_partner' => 'Knowledge Partner',
    'friend' => 'Friend of SMaRT',
    'other' => 'Other',
];

function account_email_exists(string $email): bool {
    $file = app_path('data/account-join.csv');
    if (!is_file($file)) return false;
    $fh = fopen($file, 'rb');
    if (!$fh) return false;
    $header = fgetcsv($fh, null, ',', '"', '\\');
    $emailIndex = is_array($header) ? array_search('email', $header, true) : false;
    if ($emailIndex === false) {
        fclose($fh);
        return false;
    }
    while (($row = fgetcsv($fh, null, ',', '"', '\\')) !== false) {
        if (isset($row[$emailIndex]) && strcasecmp(trim($row[$emailIndex]), $email) === 0) {
            fclose($fh);
            return true;
        }
    }
    fclose($fh);
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = form_input('action');
    $activePanel = $action === 'login' || $action === 'forgot' ? 'login' : 'join';

    if (!form_csrf_check() || !form_honeypot_ok()) {
        $err = 'Security check failed. Please try again.';
    } elseif ($action === 'join') {
        $name = form_input('name');
        $email = form_input('email');
        $phone = form_input('phone');
        $password = form_input('password');
        $confirmPassword = form_input('confirm_password');
        $memberType = form_input('member_type');
        $language = form_input('language');
        $audience = form_input('audience');
        $city = form_input('city');
        $state = form_input('state');
        $platformName = form_input('platform_name');
        $website = form_input('platform_url');
        $youtube = form_input('youtube_url');
        $instagram = form_input('instagram_url');
        $facebook = form_input('facebook_url');
        $twitter = form_input('twitter_url');
        $printCirculation = form_input('print_circulation');
        $creativePortfolio = form_input('creative_portfolio');
        $webTraffic = form_input('web_traffic');
        $impressions = form_input('impressions');
        $yearFounded = form_input('year_founded');
        $subscribers = form_input('subscribers');
        $viewership = form_input('viewership');
        $publicationsPerMonth = form_input('publications_per_month');
        $occupation = form_input('occupation');
        $about = form_input('about');

        if ($name === '' || !form_valid_email($email) || $phone === '' || $platformName === '' || $about === '') {
            $err = 'Please complete name, email, phone, platform name, and a short profile.';
        } elseif (account_email_exists($email)) {
            $err = 'Duplicate email address. Try logging in or use a different email.';
        } elseif (strlen($password) < 10 || !preg_match('/[a-z]/', $password) || !preg_match('/[A-Z]/', $password) || !preg_match('/\d/', $password)) {
            $err = 'Password must contain lowercase, uppercase, a number, and minimum 10 characters.';
        } elseif ($password !== $confirmPassword) {
            $err = 'Passwords do not match.';
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            form_store_row('account-join', compact(
                'name',
                'email',
                'phone',
                'memberType',
                'language',
                'audience',
                'city',
                'state',
                'platformName',
                'website',
                'youtube',
                'instagram',
                'facebook',
                'twitter',
                'printCirculation',
                'creativePortfolio',
                'webTraffic',
                'impressions',
                'yearFounded',
                'subscribers',
                'viewership',
                'publicationsPerMonth',
                'occupation',
                'about',
                'passwordHash'
            ));
            $msg = 'Registration received. Your account request is queued for SMaRT review and OTP verification.';
        }
    } elseif ($action === 'login') {
        $email = form_input('login_email');
        if (!form_valid_email($email)) {
            $err = 'Please enter the email linked to your member profile.';
        } else {
            form_store_row('account-login-otp', ['email' => $email, 'purpose' => 'login']);
            $msg = 'OTP request recorded. In production this will send a one-time login code to your email or phone.';
        }
    } elseif ($action === 'forgot') {
        $email = form_input('forgot_email');
        if (!form_valid_email($email)) {
            $err = 'Please enter a valid recovery email.';
        } else {
            form_store_row('account-recovery', ['email' => $email]);
            $msg = 'Password reset request recorded. In production this will send a secure recovery link.';
        }
    }
}

$extraJsonLd = function () {
    render_jsonld_breadcrumb([
        ['name' => 'Home', 'href' => '/'],
        ['name' => 'My Account', 'href' => '/my-account'],
    ]);
};
partial('header', compact('pageKey', 'extraJsonLd'));
?>

<section class="page-head account-head">
  <div class="container">
    <nav class="page-head__crumbs" aria-label="Breadcrumb"><a href="/">Home</a> / My Account</nav>
    <h1>Join or Access SMaRT</h1>
    <p>Register as a media member, creative contributor, knowledge partner, or friend of the coalition. Existing members can request OTP access from the same page.</p>
  </div>
</section>

<section class="section section--bg">
  <div class="container account-layout">
    <aside class="account-aside reveal">
      <span class="card__icon card__icon--navy"><?php icon('lock', ['width' => 28, 'height' => 28]); ?></span>
      <h2>Member Access Features</h2>
      <ul class="account-feature-list">
        <li><?php icon('check', ['width' => 18, 'height' => 18]); ?> Registration by media type</li>
        <li><?php icon('check', ['width' => 18, 'height' => 18]); ?> OTP login and resend flow</li>
        <li><?php icon('check', ['width' => 18, 'height' => 18]); ?> Forgot-password recovery</li>
        <li><?php icon('check', ['width' => 18, 'height' => 18]); ?> Social and platform verification</li>
        <li><?php icon('check', ['width' => 18, 'height' => 18]); ?> Audience and language profiling</li>
      </ul>
      <p class="muted">Submissions are stored locally for review in this static PHP build. Authentication delivery can later be wired to email/SMS infrastructure.</p>
    </aside>

    <div class="account-card reveal">
      <?php if ($msg): ?><div class="alert alert--ok"><?= e($msg) ?></div><?php endif; ?>
      <?php if ($err): ?><div class="alert alert--err"><?= e($err) ?></div><?php endif; ?>

      <div class="account-tabs" role="tablist" aria-label="Account actions">
        <button type="button" class="account-tab <?= $activePanel === 'join' ? 'is-active' : '' ?>" data-account-tab="join" role="tab" aria-selected="<?= $activePanel === 'join' ? 'true' : 'false' ?>">Join SMaRT</button>
        <button type="button" class="account-tab <?= $activePanel === 'login' ? 'is-active' : '' ?>" data-account-tab="login" role="tab" aria-selected="<?= $activePanel === 'login' ? 'true' : 'false' ?>">Login / OTP</button>
      </div>

      <div class="account-panel <?= $activePanel === 'join' ? 'is-active' : '' ?>" data-account-panel="join" role="tabpanel">
        <form method="post" novalidate>
          <input type="hidden" name="_csrf" value="<?= e(form_csrf_token()) ?>">
          <input type="hidden" name="action" value="join">
          <div class="field field--hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

          <div class="form-grid form-grid--2">
            <div class="field"><label for="a-name">Full Name</label><input id="a-name" name="name" type="text" required maxlength="120" autocomplete="name"></div>
            <div class="field"><label for="a-email">Email</label><input id="a-email" name="email" type="email" required maxlength="160" autocomplete="email"></div>
            <div class="field"><label for="a-phone">Phone / WhatsApp</label><input id="a-phone" name="phone" type="tel" required maxlength="40" autocomplete="tel"></div>
            <div class="field"><label for="a-type">Register As</label>
              <select id="a-type" name="member_type" data-account-mode required>
                <?php foreach ($modes as $value => $label): ?><option value="<?= e($value) ?>"><?= e($label) ?></option><?php endforeach; ?>
              </select>
            </div>
            <div class="field"><label for="a-platform">Platform / Organisation Name</label><input id="a-platform" name="platform_name" type="text" required maxlength="160"></div>
            <div class="field"><label for="a-audience">How many viewers you have?</label>
              <select id="a-audience" name="audience">
                <option value="">Select reach</option>
                <?php foreach ($audiences as $audience): ?><option><?= e($audience) ?></option><?php endforeach; ?>
              </select>
            </div>
            <div class="field"><label for="a-language">Primary Language</label>
              <select id="a-language" name="language">
                <option value="">Select language</option>
                <?php foreach ($languages as $language): ?><option><?= e($language) ?></option><?php endforeach; ?>
              </select>
            </div>
            <div class="field"><label for="a-city">City</label><input id="a-city" name="city" type="text" maxlength="80"></div>
            <div class="field"><label for="a-state">State / Region</label><input id="a-state" name="state" type="text" maxlength="100"></div>
            <div class="field"><label for="a-url">Website / Main URL</label><input id="a-url" name="platform_url" type="url" maxlength="240" placeholder="https://"></div>
          </div>

          <div class="account-mode-fields" data-account-mode-panel="news_website">
            <div class="form-grid form-grid--2">
              <div class="field"><label for="a-web-traffic">Web traffic of your website</label><input id="a-web-traffic" name="web_traffic" type="text" maxlength="160"></div>
              <div class="field"><label for="a-impressions">Impressions in the past 6 months</label><input id="a-impressions" name="impressions" type="text" maxlength="160"></div>
              <div class="field"><label for="a-year">Year Founded</label><input id="a-year" name="year_founded" type="number" min="1900" max="2100"></div>
            </div>
          </div>

          <div class="account-mode-fields" data-account-mode-panel="youtube">
            <div class="form-grid form-grid--2">
              <div class="field"><label for="a-youtube">YouTube URL</label><input id="a-youtube" name="youtube_url" type="url" maxlength="240" placeholder="https://youtube.com/..."></div>
              <div class="field"><label for="a-subscribers">Number of subscribers</label><input id="a-subscribers" name="subscribers" type="text" maxlength="160"></div>
              <div class="field"><label for="a-viewership">Viewership reach in the past 6 months</label><input id="a-viewership" name="viewership" type="text" maxlength="160"></div>
              <div class="field"><label for="a-year-youtube">Year Founded</label><input id="a-year-youtube" name="year_founded" type="number" min="1900" max="2100"></div>
            </div>
          </div>

          <div class="account-mode-fields" data-account-mode-panel="cartoonist meme_page">
            <div class="form-grid form-grid--2">
              <div class="field"><label for="a-creative-portfolio">Portfolio / Page Link</label><input id="a-creative-portfolio" name="creative_portfolio" type="url" maxlength="240" placeholder="https://"></div>
              <div class="field"><label for="a-subscribers-creative">Number of subscribers</label><input id="a-subscribers-creative" name="subscribers" type="text" maxlength="160"></div>
              <div class="field"><label for="a-viewership-creative">Viewership reach in the past 6 months</label><input id="a-viewership-creative" name="viewership" type="text" maxlength="160"></div>
              <div class="field"><label for="a-year-creative">Year Founded</label><input id="a-year-creative" name="year_founded" type="number" min="1900" max="2100"></div>
            </div>
          </div>

          <div class="account-mode-fields" data-account-mode-panel="print_media">
            <div class="form-grid form-grid--2">
              <div class="field"><label for="a-print-link">Media Website Link</label><input id="a-print-link" name="platform_url" type="url" maxlength="240" placeholder="https://"></div>
              <div class="field"><label for="a-print-traffic">Web traffic of your website</label><input id="a-print-traffic" name="web_traffic" type="text" maxlength="160"></div>
              <div class="field"><label for="a-publications">Number of publications per month</label><input id="a-publications" name="publications_per_month" type="text" maxlength="160"></div>
              <div class="field"><label for="a-print-year">Year Founded</label><input id="a-print-year" name="year_founded" type="number" min="1900" max="2100"></div>
            </div>
          </div>

          <div class="account-mode-fields" data-account-mode-panel="knowledge_partner friend other">
            <div class="form-grid form-grid--2">
              <div class="field"><label for="a-occupation">Occupation</label><input id="a-occupation" name="occupation" type="text" maxlength="160"></div>
              <div class="field"><label for="a-year-other">Year Founded / Active Since</label><input id="a-year-other" name="year_founded" type="number" min="1900" max="2100"></div>
            </div>
          </div>

          <div class="form-grid form-grid--2 mt-4">
            <div class="field"><label for="a-instagram">Instagram URL & Followers</label><input id="a-instagram" name="instagram_url" type="url" maxlength="240" placeholder="https://instagram.com/..."></div>
            <div class="field"><label for="a-facebook">Facebook URL</label><input id="a-facebook" name="facebook_url" type="url" maxlength="240" placeholder="https://facebook.com/..."></div>
            <div class="field"><label for="a-twitter">X / Twitter URL</label><input id="a-twitter" name="twitter_url" type="url" maxlength="240" placeholder="https://x.com/..."></div>
            <div class="field"><label for="a-password">Password</label><input id="a-password" name="password" type="password" required minlength="10" autocomplete="new-password" data-password-meter></div>
            <div class="field"><label for="a-confirm">Confirm Password</label><input id="a-confirm" name="confirm_password" type="password" required minlength="10" autocomplete="new-password"></div>
          </div>
          <p class="account-password-hint" data-password-hint>Password must include lowercase, uppercase, a number, and minimum 10 characters.</p>

          <div class="field mt-4"><label for="a-about">Tell us about your work</label><textarea id="a-about" name="about" rows="6" required maxlength="2000" placeholder="Editorial focus, audience, notable work, partnership interest, or why you want to join SMaRT."></textarea></div>
          <button type="submit" class="btn btn--primary mt-4">Create Account Request <span class="arr" aria-hidden="true">→</span></button>
        </form>
      </div>

      <div class="account-panel <?= $activePanel === 'login' ? 'is-active' : '' ?>" data-account-panel="login" role="tabpanel">
        <div class="account-login-grid">
          <form method="post" class="account-login-box" novalidate>
            <input type="hidden" name="_csrf" value="<?= e(form_csrf_token()) ?>">
            <input type="hidden" name="action" value="login">
            <div class="field field--hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
            <h2>Login With OTP</h2>
            <p class="muted">Enter your registered email. The production portal will send a one-time password valid for a short window.</p>
            <div class="field mt-4"><label for="l-email">Registered Email</label><input id="l-email" name="login_email" type="email" required autocomplete="email"></div>
            <div class="field mt-4"><label for="l-otp">OTP</label><input id="l-otp" name="otp" type="text" inputmode="numeric" maxlength="6" placeholder="6-digit code"></div>
            <button type="submit" class="btn btn--navy mt-4">Request / Verify OTP <span class="arr" aria-hidden="true">→</span></button>
            <p class="account-inline-note">Didn’t receive it? Submit again to resend OTP.</p>
          </form>

          <form method="post" class="account-login-box" novalidate>
            <input type="hidden" name="_csrf" value="<?= e(form_csrf_token()) ?>">
            <input type="hidden" name="action" value="forgot">
            <div class="field field--hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
            <h2>Forgot Password</h2>
            <p class="muted">Request a reset link for the email attached to your member profile.</p>
            <div class="field mt-4"><label for="f-email">Recovery Email</label><input id="f-email" name="forgot_email" type="email" required autocomplete="email"></div>
            <button type="submit" class="btn btn--ghost mt-4">Send Recovery Link</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php partial('footer'); ?>
