<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$config = $app->make('config')->get('database.connections.sqlite.database');
echo json_encode(['sqlite_database' => $config], JSON_PRETTY_PRINT);
