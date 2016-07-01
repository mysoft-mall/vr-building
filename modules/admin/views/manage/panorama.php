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
    <link rel="stylesheet" href="<?=$baseUrl?>/css/manage/panorama.css?v=232361">
    <link rel="stylesheet" href="<?=$baseUrl?>/dist/paging/pagination.css?v=232361">
<?php $this->endBlock('css') ?>

<!--  content   -->
<div class="pad-publisher">
    <div class="tab-nav">
        <button class="btn-scene">作品管理</button>
    </div>
    <div class="pad-main">
        <div class="x-row">
            <span class="tip-statistics">已有全景素材 <b id="thumb-count">0</b> 个</span>
            <label class="select_all" for="">
                <button class="btn-select-material"></button>
                全选
            </label>
        </div>
        <div class="pad-function">
            <div class="zone-default" id="zone-thumb">
               <table width="100%" class="table-pano">
                   <thead>
                     <tr>
                       <td class="td-checkbox"><input type="checkbox" title="全选"/></td>
                       <td>作品</td>
                       <td>分享</td>
                       <td>操作</td>
                     </tr>
                   </thead>
                   <tbody>
                       
                   </tbody>
               </table>
            </div>
        </div>
        
        <div style="clear:both"></div>
        <div id="Pagination" class="pagination"><!-- 这里显示分页 --></div>
    </div>
</div>

    <script id="test" type="text/html">
        {{each items as item}}
            <tr>
              <td class="td-checkbox"><input type="checkbox" /></td>
              <td>
                  <div class="div-pano">
                        <div class="pano-img">
                            <img src="{{ item.thumb_url }}" width="40" height="40"/>
                        </div>
                        <div class="pano-info">
                            <div class="title">{{item.title}}</div>
                            <div class="time">{{item.created_on}}</div>
                        </div>  
                  </div>
              </td>
              <td>
                 <a data-url="{{item.panorama_url}}">分享 </a> 
              </td>
              <td>
                  <a  data-id="{{item.id}}">删除</a>
              </td>
            </tr>


            <div class="div-thumb">
                <div class="div-dele">
                   <span>{{item.title}}</span>
                </div>
            </div>
        {{/each}}
    </script>

    <div id="content"></div>

<?php $this->beginBlock('js') ?>
    <script src="<?=$baseUrl ?>/dist/template.js"></script>
    <script src="<?=$baseUrl ?>/dist/paging/jquery.pagination.js"></script>
    <script src="<?=$baseUrl ?>/js/manage/panorama.js?v=34632673"></script>
<?php $this->endBlock('js') ?>