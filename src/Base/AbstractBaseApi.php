<?php


namespace Hyperf\Easywechat\Base;


use Hyperf\Easywechat\Api;

abstract class AbstractBaseApi
{

    /**
     * @var Api
     */
    private Api $api;


    /**
     * AbstractBaseApi constructor.
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }


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
        $nameSpace = substr(static::class, 0, strrpos(static::class, "\\")) . "\\Action";
        return (new $nameSpace($this->api))->$name(...$arguments);
    }

}