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

namespace Hyperf\Easywechat;

use EasyWeChat\MiniApp\Application;
use GuzzleHttp\HandlerStack;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Guzzle\CoroutineHandler;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\ApplicationContext;
use Psr\Container\ContainerInterface;
use Psr\SimpleCache\CacheInterface;
use Hyperf\Guzzle\HandlerStackFactory;
use GuzzleHttp\Client;

/**
 * Class Factory.
 *
 * @method \EasyWeChat\OfficialAccount\Application  officialAccount(string $name = "default", array $config = [])
 * @method \EasyWeChat\Work\Application  work(string $name = "default", array $config = [])
 * @method \EasyWeChat\MiniApp\Application  miniProgram(string $name = "default", array $config = [])
 * @method \EasyWeChat\Pay\Application  payment(string $name = "default", array $config = [])
 * @method \EasyWeChat\OpenPlatform\Application  openPlatform(string $name = "default", array $config = [])
 * @method \EasyWeChat\OpenWork\Application  openWork(string $name = "default", array $config = [])
 */
class Factory
{
    /**
     * @var array|string[]
     */
    protected array $configMap
        = [
            'officialAccount' => 'official_account',
            'work' => 'work',
            'miniProgram' => 'mini_app',
            'payment' => 'pay',
            'openPlatform' => 'open_platform',
            'openWork' => 'open_work',
        ];

    /**
     * @var array|string[]
     */
    protected array $classMap
        = [
            'officialAccount' => \EasyWeChat\OfficialAccount\Application::class,
            'work' => \EasyWeChat\Work\Application::class,
            'miniProgram' => \EasyWeChat\MiniApp\Application::class,
            'payment' => \EasyWeChat\Pay\Application::class,
            'openPlatform' => \EasyWeChat\OpenPlatform\Application::class,
            'openWork' => \EasyWeChat\OpenWork\Application::class,
        ];


    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * @var ConfigInterface
     */
    protected ConfigInterface $config;


    public function __construct()
    {
        $this->container = ApplicationContext::getContainer();
        $this->config = $this->container->get(ConfigInterface::class);
    }

    /**
     * __call
     * @param $functionName
     * @param $args
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * date:2022/9/7
     * time:16:44
     * auth：xyc
     */
    public function __call(string $functionName, array $args):
    \EasyWeChat\OfficialAccount\Application|\EasyWeChat\Work\Application|\EasyWeChat\MiniApp\Application|\EasyWeChat\Pay\Application|\EasyWeChat\OpenPlatform\Application|\EasyWeChat\OpenWork\Application
    {
        //验证方法
        if (!isset($this->configMap[$functionName])) {
            throw new \Exception('not found function ' . $functionName);
        }
        //action-conf
        $configName = $this->configMap[$functionName];

        [$accountName, $accountConfig] = $args;

        //配置
        $defaultConfig = $this->config->get(sprintf('wechat.%s.%s', $configName, $accountName ?? "default"), []);
        $config = array_merge($defaultConfig, $this->config->get("wechat.default", []), $accountConfig ?? []);

        //实例化
        $app = new $this->classMap[$functionName]($config);

        /** 是我不配  不折腾了 http客户端需要重写 Symfony\Contracts\HttpClient  反正有hook*/
//        //http客户端
//        $config = $app->getConfig()->get('http', []);
//        $config['handler'] = HandlerStack::create(new CoroutineHandler());
//        $config['config']['handler'] = make(HandlerStackFactory::class)->create();
//        $app->guzzle_handler = $this->container->get(HandlerStackFactory::class)->create();
//        $app->setHttpClient(make(Client::class, $config));

        // region 替换请求 +++++
        $app->setRequest($this->container->get(RequestInterface::class));

        // region 替换缓存 +++++
        $app->setCache($this->container->get(CacheInterface::class));

        return $app;
    }


}
