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
     * Renders the publish view for the module
     * @return string
     */
    public function actionPublish()
    {
        return $this->render('publish');
    }


    /**
     * Renders the material view for the module
     * @return string
     */
    public function actionMaterial()
    {
        return $this->render('material');
    }

    /**
     * Renders the panorama view for the module
     * @return string
     */
    public function actionPanorama()
    {
        return $this->render('panorama');
    }
}
