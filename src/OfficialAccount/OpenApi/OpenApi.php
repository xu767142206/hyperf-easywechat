<?php


namespace Hyperf\Easywechat\OfficialAccount\OpenApi;

use EasyWeChat\Kernel\HttpClient\Response;
use Hyperf\Easywechat\Base\AbstractBaseApi;
use Hyperf\Easywechat\OfficialAccount\OfficialAccountApi;
use Symfony\Contracts\HttpClient\ResponseInterface as ResponseInterfaceAlias;

/**
 * Class OpenApi.
 *
 * @property-read
 * @method Response|ResponseInterfaceAlias  clearQuota() 清空api的调用quota
 * @method Response|ResponseInterfaceAlias  getQuota(string $path) 查询 openAPI 调用quota
 * @method Response|ResponseInterfaceAlias  getRid(string $rid) 本接口用于查询调用公众号/小程序/第三方平台等接口报错返回的 rid 详情信息，辅助开发者高效定位问题
 */
class OpenApi extends AbstractBaseApi
{

}