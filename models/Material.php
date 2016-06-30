<?php
/**
 *
 * Author: chenhongwei <chenhw@mysoft.com.cn>
 * Time: 2016/6/30 12:47
 */

namespace app\models;


use app\models\query\MaterialQueryModel;

class Material extends \app\models\base\Material
{
    public static function getList(MaterialQueryModel $queryModel)
    {
        $p = $queryModel->getPagination();
        $query = self::find()
            ->orderBy(['created_on' => SORT_DESC])
            ->offset($p->getOffset())
            ->limit($queryModel->getPagination()->getLimit());
        $p->setTotal($query->count());

        return $query->all();
    }

    public function fields()
    {
        return array_merge(parent::fields(), [
            'thumb_url' => function () {
                return \Yii::$app->request->getHostInfo() . \Yii::$app->request->getBaseUrl() . $this->thumb_url;
            }
        ]);
    }

}