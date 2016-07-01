<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function actionTest()
    {
        $uploadUrl = Yii::$app->urlManager->createUrl('admin/material/upload');
        echo '<html>
<body>

<form action="'.$uploadUrl.'" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="pano" id="file" />
<br />
<input type="submit" name="submit" value="Submit" />
</form>

</body>
</html>';
    }

    public function actionPano($id)
    {
        echo '<iframe src="'.Yii::$app->urlManager->getHostInfo().'/pano/'.$id.'" height="100%" width="100%" ></iframe>';
    }

    /**
     * 微信分享配置
     * @param string $url
     */
    public function actionWxConfig($url='')
    {
        echo \weixin\widgets\ShareConfigWidget::widget(['account'=>Yii::$app->weixin->getAccount(),'debug'=>true, 'url'=>$url, 'HTMLBlock'=>false]);
    }
}
