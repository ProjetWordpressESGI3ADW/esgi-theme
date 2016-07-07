jQuery(document).ready(function(){
	jQuery(document).on('click','.reduire',function(){
		jQuery(this).addClass("agrandir");
		jQuery("#toi-aussi-upload-ton-img").css("width", "10px");
		jQuery(".reduire").html("+");
		jQuery(this).removeClass("reduire");
		jQuery(".titre_popup").css("display", "none");
		jQuery("#img-upload-form-container").css("display", "none");
	});
	
	jQuery(document).on('click','.agrandir',function(){
		jQuery(this).addClass("reduire");
		jQuery("#toi-aussi-upload-ton-img").css("width", "auto");
		jQuery(".agrandir").html("Masquer");
		jQuery(this).removeClass("agrandir");
		jQuery(".titre_popup").css("display", "block");
		jQuery("#img-upload-form-container").css("display", "block");
	});
});