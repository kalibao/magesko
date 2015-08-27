<?php
return [
    'components' => [
        'db' => [
            // configuration for the master
            'dsn' => 'mysql:host=localhost;dbname=kalibao',
            'username' => 'root',
            'password' => '',

            // common configuration for slaves
            'slaveConfig' => [
                'username' => 'root',
                'password' => '',
            ],

            // common configuration for slaves
            'slaveConfig' => [
                'username' => 'root',
                'password' => '',
            ],

            // list of slave configurations
            'slaves' => [
                // slave 1
                ['dsn' => 'mysql:host=localhost;dbname=kalibao'],
                // slave 2
                ['dsn' => 'mysql:host=localhost;dbname=kalibao'],
            ],
        ],
        'commonCache' => [
            'servers' => [
                [
                    'host' => 'localhost',
                    'port' => 11211,
                    'weight' => 100,
                ],
            ],
        ],
        'mailer' => [
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => '',
                'username' => '',
                'password' => '',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ]
    ]
];
