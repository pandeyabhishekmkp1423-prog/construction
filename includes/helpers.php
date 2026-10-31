<?php
/**
 * Helper Functions & Utilities - Pavaki Infra
 *
 * Provides context-appropriate escaping, clean URL generation,
 * CSRF protection, secure sessions, flash messaging, and input sanitization.
 */

declare(strict_types=1);

if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}

/**
 * Retrieve configuration data (cached).
 * Supports dot notation: site_config('business.name')
 */
function site_config(?string $key = null, mixed $default = null): mixed
{
    static $config = null;
    if ($config === null) {
        $configFile = __DIR__ . '/../config/config.php';
        if (!file_exists($configFile)) {
            return $default;
        }
        $config = require $configFile;
    }

    if ($key === null) {
        return $config;
    }

    $segments = explode('.', $key);
    $current = $config;
    foreach ($segments as $segment) {
        if (!is_array($current) || !array_key_exists($segment, $current)) {
            return $default;
        }
        $current = $current[$segment];
    }
    return $current;
}

/**
 * Context-appropriate HTML escaping.
 */
function e(?string $value): string
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Check if a value is present, non-empty, and verified.
 * Returns false if null, empty string, or contains legacy placeholder text.
 */
function has_value(?string $value): bool
{
    if ($value === null || $value === '') {
        return false;
    }
    if (str_starts_with($value, '[PLACEHOLDER:') || str_contains($value, '[PLACEHOLDER:')) {
        return false;
    }
    return true;
}

/**
 * Check if a value is an unconfirmed placeholder (backwards compatibility).
 */
function is_placeholder(?string $value): bool
{
    return !has_value($value);
}

/**
 * Cleanly render a text value.
 * If value is empty or unverified, returns empty string or fallback so no
 * placeholder or development tags are ever published on public pages.
 */
function render_text(?string $value, string $fallback = ''): string
{
    if (!has_value($value)) {
        return e($fallback);
    }
    return e($value);
}

/**
 * Resolve the base web path for asset and page links.
 */
function get_base_path(): string
{
    static $basePath = null;
    if ($basePath !== null) {
        return $basePath;
    }

    $customBase = site_config('base_url', 'auto');
    if ($customBase !== 'auto' && !empty($customBase)) {
        $basePath = rtrim($customBase, '/');
        return $basePath;
    }

    // Compare document root with project root to prevent proxy directory subfolder errors
    $docRoot = isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : false;
    $projectRoot = realpath(__DIR__ . '/..');

    if ($docRoot && $projectRoot) {
        $docRoot = str_replace('\\', '/', $docRoot);
        $projectRoot = str_replace('\\', '/', $projectRoot);

        if (rtrim($docRoot, '/') === rtrim($projectRoot, '/')) {
            $basePath = '';
            return $basePath;
        }

        if (str_starts_with($projectRoot, $docRoot)) {
            $rel = substr($projectRoot, strlen($docRoot));
            $basePath = '/' . trim(str_replace('\\', '/', $rel), '/');
            $basePath = ($basePath === '/') ? '' : $basePath;
            return $basePath;
        }
    }

    $scriptDir = dirname($_SERVER['SCRIPT_NAME'] ?? '');
    $scriptDir = str_replace('\\', '/', $scriptDir);
    $basePath = ($scriptDir === '/' || $scriptDir === '.') ? '' : rtrim($scriptDir, '/');

    // Never prefix asset or route URLs with /api in serverless function environments
    if ($basePath === '/api') {
        $basePath = '';
    }

    return $basePath;
}

/**
 * Generate a site URL.
 * Supports clean URLs when clean_urls setting is enabled.
 */
function url(string $path = ''): string
{
    $cleanUrls = (bool)site_config('clean_urls', false);
    $basePath = get_base_path();

    if ($path === '' || $path === '/' || $path === 'home') {
        return $basePath === '' ? '/' : $basePath . '/';
    }

    $trimmed = ltrim($path, '/');

    // Separate fragment anchor (#...) and query string (?...)
    $anchor = '';
    $query = '';

    if (str_contains($trimmed, '#')) {
        [$trimmed, $anchorPart] = explode('#', $trimmed, 2);
        $anchor = '#' . $anchorPart;
    }
    if (str_contains($trimmed, '?')) {
        [$trimmed, $queryPart] = explode('?', $trimmed, 2);
        $query = '?' . $queryPart;
    }

    if ($cleanUrls) {
        $cleanPath = preg_replace('/\.php$/i', '', $trimmed);
        if ($cleanPath === 'index' || $cleanPath === 'home' || $cleanPath === '') {
            return ($basePath === '' ? '/' : $basePath . '/') . $query . $anchor;
        }
        return ($basePath === '' ? '' : $basePath) . '/' . $cleanPath . $query . $anchor;
    }

    if (!str_contains($trimmed, '.') && $trimmed !== '') {
        $trimmed .= '.php';
    }

    return ($basePath === '' ? '' : $basePath) . '/' . $trimmed . $query . $anchor;
}

/**
 * Generate an asset URL with automatic timestamp cache-busting.
 */
function asset(string $path): string
{
    $basePath = get_base_path();
    $cleanPath = ltrim($path, '/');
    $fullPath = __DIR__ . '/../' . $cleanPath;

    $version = '';
    if (file_exists($fullPath)) {
        $version = '?v=' . filemtime($fullPath);
    }

    return ($basePath === '' ? '' : $basePath) . '/' . $cleanPath . $version;
}

/**
 * Safe session initialization with hardened cookie parameters.
 * Does not start sessions on pages where session is not needed.
 */
function start_session_safe(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    if (headers_sent()) {
        return;
    }

    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443)
        || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => get_base_path() ?: '/',
        'domain'   => '',
        'secure'   => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    session_start();
}

/**
 * Generate or retrieve CSRF token.
 */
function csrf_token(): string
{
    start_session_safe();
    if (empty($_SESSION['_csrf_token']) || !is_string($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf_token'];
}

/**
 * Verify CSRF token using constant-time comparison.
 */
function verify_csrf_token(?string $token): bool
{
    start_session_safe();
    if (empty($token) || empty($_SESSION['_csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['_csrf_token'], $token);
}

/**
 * Regenerate CSRF token (after successful form submit).
 */
function regenerate_csrf_token(): string
{
    start_session_safe();
    $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    return $_SESSION['_csrf_token'];
}

/**
 * Set or get session flash messages.
 */
function flash(string $key, mixed $value = null): mixed
{
    start_session_safe();
    if ($value !== null) {
        $_SESSION['_flash'][$key] = $value;
        return null;
    }

    if (isset($_SESSION['_flash'][$key])) {
        $message = $_SESSION['_flash'][$key];
        unset($_SESSION['_flash'][$key]);
        return $message;
    }

    return null;
}

/**
 * Check if a flash message exists.
 */
function has_flash(string $key): bool
{
    start_session_safe();
    return isset($_SESSION['_flash'][$key]);
}

/**
 * Strip header injection characters, control characters, and trim.
 */
function sanitize_header_value(string $value): string
{
    $cleaned = str_replace(["\r", "\n", "%0a", "%0d", "\0"], '', $value);
    return trim($cleaned);
}

/**
 * Sanitize single-line text input.
 */
function sanitize_text(string $value, int $maxLength = 250): string
{
    $cleaned = sanitize_header_value($value);
    if (mb_strlen($cleaned, 'UTF-8') > $maxLength) {
        $cleaned = mb_substr($cleaned, 0, $maxLength, 'UTF-8');
    }
    return $cleaned;
}

/**
 * Sanitize multi-line textarea input.
 */
function sanitize_textarea(string $value, int $maxLength = 3000): string
{
    $cleaned = str_replace(["\r\n", "\r"], "\n", $value);
    $cleaned = str_replace("\0", '', $cleaned);
    if (mb_strlen($cleaned, 'UTF-8') > $maxLength) {
        $cleaned = mb_substr($cleaned, 0, $maxLength, 'UTF-8');
    }
    return trim($cleaned);
}

/**
 * Return client IP address safely considering proxies.
 */
function get_client_ip(): string
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    if (filter_var($ip, FILTER_VALIDATE_IP)) {
        return $ip;
    }
    return '127.0.0.1';
}

/**
 * Detect whether the application is running in a Vercel serverless environment.
 */
function is_vercel(): bool
{
    return !empty($_ENV['VERCEL'])
        || !empty($_SERVER['VERCEL'])
        || getenv('VERCEL') === '1'
        || !empty($_ENV['NOW_REGION'])
        || !empty($_SERVER['NOW_REGION']);
}

/**
 * Resolve a writable storage path for logs, rate limits, and submissions.
 * On traditional servers (Apache, Hostinger, Local), uses root /storage.
 * On Vercel / serverless read-only environments, falls back to /tmp/pavaki_storage.
 */
function get_writable_storage_path(string $filename): string
{
    $cleanFilename = basename($filename);
    $defaultDir = dirname(__DIR__) . '/storage';

    // If running in Vercel or default storage directory is not writable, fallback to /tmp
    if (is_vercel() || !is_dir($defaultDir) || !is_writable($defaultDir)) {
        $tmpDir = sys_get_temp_dir() . '/pavaki_storage';
        if (!is_dir($tmpDir)) {
            @mkdir($tmpDir, 0777, true);
        }
        return $tmpDir . '/' . $cleanFilename;
    }

    return $defaultDir . '/' . $cleanFilename;
}

/**
 * Automatically redirect any direct GET access to *.php files to clean URLs
 * (e.g. http://localhost:8000/services.php -> http://localhost:8000/services).
 */
function enforce_clean_urls(): void
{
    if (!site_config('clean_urls', false)) {
        return;
    }

    if (PHP_SAPI === 'cli' || headers_sent()) {
        return;
    }

    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    if ($method !== 'GET' && $method !== 'HEAD') {
        return;
    }

    $requestUri = $_SERVER['REQUEST_URI'] ?? '';
    if ($requestUri === '') {
        return;
    }

    $parsed = parse_url($requestUri);
    $path = $parsed['path'] ?? '';

    // Only redirect if .php is explicitly in the requested URI path
    if (preg_match('#^(.+)\.php$#i', $path, $matches)) {
        $cleanPath = $matches[1];
        if (basename($cleanPath) === 'index') {
            $cleanPath = dirname($cleanPath);
            $cleanPath = ($cleanPath === '/' || $cleanPath === '\\') ? '/' : rtrim($cleanPath, '/') . '/';
        }
        $query = !empty($parsed['query']) ? '?' . $parsed['query'] : '';
        $redirectUrl = $cleanPath . $query;

        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $redirectUrl);
        exit;
    }
}

// Auto-enforce clean URLs on HTTP requests
enforce_clean_urls();

