<?php


namespace Hyperf\Easywechat;

use EasyWeChat\OfficialAccount\Application as OfficialAccount;
use EasyWeChat\Work\Application as Work;
use EasyWeChat\MiniApp\Application as MiniApp;
use EasyWeChat\Pay\Application as Pay;
use EasyWeChat\OpenPlatform\Application as OpenPlatform;
use EasyWeChat\OpenWork\Application as OpenWork;
use Hyperf\Easywechat\OfficialAccount\Menu\Menu;
use Hyperf\Easywechat\OfficialAccount\OfficialAccountApi;
use Hyperf\Easywechat\OfficialAccount\OpenApi\OpenApi;
use Hyperf\Utils\ApplicationContext;

/**
 * Class Api
 * @property-read OpenApi openApi
 * @property-read Menu menu 自定义菜单（兼容个性化菜单）
 * @package Hyperf\Easywechat
 */
class Api
{
    private OfficialAccount|Work|MiniApp|Pay|OpenPlatform|OpenWork $application;

    /**
     * Api constructor.
     * @param OfficialAccount|Work|MiniApp|Pay|OpenPlatform|OpenWork $application
     */
    public function __construct(OfficialAccount|Work|MiniApp|Pay|OpenPlatform|OpenWork $application)
    {
        $this->application = $application;
    }

    /**
     * __get
     * @param string $name
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * date:2022/9/8
     * time:16:51
     * auth：xyc
     */
    public function __get(string $name)
    {
        if ($this->application instanceof OfficialAccount) {
            $api = ApplicationContext::getContainer()->get(OfficialAccountApi::class);
        }
        $name = ucfirst($name);
        return $api->$name($this);

        // TODO: Implement __get() method.
    }


    /**
     * @return MiniApp|OfficialAccount|OpenPlatform|OpenWork|Pay|Work
     */
    public function getApplication(): MiniApp|Pay|Work|OpenWork|OpenPlatform|OfficialAccount
    {
        return $this->application;
    }


}