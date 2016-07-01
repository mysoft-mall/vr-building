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
    <link rel="stylesheet" href="<?=$baseUrl?>/dist/paging/pagination.css"/>
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
            <div class="zone-uploaded-pics publish hidden">

            </div>
            <div class="zone-default">
                请上传全景图片
            </div>
        </div>
        <div class="pad-uploader">
            <button class="btn-publish">发布</button>
        </div>
    </div>
    <div class="pad-result hidden">
        <div class="pad-status ">
            <span class="status"></span>
            <input type="hidden" name="" class="jumpToPanorama" value="<?= \Yii::$app->urlManager->createUrl('admin/manage/panorama')?>">
            <span class="link"></span>
        </div>
    </div>
</div>

<script id="test" type="text/html">
    {{each items as item}}
    <div class="pre-parent-div in-material"  >
        <button class="btn-select-material" data-hash="{{item.hash}}"></button>
        <div class="pre-img-container">
            <img src="{{item.thumb_url}}" height="200" width="200"/>
            <div class="pre-img-progress hidden" data-id="{{item.id}}">
                <span class="progress-text">已上传0%</span>
                <span class="progress-bar"></span>
            </div>
        </div>
        <div class="pre-foot" >
            <span class="filename nowrap" title="' + file.name + '">{{item.file_name}}</span>
            <a href="javascript:;" class="pre-img-dele" data-id="{{item.id}}">删除</a>
        </div>
    </div>
    {{/each}}
</script>


<?php $this->beginBlock('modal') ?>
    <div class="modal fade" id="modal-material-library">
        <div class="modal-dialog" >
            <div class="modal-content" >
                <div class="row-title">
                    <span class="modal-title">素材库</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 1.0; color:#ddd"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" >
                    <div class="zone-uploaded-pics in-modal" style="background-color:#eee;height:100%">

                    </div>
                    <div class="zone-default hidden" id="zone-thumb">
                        还没有素材
                    </div>
                </div>
                <div id="Pagination" class="pagination" style="height:65px;bottom:0; position:absolute;">
                    <!-- 这里显示分页 -->
                </div>
                <button class="btn-confirm-material hidden">确定</button>
            </div>
        </div>
    </div>
<?php $this->endBlock('modal') ?>

<?php $this->beginBlock('js') ?>
    <script src="<?=$baseUrl ?>/dist/template.js"></script>
    <script src="<?=$baseUrl ?>/dist/paging/jquery.pagination.js"></script>
    <script src="<?=$baseUrl?>/dist/webuploader/webuploader.js"></script>
    <script src="<?=$baseUrl?>/js/manage/publish.js"></script>
<?php $this->endBlock('js') ?>
