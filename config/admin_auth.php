<?php
$envPassword = getenv('ADMIN_PASSWORD');
$hostName = strtolower((string)($_SERVER['HTTP_HOST'] ?? ''));
$isLocal = $hostName === 'localhost' || str_starts_with($hostName, 'localhost:') || str_ends_with($hostName, '.test');
if (is_string($envPassword) && strlen($envPassword) >= 16) { define('ADMIN_PASSWORD', $envPassword); }
elseif ($isLocal) { define('ADMIN_PASSWORD', 'h4f1dz'); }
else { define('ADMIN_PASSWORD', null); }