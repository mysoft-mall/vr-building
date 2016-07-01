<?php
/**
 * Created by PhpStorm.
 * User: liuxh04
 * Date: 2016/6/29
 * Time: 16:14
 */
?>
<?php
    $baseUrl = \Yii::$app->urlManager->getBaseUrl();
?>
<?php $this->beginBlock('css') ?>
    <link rel="stylesheet" href="<?=$baseUrl?>/css/manage/publish.css"/>
<?php $this->endBlock() ?>
<!--    content     -->
<div class="pad-publisher">
    <div class="tab-nav">
        <button class="btn-scene">全景图片</button>
    </div>
    <div class="pad-main">
        <div class="x-row">
            <input type="text" name="" id="" class="pic-name" placeholder="输入全景图片标题">
        </div>
        <div class="pad-function">
            <div class="x-row btn-bar">
                <div id="picker">上传全景图片</div>
<!--                <button class="x-button btn-upload-pic" type="button">上传全景图片</button> -->
                <button class="x-button btn-select-pic" type="button">素材库选择全景图片</button>
            </div>
            <!--    已上传全景图片区域    -->
            <div class="zone-uploaded-pics hidden">

            </div>
            <div class="zone-default">
                请上传全景图片
            </div>
        </div>
        <div class="pad-uploader">
            <button class="btn-publish">发布</button>
        </div>
    </div>
</div>

<div class="modal fade" id="material-library">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php $this->beginBlock('js') ?>
    <script src="<?=$baseUrl?>/dist/webuploader/webuploader.js"></script>
    <script src="<?=$baseUrl?>/js/manage/publish.js"></script>
<?php $this->endBlock() ?>
