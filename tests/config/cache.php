<?php
return [
    'type' => 'cache',
    'config' => [
        [
            'name' => 'cache6',
            'driver' => 'redis',
            'host' => 'localhost',
            'port' => 6379,
            'database' => 2,
            'ttl' => 9685
        ],
        [
            'name' => 'i18n',
            'driver' => 'redis',
            'host' => 'localhost',
            'port' => 6379,
            'database' => 12,
            'ttl' => 9685
        ],
        [
            'name' => 'cache4',
            'driver' => 'memcached',
            'host' => 'localhost',
            'port' => 11211
        ],
        [
            'name' => 'array',
            'driver' => 'array'
        ]
    ]
];
