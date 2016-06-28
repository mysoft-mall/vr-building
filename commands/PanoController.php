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
    public function actionHandle($id)
    {
        $krpanoPath = \Yii::$app->basePath . '/bin/krpano/krpanotools';
        $panoPath = \Yii::getAlias('@runtime') . '/pano/'.$id;
        $pictures = $panoPath .'/*.jpg';
        $vtourPath = $panoPath.'/vtour';
        $html = $panoPath.'/vtour/index.html';
        $command = $krpanoPath . ' makepano -config=templates/vtour-multires.config '.$pictures;
        echo $command;
        exec($command, $result);
        if(is_file($html)){
            $destPath = \Yii::$app->basePath.'/web/pano/'.$id;
            FileHelper::copyDirectory($vtourPath, $destPath);
        }
    }
}