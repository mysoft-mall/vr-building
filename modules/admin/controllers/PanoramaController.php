<?php
/**
 *
 * Author: chenhongwei <chenhw@mysoft.com.cn>
 * Time: 2016/6/30 15:20
 */

namespace app\modules\admin\controllers;

use app\models\query\PanoramaQueryModel;
use app\services\PanoramaService;
use yii\web\Controller;
use Yii;

/**
 * 全景图
 * Class PanoramaController
 * @package app\modules\admin\controllers
 */
class PanoramaController extends Controller
{
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
        $model = new PanoramaQueryModel();
        $model->setAttributes(Yii::$app->request->get(), false);

        $data = PanoramaService::Instance()->getList($model);
        Yii::$app->response->successList($data, $model->getPagination());
    }
}