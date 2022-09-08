# hyperf-wechat

微信 SDK for Hyperf， 基于 w7corp/easywechat

## 安装

暂时未发布至composer 只供本地 {"repositories": [{"type": "path","url": "路径"}]使用

~~~shell script
composer require xu767142206/hyperf-easywechat
~~~

## 配置

1. 发布配置文件

~~~shell script
php ./bin/hyperf.php vendor:publish xu767142206/hyperf-easywechat
~~~

2. 修改应用根目录下的 `config/autoload/wechat.php` 中对应的参数即可。
3. 每个模块基本都支持多账号，默认为 `default`。

## 使用

下面以接收普通消息为例写一个例子：
> 假设您的域名为 `nxx.cloud` 那么请登录微信公众平台 “开发者中心” 修改 “URL（服务器配置）” 为： `http://nxx.cloud/wechat`。

路由：

```php
Router::addRoute(['GET', 'POST', 'HEAD'], '/wechat', 'App\Controller\WeChatController@serve');
```

> 注意：一定是 `Router::addRoute`, 因为微信服务端认证的时候是 `GET`, 接收用户消息时是 `POST` ！

然后创建控制器 `WeChatController`：

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use EasyWeChat\Kernel\Exceptions\BadRequestException;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use Hyperf\Easywechat\EasyWechat;
use ReflectionException;
use Hyperf\Easywechat\Middleware\ServeMiddleware;
use Hyperf\HttpServer\Annotation\Middleware;

class WeChatController extends AbstractController
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     * @throws BadRequestException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws ReflectionException
     */
    #[Middleware(ServeMiddleware::class)]
    public function serve()
    {

        $app = EasyWechat::officialAccount();
        $app->server->push(function ($message) {
            return "欢迎关注 EasyWechat！";
        });
       
        return $app->server->serve();
    }
}
```

> 上面例子里的需要时使用 `[Middleware(ServeMiddleware::class)]`，否则会报错。

### 我们有以下方式获取 SDK 的服务实例

##### 使用外观

```php
  use Hyperf\Easywechat\EasyWechat;
  $officialAccount = EasyWechat::officialAccount(); // 公众号
  $work = EasyWechat::work(); // 企业微信
  $payment = EasyWechat::payment(); // 微信支付
  $openPlatform = EasyWechat::openPlatform(); // 开放平台
  $miniProgram = EasyWechat::miniProgram(); // 小程序
  
  // 均支持传入配置账号名称以及配置
  EasyWeChat::officialAccount('foo',[]); // `foo` 为配置文件中的名称，默认为 `default`。`[]` 可覆盖账号配置
  //...
```

更多 SDK 的具体使用请参考：https://easywechat.com

## License

MIT

