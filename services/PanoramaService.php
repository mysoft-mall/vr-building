<?php
/**
 *
 * Author: chenhongwei <chenhw@mysoft.com.cn>
 * Time: 2016/6/30 15:25
 */

namespace app\services;

use app\components\Service;
use app\models\Panorama;
use app\models\query\PanoramaQueryModel;

/**
 * 全景服务
 * Class PanoramaService
 * @package app\services
 */
class PanoramaService extends Service
{
    /**
     * 获取全景列表
     * @param PanoramaQueryModel $queryModel
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getList(PanoramaQueryModel $queryModel)
    {
        return Panorama::getList($queryModel);
    }
}