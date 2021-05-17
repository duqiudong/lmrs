/**
 * 六星开源商城系统 - 团队十年电商经验汇集巨献!
 * ========================================================= Copy right
 * 2015-2025 湖南六星教育网络科技有限公司, 保留所有权利。
 * ---------------------------------------------- 官方网址:
 * http://www.sixstaredu.com 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用。
 * 任何企业和个人不允许对程序代码以任何形式任何目的再发布。
 * =========================================================
 * 
 * @author : 小学生
 * @date : 2016年12月16日 16:17:13 wyj
 * @version : v1.0.0.0 商品规格库存表格构建
 */

/**
 *  规格属性选择数组 
 */
var $specObj = new Array();
/**
 *  规格属性组拼sku数组
 */
var $sku_array=new Array();
/**
 * 临时表  用于存储库存值
 */
var $temp_Obj = new Object();

/**
 * 删除数组中的指定元素
 * @param arr
 * @param val
 */
function SpliceArrayItem(arr, val) {
	  for(var i=0; i<arr.length; i++) {
	    if(cmp(arr[i], val)) {
	      arr.splice(i, 1);
	      break;
	    }
	  }
}
//判断对象中的两个值是否相等
cmp = function( x, y ) { 
	if ( x === y ) { 
	 return true; 
	} 
	if ( ! ( x instanceof Object ) || ! ( y instanceof Object ) ) { 
	 return false; 
	} 
	if ( x.constructor !== y.constructor ) { 
	 return false; 
	} 
	  
	for ( var p in x ) { 
	 if ( x.hasOwnProperty( p ) ) { 
	 if ( ! y.hasOwnProperty( p ) ) { 
	  return false; 
	 } 	 
	 if ( x[ p ] === y[ p ] ) { 
	  continue; 
	 } 
	 if ( typeof( x[ p ] ) !== "object" ) { 
	  return false; 
	 } 
	 if ( ! Object.equals( x[ p ], y[ p ] ) ) { 
	  return false; 
	 } 
	 } 
	} 
	 
	for ( p in y ) { 
	 if ( y.hasOwnProperty( p ) && ! x.hasOwnProperty( p ) ) { 
	 return false; 
	 } 
	} 
	return true; 
};

/**
 *  添加或删除属性值时更新到规格数组中
 * @param spec_name
 * @param spec_id
 * @param spec_value
 * @param spec_value_id
 * @param is_selected
 */
function addOrDeleteSpecObj(spec_name , spec_id , spec_value_name , spec_value_id ,spec_show_type, spec_value_data , is_selected){
		var is_have= 0;
		for(var i = 0; i < $specObj.length ; i ++ ){
			if($specObj[i]["spec_name"] == spec_name &&  $specObj[i].spec_id == spec_id){
				if(is_selected == 1){
					$specObj[i]["value"].push({"spec_value_name":spec_value_name, "spec_name":spec_name, "spec_id":spec_id,"spec_value_id":spec_value_id,"spec_show_type":spec_show_type, "spec_value_data":spec_value_data});
					is_have = 1;				
				}else{
					SpliceArrayItem($specObj[i].value , {"spec_value_name":spec_value_name, "spec_name":spec_name, "spec_id":spec_id,"spec_value_id":spec_value_id,"spec_show_type":spec_show_type, "spec_value_data":spec_value_data});
					if($specObj[i].value.length == 0){
						$specObj.splice(i, 1);
					}
				}
			}
		}
		if(is_selected == 1){
			//第一次选此规格
			if(is_have == 0){
				//给此规格添加对象内部空间 并添加此属性
				var obj_length = $specObj.length;
				$specObj[obj_length] = new Object();
				$specObj[obj_length].spec_name = spec_name;
				$specObj[obj_length].spec_id = spec_id;
				$specObj[obj_length]["value"] = new Array();
				$specObj[obj_length]["value"].push({"spec_value_name":spec_value_name, "spec_name":spec_name, "spec_id":spec_id,"spec_value_id":spec_value_id,"spec_show_type":spec_show_type, "spec_value_data":spec_value_data});	
			}				
		}
	
}
//规格属性值修改
function editSpecValueName(event){
		if(event.flag){
			
			var spec_id = event.spec_id;
			var spec_value_id = event.spec_value_id;
			var spec_value_name = event.spec_value_name;
			var spec_name = event.spec_name;
			var spec_value_data = event.spec_value_data;
			var spec_show_type = event.spec_show_type;
			var is_continue = false;
			for(var i = 0; i < $specObj.length ; i ++ ){
				
				if($specObj[i]["spec_name"] == spec_name &&  $specObj[i].spec_id == spec_id){
					$.each($specObj[i]["value"],function(t,m){
						if(m["spec_value_id"] == spec_value_id){
							$specObj[i]["value"][t]["spec_value_name"] = spec_value_name;
							is_continue = true;
							return false;
						}
					});
				}
				if(is_continue){
					break;
				}
				
			}		
			createTable();
		}
	
}
/**
 * 修改属性展示方式值
 * @param spec
 * @returns
 */
function editSpecValueData(spec){
	if(spec.flag){
		var spec_id = spec.spec_id;
		var spec_value_id = spec.spec_value_id;
		var spec_name = spec.spec_name;
		var spec_value_data = spec.spec_value_data;
		var is_continue = false;
		for(var i = 0; i < $specObj.length ; i ++ ){		
			if($specObj[i]["spec_name"] == spec_name &&  $specObj[i].spec_id == spec_id){
				$.each($specObj[i]["value"],function(t,m){
					if(m["spec_value_id"] == spec_value_id){
						$specObj[i]["value"][t]["spec_value_data"] = spec_value_data;
						
					}
				});
			}
			if(is_continue){
				break;
			}
			
		}	
	}
}
$(function() {
	$(".goods-sku .goods-sku-item span").live("click",function(){
		if(timeoutID != null){
			clearTimeout(timeoutID);
		}
		var $this = $(this);
		timeoutID = setTimeout(function(){
			var spec_id = $this.data("spec-id");
			var spec_value_id = $this.data("spec-value-id");
			var spec_value_name = $this.text();
			var spec_name = $this.data("spec-name");
			var spec_value_data = $this.data("spec-value-data");
			var spec_show_type = $this.data("spec-show-type");
			if($this.hasClass("selected")){
				$this.removeClass("selected");
				/**
				 * 取消选中属性值时 删掉数组中的属性信息
				 */
				addOrDeleteSpecObj(spec_name , spec_id , spec_value_name , spec_value_id, spec_show_type, spec_value_data ,0)
			}else{
				$this.addClass("selected");
				/**
				 * 选中属性值时  将属性值 添加到数组中
				 */
				addOrDeleteSpecObj(spec_name ,spec_id ,spec_value_name ,spec_value_id, spec_show_type, spec_value_data, 1);			
			}
			/**
			 * 根据规格数组拜访数据 创建表格
			 */
			createTable();
		},200);
	})
})
//将对象处理成表格数据
function createSkuData($specArray){
	var $length=$specArray.length;
	$sku_array=new Array();
	if($length>0){
		var $spec_value_obj=$specArray[0]["value"];
		$.each($spec_value_obj,function(i,v){
			var $spec_id = v.spec_id
			var $spec_value_id=v.spec_value_id;
			var $spec_value=v.spec_value_name;
			var $sku_obj=new Object();
			$sku_obj.id=$spec_id+":"+$spec_value_id;
			$sku_obj.name=$spec_value;
			$sku_array.push($sku_obj);
		});
	}
	for($i=1;$i<$length;$i++){
		$spec_val_obj=$specArray[$i]["value"];
		$length_val=$spec_val_obj.length;
		$sku_copy_array=new Array();
		$.each($sku_array,function(i,v){
			$old_id=v.id;
			$old_name=v.name;
			for($y=0;$y<$length_val;$y++){
				var $spec_id=$spec_val_obj[$y].spec_id;
				var $id=$spec_val_obj[$y].spec_value_id;
				var $name=$spec_val_obj[$y].spec_value_name;
				$copy_obj=new Object();
				$copy_obj.id=$old_id+";"+$spec_id+":"+$id;
				$copy_obj.name=$old_name+";"+$name;
				$sku_copy_array.push($copy_obj);
			}
			
		});
		$sku_array=$sku_copy_array;
	}
}
//构建表格
function createTable(){
	//创建一个又关于对象各个子类长度的数组
	if($specObj.length == 0){
		$(".js-spec-table table thead").empty();
		$(".js-spec-table table tbody").empty();
		$(".js-spec-table table tfoot").empty();
		$(".js-spec-table").hide();
		$("#txtProductCount").val("").removeAttr("readonly");
		$("#txtProductSalePrice").val(0).removeAttr("readonly");
		$("#txtProductMarketPrice").val(0).removeAttr("readonly");
		$("#txtProductCostPrice").val(0).removeAttr("readonly");
	}else{
		$(".js-spec-table").show();
		if($("#txtProductCount").attr("readonly") != "readonly"){
			$("#txtProductCount").val("").attr("readonly","readonly");
		}
		if($("#txtProductCostPrice").attr("readonly") != "readonly"){
			$("#txtProductCostPrice").val(0).attr("readonly","readonly");
		}
		if($("#txtProductMarketPrice").attr("readonly") != "readonly"){
			$("#txtProductMarketPrice").val(0).attr("readonly","readonly");
		}
		if($("#txtProductSalePrice").attr("readonly") != "readonly"){
			$("#txtProductSalePrice").val(0).attr("readonly","readonly");
		}
	}
	var specArray = new Array(); 
	var each_num = 0;
	
	
	//头部倒序输入
	$.each($specObj,function(i,v){
	    var arr_length = v.value.length;
	    var each_spec_name = v.spec_name;
	    var spec_name_obj = {"each_length":arr_length, "spec_name":each_spec_name,"value":v.value}
	    specArray.push(spec_name_obj);
	    if(each_num == 0){
	    	each_num = arr_length;
	    }else{
	    	each_num = each_num * arr_length;
	    }
	});
	//将规格数据 转化成sku数据
	createSkuData(specArray);
	var th_html = "<tr>";
	for(var q=0;q<specArray.length;q++){  
		//给表头添加所选规格
		th_html +="<th class='text-center'>"+ specArray[q].spec_name +"</th>";		
	
	} 
	//表格表头
	th_html += '<th class="th-price">价格（元）</th>';
	th_html += '<th class="th-price">市场价（元）</th>';
	th_html += '<th class="th-price">成本价（元）</th>';
	th_html += '<th class="th-stock">库存</th>';
	th_html += '<th class="th-code">商家编码</th>';
	th_html += '<th class="text-right">销量</th>';
	th_html += '</tr>';
	$(".js-spec-table thead").html(th_html);
	
	//建立表格
	var html = "";
	for(var i = 0; i < $sku_array.length; i ++){
		var child_id_string = $sku_array[i]["id"].toString();
		var child_name_string = $sku_array[i]["name"].toString();
		
		if(child_id_string.indexOf(";")){
			var child_id_array = child_id_string.split(";");
			
		}else{
			var child_id_array = new Array(child_id_string);
		}
		if(child_name_string.indexOf(";")){
			var child_name_array = child_name_string.split(";");
			
		}else{
			var child_name_array = new Array(child_name_string);
		}
		//将规格,规格值处理成 spec_id,spec_value_id;spec_id,spec_value_id 格式
		if($temp_Obj[child_id_string] == undefined){
			$temp_Obj[child_id_string] = new Object();
			$temp_Obj[child_id_string]["sku_price"] ="0";
			$temp_Obj[child_id_string]["market_price"] ="0";
			$temp_Obj[child_id_string]["cost_price"] ="0";
			$temp_Obj[child_id_string]["stock_num"] ="0";
			$temp_Obj[child_id_string]["code"] ="";
		}
		html +="<tr skuid='"+child_id_string+"'>";
		//循环属性
		$.each(child_name_array,function(m,t){
			//为属性添加唯一值
			var start_index = 0;
			var substr_str = "";
			while(start_index <= m){
				if(child_id_array[start_index] != ''){
					if(substr_str == ""){
						substr_str = child_id_array[start_index]; 
						
					}else{
						substr_str +=";"+child_id_array[start_index]
					}
				}
				start_index++;
			} 
			html +='<td rowspan="1"  skuchild = "'+substr_str+'">'+t+'</td>';
			
		});
		html +='<td>';
		html +='<input type="text" name="sku_price" style="width: 80%;" class="js-price input-mini" maxlength="10" value="'+$temp_Obj[child_id_string]["sku_price"]+'" >';
		html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">价格最小为 0.01</span>';
		html +='</td>';
		html +='<td>';
		html +='<input type="text" name="market_price" maxlength="10" style="width: 80%;" class="js-market-price" value="'+$temp_Obj[child_id_string]["market_price"]+'">';
		html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">价格最小为 0.01</span>';
		html +='</td>';
		html +='<td>';
		html +='<input type="text" name="cost_price" maxlength="10" style="width: 80%;" class="js-cost-price" value="'+$temp_Obj[child_id_string]["cost_price"]+'">';
		html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">价格最小为 0.01</span>';
		html +='</td>';
		html +='<td>';
		html +='<input type="text" name="stock_num" class="js-stock-num input-mini" maxlength="9" value="'+$temp_Obj[child_id_string]["stock_num"]+'" onkeyup="inputKeyUpNumberValue(this);" onafterpaste="inputAfterPasteNumberValue(this);"/>';
		html +='<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">库存不能为空</span>';
		html +='</td>';
		html +='<td><input type="text" name="code" class="js-code input-small" value="'+$temp_Obj[child_id_string]["code"]+'"/></td>';
		html +='<td class="text-right">0</td>';
		html +="</tr>"
	}
	var newArray = new Array();
	$.each(specArray,function(z,x){
		newArray = newArray.concat(x.value);
	});

	var tdObj = $(".js-spec-table tbody").html(html);
	var tf_html = "";	
	tf_html +='<tr>';
	tf_html +='<td colspan="9" style="text-align:left;">';
	tf_html +='<div class="batch-opts">批量设置：';
	tf_html +='<span class="js-batch-type">';
	tf_html +='	<a class="js-batch-price" href="javascript:;">价格</a>&nbsp;&nbsp;';
	tf_html +='	<a class="js-batch-market_price" href="javascript:;">市场价</a>&nbsp;&nbsp;';
	tf_html +='	<a class="js-batch-cost_price" href="javascript:;">成本价</a>&nbsp;&nbsp;';
	tf_html +='	<a class="js-batch-stock" href="javascript:;">库存</a>';
	tf_html +='	</span>';
	tf_html +='	<span class="js-batch-form" style="display:none;">';
	tf_html +='<input type="text" maxlength="11" class="js-batch-txt input-mini" style="width:100px;margin:0;">&nbsp;&nbsp;';
	tf_html +='<a class="js-batch-save goods-sku-add" href="javascript:;" style="margin-right:10px;">保存</a>';
	tf_html +='<a class="js-batch-cancel goods-sku-cancle" href="javascript:;">取消</a>';
	tf_html +='<p class="help-desc"></p>';
	tf_html +='</span>';
	tf_html +='</div>';
    tf_html +='</td>';
	tf_html +='</tr>';
	$(".js-spec-table tfoot").html(tf_html);
	
	
	//合并单元格
	mergeTable();
	//循环处理库存
	eachInput();
	eachPrice();
	eachMarketPrice();
	eachCostPrice();
}

//合并单元格
function mergeTable(){
	for(var i = 0; i < $sku_array.length; i ++){
		var child_id_string = $sku_array[i]["id"].toString();
		var child_id_array = child_id_string.split(";");
		var sear_str = "";
		$.each(child_id_array,function(w,q){
			if(sear_str == ""){
				sear_str += q;
			}else{
				sear_str += ";"+q;
			}
			if($("td[skuchild = '"+sear_str+"']").length > 1){
				var check_array=$("td[skuchild = '"+sear_str+"']");
				for( var $i=0; $i<check_array.length;$i++){
					$check_obj=$(check_array[$i]);
					if($i == 0){
						$check_obj.attr("rowspan",check_array.length);					
					}else{
						$check_obj.remove();
					}
					
				}
			}
		})
	}
}
$(".js-spec-table tbody tr td input").live("change",function(){
	var outer_key = $(this).parent().parent().attr("skuid");
	var key = $(this).attr("name");
	var value = $(this).val();
	$temp_Obj[outer_key][key] = value;
})
//同步$sku_array,临时表$temp_Obj的数据
function synchroSkuValueData(){
	var sku_str = "";
	/**
	 * 临时表  用于存储库存值
	 */
	/*for(var i = 0; i < $sku_array.length ; i++ ){
		var sku_id = $sku_array[i]["id"];
		$.each($sku_array,function(w,q){
			$sku_array[i]["value"] = new Object(); 
			$sku_array[i]["value"]= $temp_Obj[sku_id];
		})
		
	}*/
	for(var i = 0; i < $sku_array.length ; i++ ){
		var sku_id = $sku_array[i]["id"];
		var value_array = new Array();
		$.each($sku_array,function(w,q){
			value_array = $temp_Obj[sku_id];
			
		})
		if(sku_str == ""){
			sku_str = sku_id +"¦"+value_array["sku_price"]+"¦"+value_array["market_price"]+"¦"+value_array["cost_price"]+"¦"+value_array["stock_num"]+"¦"+value_array["code"];
		}else{
			sku_str +="§"+sku_id +"¦"+value_array["sku_price"]+"¦"+value_array["market_price"]+"¦"+value_array["cost_price"]+"¦"+value_array["stock_num"]+"¦"+value_array["code"];
		}
	}
	return sku_str;	
}

/**
 * 更改商品类型清空$specObj 对象
 */
function goodsTypeChangeData(){
	$specObj  = new Array();
	createTable();
}

function editSkuData(spec_obj_str , sku_data){
	updateSpecObjData(spec_obj_str);
	updateTempObjData(sku_data);
	if($specObj.length > 0){
		createTable();		
	}
}
//修改商品时 更新$specObj,并编辑页面结构
function updateSpecObjData(spec_obj_str){
	if(spec_obj_str != ""){
		$specObj = eval(spec_obj_str); 			
	}
	for(var i = 0 ; i <$specObj.length; i++ ){
		for(var m = 0;m <$specObj[i]["value"].length ; m ++ ){
			var selected_obj = $(".js-goods-sku article>span[data-spec-id="+$specObj[i]['spec_id']+"][data-spec-value-id="+$specObj[i]["value"][m]['spec_value_id']+"]");
	    	selected_obj.addClass("selected");   
	    	
	    	selected_obj.text($specObj[i]["value"][m]["spec_value_name"]);
	    	if(selected_obj.data("spec-show-type") == $specObj[i]["value"][m]["spec_show_type"]){
	    		//selected_obj.data("spec-value-data",$specObj[i]["value"][m]['spec_value_data']);
	    		selected_obj.attr("data-spec-value-data",$specObj[i]["value"][m]['spec_value_data']);
	    	}else{
	    		$specObj[i]["value"][m]["spec_show_type"] = selected_obj.data("spec-show-type");
	    		$specObj[i]["value"][m]["spec_value_data"] = selected_obj.data("spec-value-data");
	    	}
	    	$specObj[i]["value"][m]["spec_name"] = selected_obj.data("spec-name");
	    	if(selected_obj.data("spec-show-type") == 2){
	    		//颜色
	    		selected_obj.parent().children("div").children("input").val(selected_obj.data("spec-value-data") == "" ? "#000000" : selected_obj.data("spec-value-data"));
	    	}else if (selected_obj.data("spec-show-type") == 3){
	    		//图片
	    		var src = selected_obj.data("spec-value-data");
	    		if(src == ""){
	    			src = ADMINIMG + "/goods/goods_sku_add.png";
	    		}else{
	    			src = UPLOAD + "/" +  src;
	    		}
	    		selected_obj.parent().children("div").children("img").attr("src",src);
	    	}
		}
		
	}
}
//修改商品时 更新temp_obj
function updateTempObjData(sku_data){
	var total_stock  =0;
	if($specObj.length > 0){
		$.each(sku_data,function(c,v){			
			$temp_Obj[v.attr_value_items] = new Object();
			$temp_Obj[v.attr_value_items]["sku_price"] =v.price;
			$temp_Obj[v.attr_value_items]["market_price"] =v.market_price;
			$temp_Obj[v.attr_value_items]["cost_price"] =v.cost_price;
			$temp_Obj[v.attr_value_items]["stock_num"] =v.stock;
			$temp_Obj[v.attr_value_items]["code"] =v.code;
		});
		$("#txtProductCount").attr("readonly","readonly");
		$("#txtProductSalePrice").attr("readonly","readonly");
	}
	
}


/**
 * input  只能输入数字
 */
function inputKeyUpNumberValue(event){
	if(event.value.length==1){
		event.value=event.value.replace(/[^0-9]/g,'');
	}else{
		event.value=event.value.replace(/\D/g,'');
	}
}

function inputAfterPasteNumberValue(event){
	if(event.value.length==1){
		event.value=event.value.replace(/[^0-9]/g,'');
	}else{
		event.value=event.value.replace(/\D/g,'');
	}
}
