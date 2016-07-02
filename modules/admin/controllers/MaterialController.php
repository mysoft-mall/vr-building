<?php
namespace app\modules\admin\controllers;

use app\models\query\MaterialQueryModel;
use app\services\MaterialService;
use yii\web\Controller;
use yii;

/**
 * 全景素材
 * Class MaterialController
 * @package app\modules\admin\controllers
 */
class MaterialController extends Controller
{
    /**
     * 上传全景素材
     *
     * 请求方法：POST
     *
     * 请求参数：
     * pano 素材文件
     */
    public function actionUpload()
    {
        $hash = MaterialService::Instance()->upload();

        if ($hash) {
            Yii::$app->response->success(['hs' => $hash]);
        }

        Yii::$app->response->error('文件保存失败');
    }

    /**
     * 生成全景
     *
     * 请求方法：GET
     *
     * 请求参数：
     * hashes 素材hash数组
     * title 全景标题
     *
     */
    public function actionGenerate()
    {
        set_time_limit(40);
        ignore_user_abort(true);
        $hashes = Yii::$app->request->post('hashes');
        $title = Yii::$app->request->post('title');
        if (empty($hashes)) {
            Yii::$app->response->error('无效的素材');
        }

        $res = MaterialService::Instance()->generate($hashes, $title);

        if (!$res) {
            Yii::$app->response->error('生成失败');
        }
        Yii::$app->response->success();
    }

    /**
     * 获取素材列表
     *
     * 请求方法：GET
     *
     * 请求参数：
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

    /**
     * 删除素材
     *
     * 请求方法：POST
     *
     * 请求参数
     * id 素材ID
     *
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        $res = MaterialService::Instance()->delete($id);
        if ($res) {
            Yii::$app->response->success('删除成功');
        } else {
            Yii::$app->response->error('删除失败');
        }

    }

}