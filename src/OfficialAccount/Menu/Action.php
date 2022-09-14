<?php


namespace Hyperf\Easywechat\OfficialAccount\Menu;


use EasyWeChat\Kernel\HttpClient\Response;
use Hyperf\Easywechat\Base\ActionBase;
use Symfony\Contracts\HttpClient\ResponseInterface as ResponseInterfaceAlias;

class Action extends ActionBase
{
    const API_CREATE = 'https://api.weixin.qq.com/cgi-bin/menu/create';
    const API_GET = 'https://api.weixin.qq.com/cgi-bin/menu/get';
    const API_DELETE = 'https://api.weixin.qq.com/cgi-bin/menu/delete';
    const API_QUERY = 'https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info';
    const API_CONDITIONAL_CREATE = 'https://api.weixin.qq.com/cgi-bin/menu/addconditional';
    const API_CONDITIONAL_DELETE = 'https://api.weixin.qq.com/cgi-bin/menu/delconditional';
    const API_CONDITIONAL_TEST = 'https://api.weixin.qq.com/cgi-bin/menu/trymatch';

    /**
     * 创建
     * create
     * @param array $buttons
     * @param array $matchRule
     * @return Response|ResponseInterfaceAlias
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * date:2022/9/14
     * time:16:25
     * auth：xyc
     */
    public function create(array $buttons, array $matchRule = []): Response|ResponseInterfaceAlias
    {
        if (!empty($matchRule)) {
            return $this->getClient()->postJson(self::API_CONDITIONAL_CREATE, [
                'button' => $buttons,
                'matchrule' => $matchRule,
            ]);
        }

        return $this->getClient()->postJson(self::API_CREATE, ['button' => $buttons]);
    }


    /**
     * all
     * @return Response|ResponseInterfaceAlias
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * date:2022/9/14
     * time:16:30
     * auth：xyc
     */
    public function all():Response|ResponseInterfaceAlias
    {
        return $this->getClient()->get(self::API_GET);
    }


    /**
     * current
     * @return Response|ResponseInterfaceAlias
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * date:2022/9/14
     * time:16:31
     * auth：xyc
     */
    public function current():Response|ResponseInterfaceAlias
    {
        return $this->getClient()->get(self::API_QUERY);
    }


    /**
     * destroy
     * @param null $menuId
     * @return Response|ResponseInterfaceAlias
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * date:2022/9/14
     * time:16:31
     * auth：xyc
     */
    public function destroy($menuId = null):Response|ResponseInterfaceAlias
    {
        if (null !== $menuId) {
            return $this->getClient()->postJson(self::API_CONDITIONAL_DELETE, ['menuid' => $menuId]);
        }

        return $this->getClient()->postJson(self::API_DELETE);
    }

    /**
     * test
     * @param $userId
     * @return Response|ResponseInterfaceAlias
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * date:2022/9/14
     * time:16:31
     * auth：xyc
     */
    public function test($userId):Response|ResponseInterfaceAlias
    {
        return $this->getClient()->postJson(self::API_CONDITIONAL_TEST, ['user_id' => $userId]);
    }
}