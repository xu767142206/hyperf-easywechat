<?php

namespace Hyperf\Easywechat\OfficialAccount\Menu;

use EasyWeChat\Kernel\HttpClient\Response;
use Symfony\Contracts\HttpClient\ResponseInterface as ResponseInterfaceAlias;

/**
 * Class Menu
 * @property-read
 * @method Response|ResponseInterfaceAlias  create(array $buttons, array $matchRule = []) 创建接口
 * @method Response|ResponseInterfaceAlias  all() 获取自定义菜单配置
 * @method Response|ResponseInterfaceAlias  current() 查询接口
 * @method Response|ResponseInterfaceAlias  destroy($menuId = null) 删除接口
 * @method Response|ResponseInterfaceAlias  test($userId) 测试个性菜单
 * @package Hyperf\Easywechat\OfficialAccount\Menu
 */
class Menu extends \Hyperf\Easywechat\Base\AbstractBaseApi
{

}