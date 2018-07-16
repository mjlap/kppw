<?php

return [

    // The default gateway to use
    'default' => 'alipay',

    // Add in each gateway here
    'gateways' => [
        'paypal' => [
            'driver' => 'PayPal_Express',
            'options' => [
                'solutionType' => '',
                'landingPage' => '',
                'headerImageUrl' => ''
            ]
        ],
        'alipay' => [
            'driver' => 'Alipay_Express',
            'options' => [
                'partner' => '2088301857503158',
                'key' => 'wzn723ysa5qotelr2jcau4b7edb1livt',
                'sellerEmail' => 'pay@kekezu.com',
                'returnUrl' => '',
                'notifyUrl' => ''
            ]
        ],
        'unionpay' => [
            'driver' => 'UnionPay_Express',
            'options' => [
                'merId' => '777290058130430',
                'certPath' => storage_path('app') . '/unionpay/certs/acp_test_sign.pfx',
                'certPassword' => '000000',
                'certDir' => storage_path('app') . '/unionpay/certs',
                'returnUrl' => '',
                'notifyUrl' => ''
            ]
        ],
        'wechat' => [
            'driver' => 'WeChat_Express',
            'options' => [
                'appId' => 'wx6e023b7a4ee45709',
                'appKey' => 'yb1JrmlcZY31qOnBk2bBZiOBnwl37eBn',
                'mchId' => '1271185801'
            ]
        ],
        'WechatPay' => [
            'driver' => 'WechatPay_App',
            'options' => [
                'appId' => 'wxab43f78a83a5dd98',
                'apiKey' => 'zgdcVXdP3AO57zEUJCKA7JtfKFX3KF29',
                'mchId' => '1380675202'
            ]
        ]
    ]

];