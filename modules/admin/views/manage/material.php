<?php
/**
 * Material Page
 * Created by PhpStorm.
 * User: liuxh04
 * Date: 2016/6/29
 * Time: 21:17
 */
?>
<?php
    $baseUrl = \Yii::$app->urlManager->getBaseUrl();
?>
<?php $this->beginBlock('css') ?>
    <link rel="stylesheet" href="<?=$baseUrl?>/css/manage/material.css?v=232361">
<?php $this->endBlock('css') ?>

<!--  content   -->
<div class="pad-publisher">
    <div class="tab-nav">
        <button class="btn-scene">全景图片</button>
    </div>
    <div class="pad-main">
        <div class="x-row">
            <span class="tip-statistics">已有全景素材 <b>23</b> 个</span>
            <label class="select_all" for="">
                <button class="btn-select-material"></button>
                全选
            </label>
            <button class="pull-right x-button ">上传</button>
        </div>
        <div class="pad-function">
            <div class="zone-uploaded-pics hidden">
                <div class="card-material">
                    <div class="img-content">
                        <button class="btn-select-material sub"></button>
                        <img  class="cover-material"  src="" alt="">
                    </div>
                    <div class="word-content">
                        <span>LXHFIGHT</span>
                        <button class="btn-delete fa fa-trash"></button>
                    </div>
                </div>
            </div>
            <div class="zone-default">
                还没有素材
            </div>
        </div>
    </div>
</div>



<?php $this->beginBlock('js') ?>
    <script src="<?=$baseUrl ?>/js/manage/material.js?v=34632673"></script>
<?php $this->endBlock('js') ?>
