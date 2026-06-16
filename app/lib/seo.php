<?php
declare(strict_types=1);

require_once __DIR__ . '/render.php';

function seo_for(string $key): array {
    $seo = config('seo');
    $site = config('site');
    $page = $seo['pages'][$key] ?? [];
    return array_merge($seo['default'], $page, ['site' => $site['name'], 'url' => $site['url']]);
}

function request_origin(): string {
    $site = config('site');
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if (!is_string($host) || $host === '') return $site['url'];
    $proto = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? null;
    if (!is_string($proto) || $proto === '') {
        $proto = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    }
    $proto = strtolower(explode(',', $proto)[0]);
    if ($proto !== 'http' && $proto !== 'https') $proto = 'https';
    return $proto . '://' . $host;
}

function render_head(string $pageKey, array $extra = []): void {
    $s = seo_for($pageKey);
    $origin = request_origin();
    $site = config('site');
    $canonical = $origin . current_path();
    $title = $s['title'];
    $desc = $s['description'];
    $img = $origin . ($s['image'] ?? '/assets/img/og-default.jpg');
    $imgWidth = (string)($s['image_width'] ?? 1200);
    $imgHeight = (string)($s['image_height'] ?? 630);
    $imgType = (string)($s['image_type'] ?? 'image/jpeg');
    ?>
    <title><?= e($title) ?></title>
    <meta name="description" content="<?= e($desc) ?>">
    <?php if (!empty($s['keywords'])): ?>
    <meta name="keywords" content="<?= e($s['keywords']) ?>">
    <?php endif; ?>
    <link rel="canonical" href="<?= e($canonical) ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= e($site['name']) ?>">
    <meta property="og:title" content="<?= e($title) ?>">
    <meta property="og:description" content="<?= e($desc) ?>">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <meta property="og:image" content="<?= e($img) ?>">
    <meta property="og:image:secure_url" content="<?= e($img) ?>">
    <meta property="og:image:type" content="<?= e($imgType) ?>">
    <meta property="og:image:width" content="<?= e($imgWidth) ?>">
    <meta property="og:image:height" content="<?= e($imgHeight) ?>">
    <meta property="og:locale" content="en_IN">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@SMaRT4Bharat">
    <meta name="twitter:title" content="<?= e($title) ?>">
    <meta name="twitter:description" content="<?= e($desc) ?>">
    <meta name="twitter:image" content="<?= e($img) ?>">
    <meta name="theme-color" content="#0A1F44">
    <?php
}

function render_jsonld_organization(): void {
    $site = config('site');
    $data = [
        '@context' => 'https://schema.org',
        '@type' => ['Organization', 'NGO'],
        '@id' => $site['url'] . '#organization',
        'name' => $site['full_name'],
        'alternateName' => $site['name'],
        'url' => $site['url'],
        'logo' => $site['url'] . '/assets/img/logo.png',
        'description' => 'Force multiplier coalition for nationalistic Bharatiya media.',
        'foundingDate' => $site['founded'],
        'email' => $site['email'],
        'telephone' => $site['phone'],
        'areaServed' => ['@type' => 'Country', 'name' => 'India'],
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $site['address'],
            'addressCountry' => 'IN',
        ],
        'sameAs' => array_values(array_filter($site['social'], fn($u) => $u !== '#')),
    ];
    echo '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}

function render_jsonld_website(): void {
    $site = config('site');
    $data = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        '@id' => $site['url'] . '#website',
        'url' => $site['url'],
        'name' => $site['name'],
        'publisher' => ['@id' => $site['url'] . '#organization'],
        'inLanguage' => 'en-IN',
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => $site['url'] . '/search?q={search_term_string}',
            'query-input' => 'required name=search_term_string',
        ],
    ];
    echo '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_SLASHES) . '</script>';
}

function render_jsonld_faq(array $qa): void {
    $items = [];
    foreach ($qa as $row) {
        $items[] = [
            '@type' => 'Question',
            'name' => $row['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $row['a']],
        ];
    }
    $data = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $items,
    ];
    echo '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
}

function render_jsonld_breadcrumb(array $crumbs): void {
    $site = config('site');
    $items = [];
    foreach ($crumbs as $i => $c) {
        $items[] = [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $c['name'],
            'item' => $site['url'] . $c['href'],
        ];
    }
    $data = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $items,
    ];
    echo '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_SLASHES) . '</script>';
}
