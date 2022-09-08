<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

return [

    /**
     * 默认配置
     */
    'default' => [
        /**
         * 接口请求相关配置，超时时间等，具体可用参数请参考：
         * https://github.com/symfony/symfony/blob/5.3/src/Symfony/Contracts/HttpClient/HttpClientInterface.php
         */
        'http' => [
            'timeout' => 5.0,
            // 'base_uri' => 'https://api.weixin.qq.com/', // 如果你在国外想要覆盖默认的 url 的时候才使用，根据不同的模块配置不同的 uri

            'retry' => true, // 使用默认重试配置
            //  'retry' => [
            //      // 仅以下状态码重试
            //      'http_codes' => [429, 500]
            //       // 最大重试次数
            //      'max_retries' => 3,
            //      // 请求间隔 (毫秒)
            //      'delay' => 1000,
            //      // 如果设置，每次重试的等待时间都会增加这个系数
            //      // (例如. 首次:1000ms; 第二次: 3 * 1000ms; etc.)
            //      'multiplier' => 3
            //  ],
        ],
    ],


    /**
     * 微信公众号
     */
    'official_account' => [

        'default' => [
            // AppID
            'app_id' => env('WECHAT_OFFICIAL_ACCOUNT_APPID', 'your-app-id'),
            // AppSecret
            'secret' => env('WECHAT_OFFICIAL_ACCOUNT_SECRET', 'your-app-secret'),
            // Token
            'token' => env('WECHAT_OFFICIAL_ACCOUNT_TOKEN', 'your-token'),
            // EncodingAESKey
            'aes_key' => env('WECHAT_OFFICIAL_ACCOUNT_AES_KEY', ''),


            /**
             * OAuth 配置
             *
             * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
             * callback：OAuth授权完成后的回调页地址
             */
            'oauth' => [
                'scopes' => ['snsapi_userinfo'],
                'callback' => '/examples/oauth_callback.php',
            ],
        ],


    ],

    /**
     * 第三方
     */
    'open_platform' => [
        'default' => [
            'app_id' => 'wx3cf0f39249eb0exx', // 开放平台账号的 appid
            'secret' => 'f1c242f4f28f735d4687abb469072axx',   // 开放平台账号的 secret
            'token' => 'easywechat',  // 开放平台账号的 token
            'aes_key' => ''   // 明文模式请勿填写 EncodingAESKey
        ],
    ],


    /**
     * 第三方
     */
    'mini_app' => [
        'default' => [
            'app_id' => 'wx3cf0f39249eb0exx',
            'secret' => 'f1c242f4f28f735d4687abb469072axx',
            'token' => 'easywechat',
            'aes_key' => '......'
        ],
    ],


    /**
     * 支付
     */
    'pay' => [
        'default' => [
            'mch_id' => 1360649000,

            // 商户证书
            'private_key' => __DIR__ . '/certs/apiclient_key.pem',
            'certificate' => __DIR__ . '/certs/apiclient_cert.pem',

            // v3 API 秘钥
            'secret_key' => '43A03299A3C3FED3D8CE7B820Fxxxxx',

            // v2 API 秘钥
            'v2_secret_key' => '26db3e15cfedb44abfbb5fe94fxxxxx',

            // 平台证书：微信支付 APIv3 平台证书，需要使用工具下载
            // 下载工具：https://github.com/wechatpay-apiv3/CertificateDownloader
            'platform_certs' => [
                // '/path/to/wechatpay/cert.pem',
            ],
        ],
    ],

    /**
     * 企业微信
     */
    'work' => [
        'default' => [
            'corp_id' => 'wx3cf0f39249eb0exx',
            'secret' => 'f1c242f4f28f735d4687abb469072axx',
            'token' => 'easywechat',
            'aes_key' => '35d4687abb469072a29f1c242xxxxxx',
        ],
    ],


    /**
     * 企业开放平台
     */
    'open_work' => [
        'default' => [
            'corp_id' => 'wx3cf0f39249eb0exx',
            'provider_secret' => 'f1c242f4f28f735d4687abb469072axx',
            'token' => 'easywechat',
            'aes_key' => '', // 明文模式请勿填写 EncodingAESKey
        ],
    ],
];
