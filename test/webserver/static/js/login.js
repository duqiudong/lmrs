// JavaScript Document
$(function(){

	//��ά�롢PC��¼�л�
	$('.qrcode-target').click(function(){
		if($(this).hasClass('btn-qrcode')){
			$(this).removeClass('btn-qrcode').addClass('btn-login').attr('title','ȥ���Ե�¼');
			$('.login-wrap').hide();
			$('.login-mobile').show();
			return;
		}
		if($(this).hasClass('btn-login')){
			$(this).removeClass('btn-login').addClass('btn-qrcode').attr('title','ȥ�ֻ�ɨ���¼');
			$('.login-wrap').show();
			$('.login-mobile').hide();
		}
	});
	
});