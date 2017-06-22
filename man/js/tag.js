/*标签生成*/
var taglib='';
$(function(){
	//获取（保持父子类别关系）类别下拉列表
    $.post("./srv/rdo.php?", {tpl:"get_artcate_new"}, function (d, e) {
        $("#tag_cid").html(d);
    });
})
$(function(){
	$.post("./srv/tag.php",{"tpl":"taglib"},function(d){
	    taglib=eval('('+d+')');
		change(0);
		var global=getTagInfo(1);
		var cate=getTagInfo(2);
		var art=getTagInfo(3);
		var global_html='';
		var cate_html='';
		var art_html='';
		for(var key in global){
			global_html+=' <li><span class="tag_color"><%'+key+'%></span>  '+global[key][0]+'<span class="right">'+global[key][1]+'</span></li>';
		}
		for(var key in cate){
			cate_html+=' <li><span class="tag_color"><:'+key+'></span>  '+cate[key][0]+'<span class="right">'+cate[key][1]+'</span></li>';
		}
		for(var key in art){
			art_html+=' <li><span class="tag_color"><:'+key+'></span>  '+art[key][0]+'<span class="right">'+art[key][1]+'</span></li>';
		}
		$(".tagv1").html(global_html);
		$(".tagv2").html(cate_html);
		$(".tagv3").html(art_html);
		$(".tagvv:first").addClass("active");
		$(".tagv").hide();
		$(".tagv1").show();
		
		
		$("#tag").change(function(){
			if($(this).val()==''){
				change(0);
			}else if($.inArray($(this).val(),['1','2','3'])>-1){
				change(1);
				$(".type_var_content").html($(".tagv"+$(this).val()).html());
			}else{
				change(2,$(this).val());
			}
		})
		
		$(".tagvv").each(function(){
			$(this).click(function(){
				$(this).addClass("active");
				$(this).siblings().removeClass("active");
				var data=$(this).attr("data");
				$(".tagv").hide();
				$(".tagv"+data).show();
			})
		})
	})
	
	
})

function change(type){
	var val= arguments[1] ? arguments[1] : 1;
	if(type=='0'){
		$(".type_fun").hide();
		$(".type_var").hide();
		$(".tag_index").show();
	}else if(type=='1'){
	    $(".type_fun").hide();
		$(".tag_index").hide();
		$(".type_var").show();
	}else{
		$(".tag_index").hide();
	    $(".type_var").hide();
		$(".type_fun").show();
		if($.inArray(val,['8','9','10','11','12','13'])>-1){
			$(".type_fun1,.type_fun4").hide();
			$(".type_fun2").css("height","25%");
			$(".type_fun3").css("height","75%");
		}else{
			$(".type_fun1,.type_fun4").show();
			$(".type_fun2").css("height","20%");
			$(".type_fun3").css("height","30%");
			$(".tag_option").hide();
			$(".c"+val).show();
			$("#cur_val").val("");
		}
		var tagInfo=getTagInfo(parseInt(val));
		$("#intro").val(tagInfo[2]+'\r\n'+tagInfo[1]);
		$("#example").val(tagInfo[3]);
	}
}

function getTagInfo(val){
	switch(val){
		case 1:
		    return taglib['globalTag'];
		    break;
		case 2:
		    return taglib['cateTag'];
		    break;
		case 3:
		    return taglib['artTag'];
		    break;	
		case 4:
		    return taglib['loopTag']['menu_loop'];
		    break;
		case 5:
		    return taglib['loopTag']['child_loop'];
		    break;
		case 6:
		    return taglib['loopTag']['art_loop'];
		    break;
		case 7:
		    return taglib['loopTag']['search_loop'];
		    break;
		case 8:
		    return taglib['dataTag']['artinfo'];
		    break;
		case 9:
		    return taglib['otherTag']['getcinfo'];
		    break;
		case 10:
		    return taglib['otherTag']['date'];
		    break;
		case 11:
		    return taglib['otherTag']['cut'];
		    break;
		case 12:
		    return taglib['otherTag']['getPrevInfo'];
		    break;
		case 13:
		    return taglib['otherTag']['getNextInfo'];
		    break;
		case 14:
		    return taglib['loopTag']['link_loop'];
		    break;
	}
		
	
}

function build(){
	var tag_num=$("#tag_num").val();
	var tag_cid=$("#tag_cid").val();
	var tag_loop_type=$("#tag_loop_type").val();
	var tag_istop=$("#tag_istop").val();
	var tag_origin=$("#tag_origin").val();
	var tag_isfenye=$("#tag_isfenye").val();
	var tag_keyword=$("#tag_keyword").val();
	switch(parseInt($("#tag").val())){
		case 4:
			var cur_val='<f:loop(menu_loop,,'+tag_num+')>\r\n    <li><a href="<:@url>"><:name></a></li>\r\n</f:loop>';
			$("#cur_val").val(cur_val);
		    break;
		case 5:
		    var cur_val='<f:loop(child_loop,'+tag_cid+','+tag_num+')>\r\n    <li><a href="<:@url>"><:name></a></li>\r\n</f:loop>';
			$("#cur_val").val(cur_val);
		    break;
		case 6:
			var cur_val='<f:loop(art_loop,'+tag_cid+','+tag_num+','+tag_loop_type+','+tag_istop+','+tag_origin+','+tag_isfenye+')>\r\n    <li><img src="<:thumb>" /><a href="<:@url>"><:name></a><li>\r\n</f:loop>';
			$("#cur_val").val(cur_val);
		    break;
		case 7:
			var cur_val='<f:loop(search_loop,'+tag_keyword+','+tag_num+','+tag_loop_type+','+tag_istop+','+tag_isfenye+')>\r\n    <li><img src="<:thumb>" /><a href="<:@url>"><:name></a><li>\r\n</f:loop>';
			$("#cur_val").val(cur_val);
		    break;
		case 14:
			var cur_val='<f:loop(link_loop,'+tag_num+')>\r\n    <li><img src="<:logo>" /><a href="<:@url>"><:name></a><li>\r\n</f:loop>';
			$("#cur_val").val(cur_val);
		    break;
	}
}
