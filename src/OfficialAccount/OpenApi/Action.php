<?php


namespace Hyperf\Easywechat\OfficialAccount\OpenApi;


use EasyWeChat\Kernel\HttpClient\Response;
use Hyperf\Easywechat\Base\ActionBase;
use Symfony\Contracts\HttpClient\ResponseInte;
use Symfony\Contracts\HttpClient\ResponseInterface as ResponseInterfaceAlias;

class Action extends ActionBase
{
    /**
     * 清理接口
     * clearQuota
     * @return Response|ResponseInterfaceAlias
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * date:2022/9/14
     * time:13:41
     * auth：xyc
     */
    public function clearQuota(): Response|ResponseInterfaceAlias
    {
        return $this->getClient()->postJson('cgi-bin/clear_quota', [
            "appid" => $this->api->getApplication()->getAccount()->getAppId(),
        ]);
    }


    /**
     * getQuota
     * @param string $path
     * @return Response|ResponseInterfaceAlias
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * date:2022/9/14
     * time:14:49
     * auth：xyc
     */
    public function getQuota(string $path): Response|ResponseInterfaceAlias
    {
        return $this->getClient()->postJson('cgi-bin/openapi/quota/get', [
            "cgi_path" => $path,
        ]);
    }

    /**
     * getRid
     * 本接口用于查询调用公众号/小程序/第三方平台等接口报错返回的 rid 详情信息，辅助开发者高效定位问题
     * @param string $rid
     * @return Response|ResponseInterfaceAlias
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * date:2022/9/14
     * time:14:54
     * auth：xyc
     */
    public function getRid(string $rid): Response|ResponseInterfaceAlias
    {
        return $this->getClient()->postJson('cgi-bin/openapi/rid/get', [
            "rid" => $rid,
        ]);
    }
}