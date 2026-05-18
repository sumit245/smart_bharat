<?php
declare(strict_types=1);

function app_root(): string { return dirname(__DIR__, 2); }
function app_path(string $rel): string { return app_root() . '/app/' . ltrim($rel, '/'); }

function load_data(string $name): array {
    $file = app_path("data/{$name}.json");
    if (!is_file($file)) return [];
    $json = json_decode((string)file_get_contents($file), true);
    return is_array($json) ? $json : [];
}

function config(string $name): array {
    static $cache = [];
    if (!isset($cache[$name])) {
        $cache[$name] = require app_path("config/{$name}.php");
    }
    return $cache[$name];
}

function partial(string $name, array $vars = []): void {
    extract($vars, EXTR_SKIP);
    $file = app_path("partials/{$name}.php");
    if (is_file($file)) include $file;
}

function e(?string $s): string {
    return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function asset(string $path, bool $version = true): string {
    $clean = '/' . ltrim($path, '/');
    if (!$version) return $clean;
    $abs = app_root() . '/public' . $clean;
    $v = is_file($abs) ? (string)filemtime($abs) : '1';
    return $clean . '?v=' . $v;
}

function current_path(): string {
    $p = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
    return rtrim($p, '/') ?: '/';
}

function is_active(string $href): bool {
    $cur = current_path();
    return $href === '/' ? $cur === '/' : str_starts_with($cur, rtrim($href, '/'));
}
