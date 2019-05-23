<?php

return [
    'default'     => 'default_connection',

    /**
     * used connections in projects
     */
    'connections' => [
        'default_connection' => [
            'host'                => 'localhost',
            'port'                => 5672,
            'username'            => 'guest',
            'password'            => 'guest',
            'vhost'               => '/',
            'ssl_context_options' => null,
            'connection_timeout'  => 3.0,
            'read_write_timeout'  => 3.0,
            'keepalive'           => false,
            'heartbeat'           => 0,
            'exchange'            => 'amq.direct',
            'consumer_tag'        => 'consumer',
            'exchange_type'       => 'direct',
            'content_type'        => 'text/plain',
        ],
        'other_connection' => [
            'host'                => 'localhost',
            'port'                => 5672,
            'username'            => 'guest',
            'password'            => 'guest',
            'vhost'               => '/',
            'ssl_context_options' => null,
            'connection_timeout'  => 3.0,
            'read_write_timeout'  => 3.0,
            'keepalive'           => false,
            'heartbeat'           => 0,
            'exchange'            => 'amq.direct',
            'consumer_tag'        => 'consumer',
            'exchange_type'       => 'direct',
            'content_type'        => 'text/plain',
        ]
    ],

    /**
     * all queue to be used
     * any collection keys set by connection_name.exchange_name.queue_name
     */
    'mq_keys'     => [
        'test_key' => 'default_connection.exchange_name.queue_name',
        'test_other_key' => 'other_connection.exchange_name.queue_name'
    ]
];