<?php

namespace Hyperf\Easywechat\OfficialAccount\Material;

use EasyWeChat\Kernel\HttpClient\Response;
use Symfony\Contracts\HttpClient\ResponseInterface as ResponseInterfaceAlias;

/**
 * Class Material
 *
 * @property-read
 * @method Response|ResponseInterfaceAlias  uploadImage($path) 上传图片
 * @method Response|ResponseInterfaceAlias  uploadVoice($path)
 * @method Response|ResponseInterfaceAlias  uploadThumb($path)
 * @method Response|ResponseInterfaceAlias  uploadVideo($path, $title, $description)
 * @method Response|ResponseInterfaceAlias  uploadArticle($articles)
 * @method Response|ResponseInterfaceAlias  updateArticle($mediaId, $article, $index = 0)
 * @method Response|ResponseInterfaceAlias  uploadArticleImage($path)
 * @method mixed  get($mediaId)
 * @method ResponseInterfaceAlias|Response  delete($mediaId)
 * @method ResponseInterfaceAlias|Response  lists($type, $offset = 0, $count = 20)
 * @method ResponseInterfaceAlias|Response  stats()
 *
 * @package Hyperf\Easywechat\OfficialAccount\Material
 */
class Material extends \Hyperf\Easywechat\Base\AbstractBaseApi
{

}