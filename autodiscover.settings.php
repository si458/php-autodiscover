<?php
$settings = [
    'debugtofile' => true,
    'imap' => [
        'enabled' => true,
        'server' => 'imap.example.com',
        'port' => 143,
        'domainrequired' => false,
        'spa' => false,
        'ssl' => false,
        'authrequired' => true
    ],
    'smtp' => [
        'enabled' => true,
        'server' => 'smtp.example.com',
        'port' => 25,
        'domainrequired' => false,
        'spa' => false,
        'ssl' => false,
        'authrequired' => true,
        'usepopauth' => false,
        'smtplast' => false,
    ],
    'pop' => [
        'enabled' => false,
        'server' => 'pop.example.com',
        'port' => 110,
        'domainrequired' => false,
        'spa' => false,
        'ssl' => false,
        'authrequired' => true
    ],
    'activesync' => [
        'enabled' => true,
        'server' => 'mail.example.com',
        'ssl' => true,
    ]
];