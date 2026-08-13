<?php

// Pastikan direktori sementara (/tmp) yang dibutuhkan Laravel dibuat saat fungsi serverless berjalan
$requiredDirs = [
    '/tmp/views',
    '/tmp/cache',
    '/tmp/sessions',
];

foreach ($requiredDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Forward request ke entrypoint Laravel public/index.php
require __DIR__ . '/../public/index.php';
