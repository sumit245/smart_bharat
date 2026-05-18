<?php
/**
 * Inline icon helper. Usage: icon('users', ['class' => 'card__icon__svg']).
 */
function icon(string $name, array $attrs = []): void {
    $attrs = array_merge(['width' => '24', 'height' => '24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '1.8', 'stroke-linecap' => 'round', 'stroke-linejoin' => 'round', 'viewBox' => '0 0 24 24', 'aria-hidden' => 'true'], $attrs);
    $attr_str = '';
    foreach ($attrs as $k => $v) { $attr_str .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars((string)$v) . '"'; }
    $paths = [
        'users' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'antenna' => '<path d="M5 12a7 7 0 0 1 14 0"/><path d="M8.5 12a3.5 3.5 0 0 1 7 0"/><circle cx="12" cy="12" r="1.2" fill="currentColor"/><path d="M12 13.5V22"/><path d="M9 22h6"/>',
        'rupee' => '<path d="M7 5h10"/><path d="M7 9h10"/><path d="M14 9a4 4 0 0 1-4 4H7l7 6"/>',
        'book' => '<path d="M4 19V5a2 2 0 0 1 2-2h12v16H6a2 2 0 0 0-2 2z"/><path d="M6 17h12"/>',
        'megaphone' => '<path d="M3 11v2a2 2 0 0 0 2 2h2l9 5V4L7 9H5a2 2 0 0 0-2 2z"/><path d="M19 8a4 4 0 0 1 0 8"/>',
        'lock' => '<rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/>',
        'list' => '<line x1="9" y1="6" x2="20" y2="6"/><line x1="9" y1="12" x2="20" y2="12"/><line x1="9" y1="18" x2="20" y2="18"/><circle cx="5" cy="6" r="1.2"/><circle cx="5" cy="12" r="1.2"/><circle cx="5" cy="18" r="1.2"/>',
        'chart' => '<line x1="4" y1="20" x2="20" y2="20"/><rect x="6" y="12" width="3" height="8"/><rect x="11" y="8" width="3" height="12"/><rect x="16" y="4" width="3" height="16"/>',
        'mobile' => '<rect x="7" y="3" width="10" height="18" rx="2"/><line x1="12" y1="17" x2="12.01" y2="17"/>',
        'launch' => '<path d="M5 21l14-9-14-9v18z"/>',
        'growth' => '<polyline points="3 17 9 11 13 15 21 7"/><polyline points="14 7 21 7 21 14"/>',
        'globe' => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3a14 14 0 0 1 0 18a14 14 0 0 1 0-18z"/>',
        'amplify' => '<path d="M3 11v2a2 2 0 0 0 2 2h2l9 5V4L7 9H5a2 2 0 0 0-2 2z"/>',
        'mail' => '<rect x="3" y="5" width="18" height="14" rx="2"/><polyline points="3 7 12 13 21 7"/>',
        'phone' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>',
        'pin' => '<path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>',
        'twitter' => '<path d="M22 5.92a8.4 8.4 0 0 1-2.36.64 4.1 4.1 0 0 0 1.8-2.26 8.2 8.2 0 0 1-2.6 1 4.1 4.1 0 0 0-7 3.74 11.65 11.65 0 0 1-8.45-4.28 4.1 4.1 0 0 0 1.27 5.47 4.1 4.1 0 0 1-1.86-.51v.05a4.1 4.1 0 0 0 3.29 4.02 4.1 4.1 0 0 1-1.85.07 4.1 4.1 0 0 0 3.83 2.85A8.23 8.23 0 0 1 2 18.4a11.62 11.62 0 0 0 6.29 1.84c7.55 0 11.68-6.25 11.68-11.68v-.53A8.3 8.3 0 0 0 22 5.92z"/>',
        'facebook' => '<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>',
        'youtube' => '<rect x="2" y="5" width="20" height="14" rx="3"/><polygon points="10 9 16 12 10 15 10 9" fill="currentColor"/>',
        'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor"/>',
        'arrow-right' => '<line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>',
        'check' => '<polyline points="4 12 10 18 20 6"/>',
        'close' => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
    ];
    $p = $paths[$name] ?? '';
    echo "<svg{$attr_str}>{$p}</svg>";
}
