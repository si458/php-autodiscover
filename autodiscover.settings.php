<?php
$settings = array(
    'debugtofile' => true,
    'imap' => array(
        'enabled' => true,
        'server' => 'imap.example.com',
        'port' => 143,
        'domainrequired' => false,
        'spa' => false,
        'ssl' => false,
        'authrequired' => true
    ),
    'smtp' => array(
        'enabled' => true,
        'server' => 'smtp.example.com',
        'port' => 25,
        'domainrequired' => false,
        'spa' => false,
        'ssl' => false,
        'authrequired' => true,
        'usepopauth' => false,
        'smtplast' => false,
    ),
    'pop' => array(
        'enabled' => false,
        'server' => 'pop.example.com',
        'port' => 110,
        'domainrequired' => false,
        'spa' => false,
        'ssl' => false,
        'authrequired' => true
    ),
    'activesync' => array(
        'enabled' => true,
        'server' => 'mail.example.com',
        'ssl' => true,
    )
);