<?php
namespace app\modules\admin\controllers;

use app\models\Material;
use app\models\query\MaterialQueryModel;
use app\services\MaterialService;
use Gregwar\Image\Image;
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
    /**
     * 上传全景图片
     */
    public function actionUpload()
    {
        $file = UploadedFile::getInstanceByName('pano');
        if(!$file){
            Yii::$app->response->error('获取文件失败');
        }
        $tempImg = Image::open($file->tempName);
        if($file->size>0 && $tempImg->width()/$tempImg->height()!=2){
            Yii::$app->response->error('支持2:1的图片');
        }
        unset($tempImg);

        $hash = substr(md5_file($file->tempName), 8, 8);
        $path = MaterialService::Instance()->getMaterialPath();
        FileHelper::createDirectory($path);
        $name = $path.'/'.$hash.'.'.$file->getExtension();
        if($file->saveAs($name)) {
            $thumbFile = MaterialService::Instance()->getThumbPath()."/{$hash}.jpg";
            if(!is_file($thumbFile)){
                $img = Image::open($name);
                $img->zoomCrop(200, 200)->save($thumbFile);
            }

            $material = new Material();
            $material->hash = $hash;
            $material->file_name = $file->name;
            $material->thumb_url = "/thumb/{$hash}.jpg";
            $material->created_on = date('Y-m-d H:i:s');
            $material->save();

            Yii::$app->response->success(['hs'=>$hash]);
        }
        Yii::$app->response->error('文件保存失败');
    }

    /**
     * 生成全景
     * @param $hashes
     */
    public function actionGenerate($hashes)
    {
        set_time_limit(40);
        ignore_user_abort(true);
        
        if(empty($hashes) || empty($hashes=array_filter(explode(',', $hashes)))){
            Yii::$app->response->error('无效的素材');
        }
        
        $res = MaterialService::Instance()->generate($hashes);

        if(!$res){
            Yii::$app->response->error('生成失败');
        }
        Yii::$app->response->success();
    }

    /**
     * 获取素材列表
     *
     * 请求方法：GET
     *
     * 请求参数
     * page 页码
     * pageSize 每页数量
     *
     */
    public function actionList()
    {
        $model = new MaterialQueryModel();
        $model->setAttributes(Yii::$app->request->get(), false);

        $data = MaterialService::Instance()->getList($model);
        Yii::$app->response->successList($data, $model->getPagination());
    }
    
}