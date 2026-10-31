<?php
/**
 * Built-in PHP Development Server Router
 * Usage: php -S localhost:8000 router.php
 *
 * Handles:
 * 1. Static asset direct serving (CSS, JS, images, SVG, WebP, fonts, etc.)
 * 2. Automatic 301 redirection from legacy *.php URLs to extensionless clean URLs
 * 3. Extensionless page routing (e.g. /services -> services.php)
 * 4. Preservation of query parameters and safe 404 fallback
 */

declare(strict_types=1);

$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$parsed = parse_url($requestUri);
$path = urldecode($parsed['path'] ?? '/');

// 1. Static files: return false to let the PHP built-in server handle them natively
$filePath = __DIR__ . $path;
if ($path !== '/' && file_exists($filePath) && !is_dir($filePath)) {
    return false;
}

// 2. Canonical 301 Redirect: if client requests a URL ending in .php, redirect to clean URL
if (preg_match('#^/(.+)\.php$#i', $path, $matches)) {
    $cleanSlug = $matches[1];
    $cleanPath = ($cleanSlug === 'index') ? '/' : '/' . $cleanSlug;
    $query = !empty($parsed['query']) ? '?' . $parsed['query'] : '';
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $cleanPath . $query);
    exit;
}

// 3. Root request -> index.php
if ($path === '/' || $path === '') {
    require __DIR__ . '/index.php';
    exit;
}

// 4. Extensionless routes: match /services -> services.php, /about -> about.php, etc.
$trimmed = trim($path, '/');
$targetPhp = __DIR__ . '/' . $trimmed . '.php';

if (file_exists($targetPhp) && is_file($targetPhp)) {
    $_SERVER['SCRIPT_FILENAME'] = $targetPhp;
    $_SERVER['SCRIPT_NAME']     = '/' . $trimmed . '.php';
    $_SERVER['PHP_SELF']        = '/' . $trimmed . '.php';
    require $targetPhp;
    exit;
}

// 5. Subdirectory with index.php (e.g. /services/index.php if proxy folders are accessed)
$targetDirIndex = __DIR__ . '/' . $trimmed . '/index.php';
if (file_exists($targetDirIndex) && is_file($targetDirIndex)) {
    require $targetDirIndex;
    exit;
}

// 6. Not found -> 404.php
http_response_code(404);
if (file_exists(__DIR__ . '/404.php')) {
    require __DIR__ . '/404.php';
} else {
    echo '404 Not Found';
}
exit;

