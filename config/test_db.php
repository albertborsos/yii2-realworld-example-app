<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
$db['dsn'] = getenv('DB_TEST_DSN');
$db['username'] = getenv('DB_USER');
$db['password'] = getenv('DB_PASS');

return $db;
