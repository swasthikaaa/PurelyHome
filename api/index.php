<?php

// Ensure a writable directory for Laravel's cache/storage
$tmpDir = '/tmp/laravel-cache';
$subDirs = ['/config', '/routes', '/services', '/packages', '/views', '/sessions', '/cache'];

foreach ($subDirs as $dir) {
    if (!is_dir($tmpDir . $dir)) {
        @mkdir($tmpDir . $dir, 0755, true);
    }
}

// Redirect all cache files and storage to /tmp
$envs = [
    'APP_CONFIG_CACHE' => "{$tmpDir}/config/config.php",
    'APP_ROUTES_CACHE' => "{$tmpDir}/routes/routes.php",
    'APP_SERVICES_CACHE' => "{$tmpDir}/services/services.php",
    'APP_PACKAGES_CACHE' => "{$tmpDir}/packages/packages.php",
    'VIEW_COMPILED_PATH' => "{$tmpDir}/views",
    'SESSION_STORAGE_PATH' => "{$tmpDir}/sessions",
    'CACHE_STORAGE_PATH' => "{$tmpDir}/cache",
];

foreach ($envs as $key => $value) {
    putenv("{$key}={$value}");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}

// Forward Vercel requests to normal index.php
require __DIR__ . '/../public/index.php';