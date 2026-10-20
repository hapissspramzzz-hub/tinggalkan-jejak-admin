<?php
$envPassword = getenv('ADMIN_PASSWORD');
if (is_string($envPassword) && strlen($envPassword) >= 16) { define('ADMIN_PASSWORD', $envPassword); }
else { define('ADMIN_PASSWORD', null); }