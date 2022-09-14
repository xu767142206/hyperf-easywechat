<?php


namespace Hyperf\Easywechat\Base;


use Hyperf\Easywechat\Api;

trait ApiTrait
{
    /**
     * __call
     * @param string $name
     * @param array $arguments
     * @return mixed
     * date:2022/9/8
     * time:17:32
     * auth：xyc
     */
    public function __call(string $name, array $arguments)
    {
        $nameSpace = static::NAMESPACE . "{$name}\\" . $name;
        return new $nameSpace(...$arguments);
    }

}