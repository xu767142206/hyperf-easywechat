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

use Hyperf\Utils\ApplicationContext;

/**
 * Class EasyWechat.
 *
 * @method static \EasyWeChat\OfficialAccount\Application  officialAccount(string $name = "default", array $config = [])
 * @method static \EasyWeChat\Work\Application  work(string $name = "default", array $config = [])
 * @method static \EasyWeChat\MiniApp\Application  miniProgram(string $name = "default", array $config = [])
 * @method static \EasyWeChat\Pay\Application  payment(string $name = "default", array $config = [])
 * @method static \EasyWeChat\OpenPlatform\Application  openPlatform(string $name = "default", array $config = [])
 * @method static \EasyWeChat\OpenWork\Application  openWork(string $name = "default", array $config = [])
 */
class EasyWechat
{
    public static function __callStatic(string $functionName, array $args):
    \EasyWeChat\OfficialAccount\Application|\EasyWeChat\Work\Application|\EasyWeChat\MiniApp\Application|\EasyWeChat\Pay\Application|\EasyWeChat\OpenPlatform\Application|\EasyWeChat\OpenWork\Application
    {
        return ApplicationContext::getContainer()->get(Factory::class)->{$functionName}(...$args);
    }
}
