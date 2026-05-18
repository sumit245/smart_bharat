<?php
require_once __DIR__ . '/../app/lib/render.php';
require_once app_path('partials/icons.php');
$pageKey = 'donate';
$extraJsonLd = function () {
    render_jsonld_breadcrumb([
        ['name' => 'Home', 'href' => '/'],
        ['name' => 'Donate', 'href' => '/donate'],
    ]);
};
partial('header', compact('pageKey', 'extraJsonLd'));
?>
<section class="page-head">
  <div class="container">
    <nav class="page-head__crumbs" aria-label="Breadcrumb"><a href="/">Home</a> / Support</nav>
    <h1>Support Our Cause</h1>
    <p>Fund nationalistic media independence. Every contribution helps train journalists, sustain regional portals, and expand reach.</p>
  </div>
</section>

<section class="section section--bg">
  <div class="container donate-grid">
    <div class="donate-card reveal">
      <h3>Pay via UPI</h3>
      <p class="muted">Scan the QR or pay to the UPI ID below. Any amount welcome.</p>
      <div class="donate-qr" aria-label="UPI QR placeholder">
        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <rect width="200" height="200" fill="#fff"/>
          <g fill="#0A1F44">
            <rect x="10" y="10" width="40" height="40"/><rect x="20" y="20" width="20" height="20" fill="#fff"/><rect x="25" y="25" width="10" height="10"/>
            <rect x="150" y="10" width="40" height="40"/><rect x="160" y="20" width="20" height="20" fill="#fff"/><rect x="165" y="25" width="10" height="10"/>
            <rect x="10" y="150" width="40" height="40"/><rect x="20" y="160" width="20" height="20" fill="#fff"/><rect x="25" y="165" width="10" height="10"/>
            <rect x="60" y="20" width="8" height="8"/><rect x="80" y="14" width="8" height="8"/><rect x="100" y="22" width="8" height="8"/><rect x="120" y="16" width="8" height="8"/>
            <rect x="18" y="60" width="8" height="8"/><rect x="34" y="74" width="8" height="8"/><rect x="48" y="68" width="8" height="8"/>
            <rect x="70" y="60" width="8" height="8"/><rect x="86" y="76" width="8" height="8"/><rect x="100" y="68" width="8" height="8"/><rect x="120" y="80" width="8" height="8"/><rect x="138" y="64" width="8" height="8"/>
            <rect x="62" y="90" width="8" height="8"/><rect x="84" y="100" width="8" height="8"/><rect x="106" y="92" width="8" height="8"/><rect x="124" y="108" width="8" height="8"/>
            <rect x="62" y="120" width="8" height="8"/><rect x="80" y="130" width="8" height="8"/><rect x="100" y="124" width="8" height="8"/><rect x="120" y="136" width="8" height="8"/><rect x="140" y="128" width="8" height="8"/>
            <rect x="62" y="150" width="8" height="8"/><rect x="86" y="160" width="8" height="8"/><rect x="106" y="152" width="8" height="8"/><rect x="124" y="166" width="8" height="8"/><rect x="146" y="158" width="8" height="8"/>
          </g>
        </svg>
      </div>
      <table class="donate-table">
        <tbody>
          <tr><th>UPI ID</th><td><code>smart4bharat@upi</code></td></tr>
          <tr><th>Name</th><td>SMaRT for Research and Training</td></tr>
        </tbody>
      </table>
      <p class="muted mt-4" style="font-size:0.85rem">Placeholder QR. Production QR will be issued post payment-gateway onboarding.</p>
    </div>

    <div class="donate-card reveal">
      <h3>Bank Transfer (NEFT / IMPS)</h3>
      <p class="muted">Domestic donors can transfer directly via NEFT, IMPS, or RTGS.</p>
      <table class="donate-table">
        <tbody>
          <tr><th>Account Name</th><td>Samachar Manyata Association for Research and Training</td></tr>
          <tr><th>Account Number</th><td>—</td></tr>
          <tr><th>IFSC Code</th><td>—</td></tr>
          <tr><th>Bank &amp; Branch</th><td>—</td></tr>
          <tr><th>PAN</th><td>—</td></tr>
        </tbody>
      </table>
      <p class="muted mt-4" style="font-size:0.85rem">Bank coordinates available on request. Email <a href="mailto:contact@smart4bharat.com">contact@smart4bharat.com</a> for partnership and CSR donations.</p>
      <a href="/contact" class="btn btn--navy btn--sm mt-4">Request Coordinates <span class="arr" aria-hidden="true">→</span></a>
    </div>
  </div>
</section>

<?php partial('footer'); ?>
