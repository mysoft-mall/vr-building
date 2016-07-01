jQuery(function() {
    var $ = jQuery,
        uploader;

	

	function loadData(){
       	$.ajax({
               type: 'get',
               url:  '/panorama/list',
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
                   		  $("#zone-thumb tbody").html("").html(_html);
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
	        url:  '/panorama/delete',
	        data: { id:id },
	        dataType:'json',
	        success: function(data){
	        	 
	        	 //loadData();

	        },
	        error :function(){
	            
	        }
	    });
    });
   

});



