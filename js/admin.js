"use strict";
window.addEventListener('load', function load(){
	// Cette ligne permet la 'supression' de l'event de load pour liberer du cache 
	//(on devrait faire ça idéalement pour tous les events utilisés une seule fois) 
	window.removeEventListener('load', load, false);
	dom.init();
	rechercheMedia.init();
});
var dom = {
	init: function(){
		this.setEventLabel();
		if(this.getEventLabel() instanceof jQuery && this.getEventLabel().length==1 )
			this.changeEventCreationLabel();
	},
	setEventLabel: function(){
		this._eventLabel = jQuery('#wpbody-content > div.wrap > h1');
	},
	getEventLabel: function(){
		return this._eventLabel;
	},
	changeEventCreationLabel: function(){
		this.getEventLabel().text("Ajouter un nouvel Event ");
	}
}

function isElSoloJqueryInstance(el){
	if(el.length == 1 && el instanceof jQuery)
		return true;
	return false;
}

/** ACTIVATION MODALE POUR RECHERCHE MEDIA **/
var rechercheMedia ={
	init: function(){
		this.setUploadBtn();
		if(isElSoloJqueryInstance(this.getUploadBtn()))
			this.loadBtnEvent();
		else
			console.log("couldn't find upload btn");
	},
	setUploadBtn: function(){
		this._upBtn = jQuery('#upload_image_button');
	},
	getUploadBtn: function(){
		return this._upBtn;
	},
	loadBtnEvent: function(){
		this.getUploadBtn().click(function() {
			window.send_to_editor = function(html) {
				imgurl = jQuery('img',html).attr('src');
				jQuery('#upload_image').val(imgurl);
				tb_remove();
			}
			tb_show('', 'media-upload.php?post_id=1&type=image&TB_iframe=true');
			return false;
		});
	},
}