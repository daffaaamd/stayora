<?php

// Buat direktori sementara di /tmp yang dibutuhkan Laravel saat berjalan di Vercel
$storageDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/storage/app/public',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Inisialisasi database SQLite di /tmp jika ada database bawaan yang sudah di-seed
$sqliteSource = __DIR__ . '/../database/database.sqlite';
$sqliteDest = '/tmp/database.sqlite';
if (file_exists($sqliteSource) && !file_exists($sqliteDest)) {
    @copy($sqliteSource, $sqliteDest);
}

// Set environment variables penting untuk runtime serverless Vercel
putenv('VERCEL=1');
putenv('APP_STORAGE_PATH=/tmp/storage');
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_EVENTS_CACHE=/tmp/events.php');
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
putenv('APP_ROUTES_CACHE=/tmp/routes.php');
putenv('APP_SERVICES_CACHE=/tmp/services.php');

// Jika DB_CONNECTION belum di-set ke database eksternal di Vercel Environment Variables, gunakan SQLite lokal yang sudah di-seed
$dbConn = getenv('DB_CONNECTION') ?: ($_ENV['DB_CONNECTION'] ?? null);
if (empty($dbConn) || $dbConn === 'sqlite') {
    putenv('DB_CONNECTION=sqlite');
    putenv('DB_DATABASE=' . $sqliteDest);
    $_ENV['DB_CONNECTION'] = 'sqlite';
    $_ENV['DB_DATABASE'] = $sqliteDest;
}

// Forward request ke entrypoint Laravel public/index.php
require __DIR__ . '/../public/index.php';
