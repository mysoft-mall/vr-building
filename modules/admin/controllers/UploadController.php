<?php
namespace app\modules\admin\controllers;

use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\UploadedFile;
use Yii;

/**
 * 上传接口
 * Class UploadController
 * @package app\modules\admin\controllers
 */
class UploadController extends Controller
{
    /**
     * 上传全景图片
     */
    public function actionPano()
    {
        $file = UploadedFile::getInstanceByName('pano');
        if(!$file){
            Yii::$app->response->error('获取文件失败');
        }

        $id = substr(md5_file($file->tempName), 8, 8);
        $path = Yii::getAlias('@runtime').'/pano/'.$id;
        FileHelper::createDirectory($path);
        $name = $path.'/'.$file->name;
        if($file->saveAs($name)) {
            //todo 触发处理全景脚本
            exec(Yii::$app->basePath.'/yii pano/handle '.$id.' &');
            Yii::$app->response->success();
        }
        Yii::$app->response->error('文件处理失败');
    }
}