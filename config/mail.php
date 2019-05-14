<?php

return [

    'driver' => 'smtp',

    'host'          => 'smtp.gmail.com',

    'port'          => 587,

    'from'          => [
            'address'   => 'stoynev75@gmail.com',
            'name'      => 'ExamIT',
    ],

    'encryption'    => 'tls',

    'username'      => 'stoynev75@gmail.com',

    'password'      => 'llabtxxdroqlnjtl',

    'sendmail'      => '/usr/sbin/sendmail -bs',

    'markdown'      => [
            'theme'     => 'default',
            'paths'     => [
                resource_path('views/vendor/mail'),
            ],
        ],
];
