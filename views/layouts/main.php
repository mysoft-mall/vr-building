<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
$baseUrl = \Yii::$app->urlManager->getBaseUrl();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="<?=$baseUrl?>/dist/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=$baseUrl?>/css/global.css">
    <?php $this->head() ?>
    <?php
    if (isset($this->blocks['css'])) { ?>
        <?= $this->blocks['css'] ?>
        <?php
    } ?>
</head>
<body>
<?php $this->beginBody() ?>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">CloudVR</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="btn-nav active"><a href="<?= \Yii::$app->urlManager->createUrl('admin/manage/publish')?>">发布 <span class="sr-only">(current)</span></a></li>
                    <li class="btn-nav"><a href="<?= \Yii::$app->urlManager->createUrl('admin/manage/material')?>">素材库</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="x-container">
        <div class="container" style="height:100%">
            <?= $content ?>
        </div>
    </div>
    <footer class="x-footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>
<script src="<?=$baseUrl?>/dist/jquery/jquery.min.js"></script>
<script src="<?=$baseUrl?>/dist/bootstrap/js/bootstrap.min.js"></script>
<script src="<?=$baseUrl?>/js/global.js"></script>
<?php
if (isset($this->blocks['js'])) { ?>
    <?= $this->blocks['js'] ?>
    <?php
} ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
