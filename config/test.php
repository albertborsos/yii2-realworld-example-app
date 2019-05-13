<?php
$common = require __DIR__ . '/web.php';

/**
 * Application configuration shared by all test types
 */
return \yii\helpers\ArrayHelper::merge($common, [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'db' => [
            'dsn' => getenv('DB_TEST_DSN'),
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
    ],
]);
