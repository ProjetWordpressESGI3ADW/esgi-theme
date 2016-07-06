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
		this.setEventGlobalMenu();
		if(isElSoloJqueryInstance(this.getEventLabel()) && this.isUserOnEventPage()){
			this.changeEventCreationLabel();
			console.log("sur page event!");
		}
	},
	setEventLabel: function(){
		this._eventLabel = jQuery('#wpbody-content > div.wrap > h1');
	},
	setEventGlobalMenu: function(){
		this._globEvMenu = jQuery('#menu-posts-event');
	},
	getEventLabel: function(){
		return this._eventLabel;
	},
	getEventGlobalMenu: function(){
		return this._globEvMenu;
	},
	isUserOnEventPage: function(){
		if($_GET('post_type') == 'event') return true;
		if(this.getEventGlobalMenu().hasClass('wp-menu-open')) return true;
		return false;
	},
	changeEventCreationLabel: function(){
		console.log(this.getEventGlobalMenu().find('.wp-submenu li:last-child'));
		if(!(this.getEventGlobalMenu().find('.wp-submenu li:last-child').hasClass('current'))){
			this.getEventLabel().text("Ajouter un nouvel event ");
			jQuery('#post').attr('enctype', 'multipart/form-data');
		}
		
	}
}

function isElSoloJqueryInstance(el){
	if(el.length == 1 && el instanceof jQuery)
		return true;
	return false;
}

function $_GET(param) {
	var vars = {};
	window.location.href.replace( location.hash, '' ).replace( 
		/[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
		function( m, key, value ) { // callback
			vars[key] = value !== undefined ? value : '';
		}
	);

	if ( param ) {
		return vars[param] ? vars[param] : null;	
	}
	return vars;
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


/*edit.php?post_type=event*/