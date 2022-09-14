<?php


namespace Hyperf\Easywechat\OfficialAccount\Material;


use EasyWeChat\Kernel\Form\Form;
use EasyWeChat\Kernel\HttpClient\Response;
use Hyperf\Easywechat\Base\ActionBase;
use Symfony\Contracts\HttpClient\ResponseInterface as ResponseInterfaceAlias;
use Hyperf\Easywechat\OfficialAccount\Message\Article;
use EasyWeChat\Kernel\Form\File;

class Action extends ActionBase
{
    /**
     * Allow media type.
     *
     * @var array
     */
    protected $allowTypes = ['image', 'voice', 'video', 'thumb', 'news_image'];

    const API_GET = 'https://api.weixin.qq.com/cgi-bin/material/get_material';
    const API_UPLOAD = 'https://api.weixin.qq.com/cgi-bin/material/add_material';
    const API_DELETE = 'https://api.weixin.qq.com/cgi-bin/material/del_material';
    const API_STATS = 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount';
    const API_LISTS = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material';
    const API_NEWS_UPLOAD = 'https://api.weixin.qq.com/cgi-bin/material/add_news';
    const API_NEWS_UPDATE = 'https://api.weixin.qq.com/cgi-bin/material/update_news';
    const API_NEWS_IMAGE_UPLOAD = 'https://api.weixin.qq.com/cgi-bin/media/uploadimg';

    /**
     * uploadImage
     * @param $path
     * @return Response|ResponseInterfaceAlias
     * date:2022/9/14
     * time:17:25
     * auth：xyc
     */
    public function uploadImage($path): ResponseInterfaceAlias|Response
    {
        return $this->uploadMedia('image', $path);
    }

    /**
     * uploadVoice
     * @param $path
     * @return Response|ResponseInterfaceAlias
     * date:2022/9/14
     * time:17:25
     * auth：xyc
     */
    public function uploadVoice($path): ResponseInterfaceAlias|Response
    {
        return $this->uploadMedia('voice', $path);
    }


    /**
     * uploadThumb
     * @param $path
     * @return ResponseInterfaceAlias|Response
     * date:2022/9/14
     * time:17:25
     * auth：xyc
     */
    public function uploadThumb($path): ResponseInterfaceAlias|Response
    {
        return $this->uploadMedia('thumb', $path);
    }

    /**
     * uploadVideo
     * @param $path
     * @param $title
     * @param $description
     * @return ResponseInterfaceAlias|Response
     * date:2022/9/14
     * time:17:25
     * auth：xyc
     */
    public function uploadVideo($path, $title, $description): ResponseInterfaceAlias|Response
    {
        $params = [
            'description' => json_encode(
                [
                    'title' => $title,
                    'introduction' => $description,
                ], JSON_UNESCAPED_UNICODE),
        ];

        return $this->uploadMedia('video', $path, $params);
    }

    /**
     * uploadArticle
     * @param $articles
     * @return ResponseInterfaceAlias|Response
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * date:2022/9/14
     * time:17:25
     * auth：xyc
     */
    public function uploadArticle($articles): ResponseInterfaceAlias|Response
    {
        if (!empty($articles['title']) || $articles instanceof Article) {
            $articles = [$articles];
        }

        $params = ['articles' => array_map(function ($article) {
            if ($article instanceof Article) {
                return $article->only([
                    'title', 'thumb_media_id', 'author', 'digest',
                    'show_cover_pic', 'content', 'content_source_url',
                ]);
            }

            return $article;
        }, $articles)];

        return $this->getClient()->postJson(self::API_NEWS_UPLOAD, $params);
    }

    /**
     * updateArticle
     * @param $mediaId
     * @param $article
     * @param int $index
     * @return ResponseInterfaceAlias|Response
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * date:2022/9/14
     * time:17:25
     * auth：xyc
     */
    public function updateArticle($mediaId, $article, $index = 0): ResponseInterfaceAlias|Response
    {
        $params = [
            'media_id' => $mediaId,
            'index' => $index,
            'articles' => isset($article['title']) ? $article : (isset($article[$index]) ? $article[$index] : []),
        ];

        return $this->getClient()->postJson(self::API_NEWS_UPDATE, $params);
    }

    /**
     * uploadArticleImage
     * @param $path
     * @return ResponseInterfaceAlias|Response
     * date:2022/9/14
     * time:17:25
     * auth：xyc
     */
    public function uploadArticleImage($path): ResponseInterfaceAlias|Response
    {
        return $this->uploadMedia('news_image', $path);
    }


    /**
     * get
     * @param $mediaId
     * @return mixed|string
     * @throws \EasyWeChat\Kernel\Exceptions\BadResponseException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \HttpException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * date:2022/9/14
     * time:17:11
     * auth：xyc
     */
    public function get($mediaId): mixed
    {
        $response = $this->getClient()->postJson(self::API_GET, ['media_id' => $mediaId]);

        foreach ($response->getHeader('Content-Type') as $mime) {
            if (preg_match('/(image|video|audio)/i', $mime)) {
                return $response->getContent();
            }
        }

        $json = $response->toJson();

        // XXX: 微信开发这帮混蛋，尼玛文件二进制输出不带header，简直日了!!!
        if (!$json) {
            return $response->getContent();
        }

        $contents = json_decode($json, true);
        if (isset($contents['errcode']) && 0 !== $contents['errcode']) {
            if (empty($contents['errmsg'])) {
                $contents['errmsg'] = 'Unknown';
            }
            throw new \HttpException($contents['errmsg'], $contents['errcode']);
        }

        return $contents;
    }

    /**
     * delete
     * @param $mediaId
     * @return Response|ResponseInterfaceAlias
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * date:2022/9/14
     * time:17:25
     * auth：xyc
     */
    public function delete($mediaId): ResponseInterfaceAlias|Response
    {
        return $this->getClient()->postJson(self::API_DELETE, ['media_id' => $mediaId]);
    }

    /**
     * lists
     * @param $type
     * @param int $offset
     * @param int $count
     * @return ResponseInterfaceAlias|Response
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * date:2022/9/14
     * time:17:26
     * auth：xyc
     */
    public function lists($type, $offset = 0, $count = 20): ResponseInterfaceAlias|Response
    {
        $params = [
            'type' => $type,
            'offset' => intval($offset),
            'count' => min(20, $count),
        ];

        return $this->getClient()->postJson(self::API_LISTS, $params);
    }


    /**
     * stats
     * @return ResponseInterfaceAlias|Response
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * date:2022/9/14
     * time:17:26
     * auth：xyc
     */
    public function stats(): ResponseInterfaceAlias|Response
    {
        return $this->getClient()->get('get', [self::API_STATS]);
    }


    /**
     * uploadMedia
     * @param $type
     * @param $path
     * @param array $form
     * @return ResponseInterfaceAlias|Response
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * date:2022/9/14
     * time:17:26
     * auth：xyc
     */
    protected function uploadMedia($type, $path, array $form = []): ResponseInterfaceAlias|Response
    {
        if (!file_exists($path) || !is_readable($path)) {
            throw new \InvalidArgumentException("File does not exist, or the file is unreadable: '$path'");
        }
        return $this->getClient()->withFile($path, 'media')->post($this->getAPIByType($type), $form);
    }



    public function getAPIByType($type): string
    {
        switch ($type) {
            case 'news_image':
                $api = self::API_NEWS_IMAGE_UPLOAD;

                break;
            default:
                $api = self::API_UPLOAD."?type={$type}";
        }

        return $api;
    }
}