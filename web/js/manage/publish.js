/**
 * Created by liuxh04 on 2016/6/30.
 */

"use strict";

var hashes = [], uploadedImage = 0,
    uploader,
    selectedMaterial = 0,
    panoramaUrl = $('.jumpToPanorama').val()
    ;

var component = {
    picName : $('.pic-name'),                       // 图片标题输入框
    padResult: $('.pad-result'),                    // 上传后显示结果的框
    textStatus: $('.pad-status .status'),
    linkStatus: $('.pad-status .link'),

    padMain: $('.pad-main'),                        // 上传操作主要框
    zoneUploadedPics:$('.zone-uploaded-pics'),      // 显示上传全景图区域
    zoneDefault: $('.zone-default'),                // 没有上传全景图片是显示的默认图片
    btnSelectPic: $('.btn-select-pic')              // 素材库选择全景图片按钮
};

var methods = {
    reset: function(){
        uploader.reset();
        selectedMaterial= 0;
        component.picName.val('');
        component.textStatus.css('color', '');
        component.zoneUploadedPics.empty().addClass('hidden');
        component.zoneDefault.removeClass('hidden');
    },
    toggleHashes: function(hash){
        if(hashes.length === 0){
            hashes.push(hash);
            return true;
        }
        for(var i = 0; i < hashes.length; i++){
            if(hashes[i] === hash){
                hashes.splice(i,1);
                return true;
            }
        }
        hashes.push(hash);
        return false;
    },
    hasHash: function(hash){
        if(hashes.length === 0){
            return false;
        }
        for(var i = 0; i < hashes.length; i++){
            if(hashes[i] === hash){
                return true;
            }
        }
        return false;
    }
}


// 文件上传
jQuery(function() {
    var $ = jQuery,
        $list = $('#thelist'),
        $btn = $('.btn-publish'),
        $wrap = $('.zone-uploaded-pics'),
        state = 'pending';

    var isSupportBase64 = ( function() {
        var data = new Image();
        var support = true;
        data.onload = data.onerror = function() {
            if( this.width != 1 || this.height != 1 ) {
                support = false;
            }
        }
        data.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
        return support;
    })();

    $('.webuploader-pick').next('div').css({});
    uploader = WebUploader.create({
        // 不压缩image
        resize: false,

        compress:false,

        // swf文件路径
        swf: './dist/webuploader/Uploader.swf',

        fileVal :"pano",

        chunkSize: 512 * 1024 * 100,

        // 文件接收服务端。
        server: '/admin/material/upload',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: {id:'#picker',multiple :true}
    });

    // 当有文件添加进来的时候
    uploader.on( 'fileQueued', function( file ) {
        $wrap.removeClass('hidden').siblings('.zone-default').addClass('hidden');
        uploader.makeThumb( file, function( error, src ) {
            if(file._info.width/file._info.height==2){

                // $list.append( '<div id="' + file.id + '" class="item">' +
                //     '<h4 class="info">' + file.name + '</h4>' +
                //     '<p class="state">等待上传...</p>' +
                // '</div>' );

                uploader.makeThumb( file, function( error, src ) {
                    var img;
                    if ( error ) {
                        $wrap.text( '不能预览' );
                        return;
                    }
                    if( isSupportBase64 ) {
                        console.log(file);
                        $wrap.append(
                                        '<div class="pre-parent-div" > ' +
                                        '   <div class="pre-img-container"> ' +
                                        '       <img src=" '+ src+' " /> ' +
                                        '       <div class="pre-img-progress hidden" data-id=' + file.id + '>' +
                                        '           <span class="progress-text">已上传0%</span>' +
                                        '           <span class="progress-bar"></span>' +
                                        '       </div>'+
                                        '   </div>' +
                                        '   <div class="pre-foot"> ' +
                                        '       <span class="filename nowrap" title="' + file.name + '">' + file.name + '</span>' +
                                        '       <a javascript="javascript:;" class="pre-img-dele" data-id="'+ file.id+'">删除</a>' +
                                        '   </div>' +
                                        '</div>'
                                    );
                        uploadedImage++;
                    } else {
                        $.ajax('/admin/material/upload', {
                            method: 'POST',
                            data: src,
                            dataType:'json'
                        }).done(function( response ) {
                            if (response.result) {
                                $wrap.append(
                                        '<div class="pre-parent-div" > ' +
                                        '   <div class="pre-img-container"> ' +
                                        '       <img src=" '+ response.result +' " /> ' +
                                        '       <div class="pre-img-progress hidden" data-id=' + file.id + '>' +
                                        '           <span class="progress-text">已上传0%</span>' +
                                        '           <span class="progress-bar"></span>' +
                                        '       </div>'+
                                        '   </div>' +
                                        '   <div class="pre-foot" >' +
                                        '       <span class="filename nowrap" title="' + file.name + '">' + file.name + '</span>' +
                                        '       <a href="javascript:;" class="pre-img-dele" data-id="'+ file.id+'">删除</a> ' +
                                        '   </div> ' +
                                        '</div>'
                                    );
                            } else {
                                $wrap.text("预览出错");
                            }
                        });
                    }
                }, 200, 200 );
            }else{
                alert("该图片的宽高比例不是 2:1 ");
                uploader.reset();
            }
        }, 100, 100 );
    });

    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var $progress = $( '.pre-img-progress[data-id="'+file.id+'"]');
        var $progressBar = $progress.find('.progress-bar').eq(0),
            $progressText = $progress.find('.progress-text').eq(0);
        $progress.removeClass('hidden');
        $progressText.text('已上传' + ( percentage * 100 ) +  '%');
        $progressBar.css( 'width', percentage * 100 + '%' );
    });

    uploader.on( 'uploadSuccess', function( file , response) {
        var $progressText = $( '.pre-img-progress').find('.progress-text').eq(0);
        $progressText.html('<span class="fa fa-spinner fa-spin"></span>发布中...');

        // 将上传给后台的全景图片hash值保存在全局中
        hashes.push(response.data.hs);

        uploadedImage--;

        if(uploadedImage === 0){
            $.ajax('/admin/material/generate', {
                data:{
                    title: component.picName.val(),
                    hashes: hashes
                },
                method: 'POST',
                dataType: 'json'
            }).done(function(res){
                hashes = [];
                uploadedImage = 0;
                if(res.result){
                    component.textStatus.text('发布成功');
                    component.linkStatus.html('您可以在<a  href="' + panoramaUrl + '">作品管理</a>中进行更多操作');
                }else{
                    component.textStatus.text('发布失败').css('color', '#ff2e34');
                    component.linkStatus.html('点击<a class="try_again"  href="javascript:void(0)" style="color:#ff2e34" class="jump">重新发布</a>再来一次');
                }
                component.padMain.addClass('hidden');
                component.padResult.removeClass('hidden');
            });
        }

    });

    uploader.on( 'uploadError', function( file ) {
        $( '#'+file.id ).find('p.state').text('上传出错');
    });

    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').fadeOut();
    });

    uploader.on( 'all', function( type ) {
        if ( type === 'startUpload' ) {
            state = 'uploading';
        } else if ( type === 'stopUpload' ) {
            state = 'paused';
        } else if ( type === 'uploadFinished' ) {
            state = 'done';
        }
        if ( state === 'uploading' ) {
            $btn.text('暂停上传');
        } else {
            $btn.text('发布');
        }
    });

    $("body").on("click",".pre-img-dele",function(){
        $(this).parent().parent().remove();
        uploader.removeFile( $(this).attr("data-id") ,true);
    }).on('click', '.btn-publish', function(){
        // 判断是否为空
        if(component.picName.val() === ''){
            component.picName.addClass('error').val('请输入标题');
        }else{
            if ( state === 'uploading' ) {

                uploader.stop();
            } else {
                if(($('.zone-uploaded-pics.publish>.pre-parent-div.uploaded-pics').length === 0) && (hashes.length !== 0)){
                    $.ajax('/admin/material/generate', {
                        data:{
                            title: component.picName.val(),
                            hashes: hashes
                        },
                        method: 'POST',
                        dataType: 'json'
                    }).done(function(res){
                        hashes = [];
                        uploadedImage = 0;
                        if(res.result){
                            component.textStatus.text('发布成功');
                            component.linkStatus.html('您可以在<a  href="' + panoramaUrl + '">作品管理</a>中进行更多操作');
                        }else{
                            component.textStatus.text('发布失败').css('color', '#ff2e34');
                            component.linkStatus.html('点击<a class="try_again"  href="javascript:void(0)" style="color:#ff2e34" class="jump">重新发布</a>再来一次');
                        }
                        component.padMain.addClass('hidden');
                        component.padResult.removeClass('hidden');
                    });
                }else{
                    uploader.upload();
                }
            }
        }

    });



});

//绑定事件
var bindEvent = function(){
    component.picName.focus(function(){
        var _this = $(this);
        _this.hasClass('error') &&
        _this.removeClass('error').val('');
    });
    component.padResult.on('click', '.try_again', function(){
        component.padResult.addClass('hidden');
        methods.reset();
        component.padMain.removeClass('hidden');
    });
    // 从素材库中选择图片
    component.btnSelectPic.click(function(){
        $.ajax({
            type: 'get',
            url:  '/material/list',
            data: { page:1, pageSize:50 },
            dataType:'json',
            success: function(data){

                $("#Pagination").pagination(data.total, {
                    items_per_page:8,
                    num_display_entries:10,
                    num_edge_entries:2,
                    prev_text :"上一页",
                    next_text :"下一页",
                    callback : function(page_index){
                        var i=(page_index)*8 ,lastIndex=i+8,_data=[];
                        lastIndex> data.items.length ? lastIndex=data.items.length :null;
                        for(i;i<lastIndex;i++){
                            _data.push(data.items[i]);
                        }
                        var _html = template('test', {items: _data});
                        $(".zone-uploaded-pics.in-modal").html("").html(_html);
                        $('#modal-material-library').modal('show');

                        $('.btn-select-material').each(function(){
                            var _this = $(this);
                            var hash = _this.data('hash');
                            methods.hasHash(hash) && _this.addClass('selected fa fa-check');
                        })
                    }
                });

            },
            error :function(data){

            }
        });

    })

    $('body')
        .on('click', '.btn-select-material', function(){
            var _this = $(this);
            if(_this.hasClass('selected')){
                _this.removeClass('selected fa fa-check').html('');
                selectedMaterial--;
            }else{
                _this.addClass('selected fa fa-check');
                selectedMaterial++;
            }
            methods.toggleHashes(_this.data("hash"));
            selectedMaterial === 0 ? $('.btn-confirm-material').addClass('hidden') : $('.btn-confirm-material').removeClass('hidden');
        })
        // 点击确定素材按钮
        .on('click', '.btn-confirm-material', function(){
            var materials = [];
            if(component.zoneDefault.hasClass('hidden')){
                component.zoneDefault.addClass('hidden');
                component.zoneUploadedPics.removeClass('hidden');
            }
            $('.modal-body .btn-select-material.selected').each(function(){
                var material = $(this).parent();
                material.find('.btn-select-material').addClass('hidden');
                materials.push(material);
            });

            $('.zone-uploaded-pics.publish .pre-parent-div.in-material').remove();

            for(var i = 0; i < materials.length; i++){
                component.zoneUploadedPics.append(materials[i]);
            }
            $('#modal-material-library').modal('hide');
        })
}();
