<?php
/**
 *
 * Author: chenhongwei <chenhw@mysoft.com.cn>
 * Time: 2016/6/30 12:47
 */

namespace app\models;

use app\models\query\PanoramaQueryModel;

class Panorama extends \app\models\base\Panorama
{
    public static function getList(PanoramaQueryModel $queryModel)
    {
        $p = $queryModel->getPagination();
        $query = self::find()
            ->offset($p->getOffset())
            ->limit($queryModel->getPagination()->getLimit());
        $p->setTotal($query->count());

        return $query->all();
    }

    public function fields()
    {
        return array_merge(parent::fields(), [
            'thumb_url' => function(){
                return \Yii::$app->request->getHostInfo().\Yii::$app->request->getBaseUrl().$this->thumb_url;
            },
            'panorama_url' => function(){
                return \Yii::$app->request->getHostInfo().\Yii::$app->request->getBaseUrl().'/pano/'.$this->hash.'/';
            }
        ]);
    }
}