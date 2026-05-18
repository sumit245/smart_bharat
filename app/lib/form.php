<?php
declare(strict_types=1);

require_once __DIR__ . '/render.php';

function form_input(string $key, $default = ''): string {
    $v = $_POST[$key] ?? $default;
    if (!is_string($v)) $v = '';
    $v = trim($v);
    return mb_substr($v, 0, 2000);
}

function form_valid_email(string $email): bool {
    return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
}

function form_session_start(): void {
    if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
        session_start();
    }
}

function form_csrf_token(): string {
    form_session_start();
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

function form_csrf_check(): bool {
    form_session_start();
    $sent = $_POST['_csrf'] ?? '';
    $stored = $_SESSION['_csrf'] ?? '';
    return is_string($sent) && $sent !== '' && $stored !== '' && hash_equals($stored, $sent);
}

function form_store_row(string $name, array $row): bool {
    $dir = app_path('data');
    if (!is_dir($dir)) mkdir($dir, 0775, true);
    $file = $dir . "/{$name}.csv";
    $isNew = !is_file($file);
    $fh = fopen($file, 'ab');
    if (!$fh) return false;
    if ($isNew) {
        fputcsv($fh, array_merge(['timestamp', 'ip'], array_keys($row)), ',', '"', '\\', "\n");
    }
    fputcsv($fh, array_merge([
        date('c'),
        $_SERVER['REMOTE_ADDR'] ?? '',
    ], array_values($row)), ',', '"', '\\', "\n");
    fclose($fh);
    return true;
}

function form_honeypot_ok(): bool {
    return ($_POST['website'] ?? '') === '';
}
