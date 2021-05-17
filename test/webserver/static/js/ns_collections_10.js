// 取消收藏 is_reload: true 刷新
function cancelCollection(fav_id, fav_type, is_reload) {
	$.ajax({
		url : shop_main + "/components/cancelcollgoodsorshop",
		type : "post",
		asysc : false,
		data : {
			"fav_id" : fav_id,
			"fav_type" : fav_type
		},
		success : function(data) {
			if (data.code > 0) {
				if (is_reload) {
					location.reload();
				} else {
					refreshShopOrGoodsCollections(fav_type);// shopping_cart.js
					// 右侧边栏的收藏
				}
			}
		}
	});
}
/*
 * 收藏商品 flag :true，列表模式，false：大图模式
 */
function collectionGoods(fav_id, fav_type, log_msg,obj,flag) {
	var uid = $("#hidden_uid").val();
	if (uid != null && uid != "") {
		var logid = $(obj).find("i").attr("data-log-id")>0?1:0;
		if (logid == 0) {
			$.ajax({
				url : shop_main+"/components/collectiongoodsorshop",
				type : "post",
				data : {
					"fav_id" : fav_id,
					"fav_type" : fav_type,
					"log_msg" : log_msg
				},
				success : function(data) {
					if (data.code > 0) {
						if (flag) {
							$(obj).text("已收藏");
						} else {
							$(obj).find("span").text("已收藏");
							$(obj).find("i").css("background-position",
									"-107px -11px");
							$(obj).find("i").attr("data-log-id", 1)
						}
					}
				}
			});
		} else {
			$.ajax({
				url : shop_main+"/components/cancelcollgoodsorshop",
				type : "post",
				data : {
					"fav_id" : fav_id,
					"fav_type" : fav_type
				},
				success : function(data) {
					if (data.code > 0) {
						if (flag) {
							$(obj).text("收藏");
						} else {
							$(obj).find("i").css("background-position",
									"-91px -11px");
							$(obj).find("i").attr("data-log-id", 0)
							$(obj).find("span").text("收藏");
						}
					}
				}
			});
		}
	} else {
		location.href = shop_main + "/login/index";
	}
}