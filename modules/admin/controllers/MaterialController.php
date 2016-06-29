<?php
namespace app\modules\admin\controllers;

use app\services\PanoService;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\UploadedFile;
use Yii;

/**
 * 全景素材
 * Class MaterialController
 * @package app\modules\admin\controllers
 */
class MaterialController extends Controller
{
    public function actionList()
    {
        
    }

    /**
     * 上传全景图片
     */
    public function actionUpload()
    {
        $file = UploadedFile::getInstanceByName('pano');
        if(!$file){
            Yii::$app->response->error('获取文件失败');
        }

        $id = substr(md5_file($file->tempName), 8, 8);
        $path = PanoService::Instance()->getMaterialPath($id);
        FileHelper::createDirectory($path);
        $name = $path.'/'.$file->name;
        if($file->saveAs($name)) {
            Yii::$app->response->success(['id'=>$id]);
        }
        Yii::$app->response->error('文件保存失败');
    }

    /**
     * 生成全景
     * @param $id
     */
    public function actionGenerate($id)
    {
        set_time_limit(1200);
        ignore_user_abort(true);
        $res = PanoService::Instance()->generateVTour($id);

        if(!$res){
            Yii::$app->response->error('生成失败');
        }
        Yii::$app->response->success();
    }
    
}