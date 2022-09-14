<?php


namespace Hyperf\Easywechat\Base;


use EasyWeChat\Kernel\HttpClient\AccessTokenAwareClient;
use Hyperf\Easywechat\Api;

/**
 * Class ActionBase
 * @package Hyperf\Easywechat\Base
 */
class ActionBase
{
    protected Api $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * @return Api
     */
    public function getApi(): Api
    {
        return $this->api;
    }

    /**'
     * getClinet
     * @return AccessTokenAwareClient
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * date:2022/9/14
     * time:13:40
     * auth：xyc
     */
    public function getClient(): AccessTokenAwareClient
    {
        return $this->api->getApplication()->getClient();
    }

    /**
     * getToken
     * @return \EasyWeChat\Kernel\Contracts\AccessToken|\EasyWeChat\Kernel\Contracts\RefreshableAccessToken
     * date:2022/9/8
     * time:17:15
     * auth：xyc
     */
    public function getToken(): \EasyWeChat\Kernel\Contracts\AccessToken|\EasyWeChat\Kernel\Contracts\RefreshableAccessToken
    {
        return $this->api->getApplication()->getAccessToken();
    }
}