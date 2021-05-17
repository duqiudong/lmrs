//导航
$(function() {
	if($('.category-box').is('.category-box-border')){
		$('#nav .wrap-line').hide();
	}else{
		$('#nav .wrap-line').show();
	}
	
	// 导航滑动效果
	if ($('#nav li').length > 0) {

		var current = $('#nav li').find(".current").parents("li");

		if ($(current).size() == 0) {
			current = $('#nav li').eq(0);
		}

		$('#nav .wrap-line').css({
			left: $(current).position().left,
			width: $(current).outerWidth()
		});

		$('#nav li').hover(function() {
			$('#nav .wrap-line').stop().animate({
				left: $(this).position().left,
				width: $(this).outerWidth()
			});
		}, function() {
			$('#nav .wrap-line').stop().animate({
				left: $(current).position().left,
				width: $(current).outerWidth()
			});
		});
	}
	try {
		// 全部分类展开时左侧一级分类鼠标经过弹框
		$('.list').hover(function() {
			if($(this).find(".categorys .subitems dl").length>0){
				$(this).find('.categorys').show();
			}else{
				$(this).find(".cat i").hide();
			}
		}, function() {
			$(this).find('.categorys').hide();
		});
	} catch (e) {
	}
});