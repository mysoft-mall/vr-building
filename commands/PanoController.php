<?php
/**
 *
 * Author: chenhongwei <chenhw@mysoft.com.cn>
 * Time: 2016/6/28 16:25
 */

namespace app\commands;

use yii\console\Controller;
use yii\helpers\FileHelper;

/**
 * 全景处理脚本
 * Class PanoController
 * @package app\commands
 */
class PanoController extends Controller
{
    public function actionHandle($inputImg)
    {
        $krpanoPath = \Yii::$app->basePath . '/bin/krpano/krpanotools';
        $command = $krpanoPath . ' makepano -config=templates/vtour-multires.config '.$inputImg;
        exec($command, $result);
    }
}