<?php

return [
    'components' => [
        'db' => [
            'class' => yii\db\Connection::class,
            'dsn' => 'mysql:host=' . (getenv('DB_HOST') ?: 'yii2-db') .
                ';port=' . (getenv('DB_PORT') ?: '3306') .
                ';dbname=' . (getenv('DB_DATABASE') ?: 'yii2advanced'),
            'username' => getenv('DB_USERNAME') ?: 'root',
            'password' => getenv('DB_PASSWORD') ?: '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
        ],
    ],
];
