<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class ManageController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('publish');
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionMater()
    {
        return $this->render('publish');
    }
}
