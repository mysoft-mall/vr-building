jQuery(function() {
    var $ = jQuery,
        $list = $('#thelist'),
        $btn = $('#ctlBtn'),
        $wrap = $('#wrap'),
        state = 'pending',
        uploader;
    
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

    uploader = WebUploader.create({
        // 不压缩image
        resize: false,

        auto :true,

        // swf文件路径
        swf: '../../dist/Uploader.swf',

        chunkSize: 512 * 1024 * 100,

        fileVal :"pano",

         // 文件接收服务端。
         server: '/material/upload',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: {id:'#picker',multiple :false}
    });

    // 当有文件添加进来的时候
    uploader.on( 'fileQueued', function( file ) {
    	//console.log(uploader.getFiles())
        uploader.makeThumb( file, function( error, src ) {
            if(file._info.width/file._info.height==2){
                uploader.makeThumb( file, function( error, src ) {
                   var img;
                   if ( error ) {
                       $wrap.text( '不能预览' );
                       return;
                   }
                   if( isSupportBase64 ) {
                       $wrap.append( '<div class="pre-parent-div uploaded-pics" > <div class="pre-img-container"> <img src=" '+ src+' " /> </div><div class="pre-foot"> <a javascript="javascript:;" class="pre-img-dele" data-id="'+ file.id+'">删除</a></div></div>' );
                   } else {
                       $.ajax('./server/preview.php', {
                           method: 'POST',
                           data: src,
                           dataType:'json'
                       }).done(function( response ) {
                           if (response.result) {
                            $wrap.append( '<div class="pre-parent-div uploaded-pics" > <div class="pre-img-container"> <img src=" '+ response.result +' " /> </div><div class="pre-foot" > <a javascript="javascript:;" class="pre-img-dele" data-id="'+ file.id+'">删除</a> </div> </div>' );
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
        var $li = $( '#'+file.id ),
            $percent = $li.find('.progress .progress-bar');

        // 避免重复创建
        if ( !$percent.length ) {
            $percent = $('<div class="progress progress-striped active">' +
              '<div class="progress-bar" role="progressbar" style="width: 0%">' +
              '</div>' +
            '</div>').appendTo( $li ).find('.progress-bar');
        }
        $li.find('p.state').text('上传中');
        $percent.css( 'width', percentage * 100 + '%' );
    });

    uploader.on( 'uploadSuccess', function( file ) {
        $( '#'+file.id ).find('p.state').text('已上传');
        alert("上传成功");
        loadData();
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
            $btn.text('开始上传');
        }
    });
    
    $("body").on("click",".pre-img-dele",function(){
        $(this).parent().parent().remove();
        uploader.removeFile( $(this).attr("data-id") ,true);
    });

    $("#release").click(function(){
        if ( state === 'uploading' ) {
            uploader.stop();
        } else {
            uploader.upload();
        }
    });

	

	function loadData(){
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
                       	$("#thumb-count").html(data.total);
                   		  var _html = template('test',{items: _data});
                   		  $("#zone-thumb").html("").html(_html);
                      }
                   });
               },
               error :function(data){
                     
               }
           });
	}

	loadData();
    

    $("body").on("click",".a-dele",function(){
	    var id=$(this).attr("data-id");
		$.ajax({
	        type: 'POST',
	        url:  '/material/delete',
	        data: { id:id },
	        dataType:'json',
	        success: function(data){
	        	 
	        	 loadData();

	        },
	        error :function(){
	            
	        }
	    });
    });
   

});



