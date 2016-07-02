<?php
/**
 *
 * Author: chenhongwei <chenhw@mysoft.com.cn>
 * Time: 2016/6/29 12:46
 */

namespace app\services;

use app\models\Material;
use app\models\Panorama;
use app\models\query\MaterialQueryModel;
use Yii;
use app\components\Service;
use yii\helpers\FileHelper;
use Gregwar\Image\Image;
use yii\web\UploadedFile;

/**
 * 素材服务
 * Class MaterialService
 * @package app\services
 */
class MaterialService extends Service
{
    public function getMaterialPath()
    {
        return Yii::getAlias('@app/upload/material');
    }

    /**
     * 获取缩略图路径
     * @return bool|string
     */
    public function getThumbPath()
    {
        return Yii::getAlias('@app/web/thumb');
    }

    public function getPublishPath()
    {
        return Yii::getAlias('@webroot/pano');
    }
    
    /**
     * 获取一个临时目录
     * @return string|bool
     * @throws \yii\base\Exception
     */
    public function getTempDir()
    {
        $tp = Yii::getAlias('@runtime/temp');
        $dir = $tp . DIRECTORY_SEPARATOR . md5(microtime() . mt_rand(0, 999999));
        $res = FileHelper::createDirectory($dir);
        if ($res) {
            return $dir;
        } else {
            throw new \Exception('生成临时目录失败');
        }
    }

    /**
     * 生成临时文件
     * @param array $hashes
     * @return bool
     * @throws \Exception
     */
    public function copyTempFiles(array $hashes)
    {
        $mp = $this->getMaterialPath();
        $td = '';
        $res = false;
        foreach ($hashes as $hash) {
            $file = $mp . "/$hash.jpg";
            if (is_file($file)) {
                if ($td == '') {
                    $td = $this->getTempDir();
                }
                copy($file, $td . "/$hash.jpg");
                $res = $td;
            }
        }

        return $res;
    }

    /**
     * 生成全景图
     * @param array $hashes
     * @return bool
     */
    public function generate(array $hashes, $title)
    {
        $res = false;
        //todo 检验全景是否已存在

        ksort($hashes);
        $panoHash = substr(md5(implode(',', $hashes)), 0, 8);

        if($td = $this->copyTempFiles($hashes)){
            $targetFile = $td . '/vtour/index.html';

            $command = 'php ' . Yii::$app->basePath . '/yii pano/handle ' . "'$td/*.jpg'";
            Yii::error($command);
            exec($command);
            if (is_file($targetFile)) {
                //移动到发布目录
                FileHelper::copyDirectory($td.'/vtour', $this->getPublishPath().'/'.$panoHash);

                //记录数据
                $pano = new Panorama();
                $pano->title = $title;
                $pano->hash = $panoHash;
                $pano->thumb_url = '/thumb/'.$hashes[0].'.jpg';
                $pano->created_on = date('Y-m-d H:i:s');
                $res = $pano->save();
            }
            //移除临时目录
            FileHelper::removeDirectory($td);
        }

        return $res;
    }

    /**
     * 获取素材列表
     * @param MaterialQueryModel $model
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getList(MaterialQueryModel $model)
    {
        return Material::getList($model);
    }

    /**
     * 删除素材
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        return Material::deleteAll('id=:id', [':id'=>$id]) > 0;
    }
    
    public function upload()
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
            
            return $hash;
        }
    }
}