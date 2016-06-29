<?php
/**
 *
 * Author: chenhongwei <chenhw@mysoft.com.cn>
 * Time: 2016/6/29 12:46
 */

namespace app\services;

use Yii;
use app\components\Service;

/**
 * 全景服务
 * Class PanoService
 * @package app\services
 */
class PanoService extends Service
{
    public function getMaterialPath($id)
    {
        return Yii::getAlias('@runtime').'/pano/'.$id;
    }

    public function generateVTour($id)
    {
        $file = $this->getMaterialPath($id).'/vtour/index.html';
        if(is_file($file)){
            return true;
        }

        $command = 'php '.Yii::$app->basePath.'/yii pano/handle '.$id;
        exec($command);
        if(is_file($file)){
            return true;
        }

        return false;
    }

    public function publishVTour($id)
    {

    }

}