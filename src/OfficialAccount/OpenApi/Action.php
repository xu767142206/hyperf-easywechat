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
}