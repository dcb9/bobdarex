<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=bobdarex',
            'username' => 'idarex',
            'password' => '2ddj*kklN',
            'charset' => 'utf8',
        ],
        'view'=>[
            'renderers'=> [
                'twig'=>[
                    'class'=>'yii\twig\ViewRenderer',
                    'cachePath'=>'@runtime/Twig/cache',
                    'options'=>[
                        'auto_reload'=>true,
                    ]
                ]
            ]
        ]
    ],
];