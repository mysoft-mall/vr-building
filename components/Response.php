<?php
namespace app\components;

class Response extends \yii\web\Response
{
    public function success($data=null)
    {
        $this->format = Response::FORMAT_JSON;
        $res = ['result' => true, 'data' => $data];
        $this->data = $res;
        \Yii::$app->end();
    }

    public function successList($data=null, \app\components\Pagination $p=null)
    {
        $this->format = Response::FORMAT_JSON;
        $res = ['result' => true, 'items' => $data];
        if(!is_null($p)){
            $res['total'] = $p->getTotal();
        }
        $this->data = $res;
        \Yii::$app->end();
    }

    public function error($message='', $code = 500)
    {
        $this->format = Response::FORMAT_JSON;
        $this->data = ['result' => false, 'code' => $code, 'msg' => $message];
        \Yii::$app->end();
    }
}