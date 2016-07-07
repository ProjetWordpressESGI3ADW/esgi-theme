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

/** SCRIPTS POUR LA PAGE D'OPTIONS **/
jQuery(document).ready(function() {
	jQuery('#Brgb').click(function(){
		
		var txt = document.getElementById('backgroundRGB');
		if(txt == null){
			jQuery('#Brgb').after('<input type="text" id="backgroundRGB" name="background" style="display:none">')
		}

		if(jQuery('#backgroundRGB').css('display') == "none"){
			jQuery('#backgroundRGB').css('display', 'inline');
		}
	})

	jQuery('.Bradio').on('click', function(){
		var txt = document.getElementById('backgroundRGB');
		if(txt != null){
			jQuery('#backgroundRGB').remove();
		}
	})

	
	jQuery('#Trgb').click(function(){
		var txt = document.getElementById('textRGB');
		if(txt == null){
			jQuery('#Trgb').after('<input type="text" id="textRGB" name="text_color" style="display:none">')
		}

		if(jQuery('#textRGB').css('display') == "none"){
			jQuery('#textRGB').css('display', 'inline');
		}
	})

	jQuery('.Tradio').on('click', function(){
		var txt = document.getElementById('textRGB');
		if(txt != null){
			jQuery('#textRGB').remove();
		}
	})

	jQuery('#Argb').click(function(){
		var txt = document.getElementById('ARGB');
		if(txt == null){
			jQuery('#Argb').after('<input type="text" id="ARGB" name="a_color" style="display:none">')
		}


		if(jQuery('#ARGB').css('display') == "none"){
			jQuery('#ARGB').css('display', 'inline');
		}
	})

	jQuery('.Aradio').on('click', function(){
		var txt = document.getElementById('ARGB');
		if(txt != null){
			jQuery('#ARGB').remove();
		}
	})

	jQuery('#Ahrgb').click(function(){
		var txt = document.getElementById('AHRGB');
		if(txt == null){
			jQuery('#Ahrgb').after('<input type="text" id="AHRGB" name="ahover_color" style="display:none">')
		}

		if(jQuery('#AHRGB').css('display') == "none"){
			jQuery('#AHRGB').css('display', 'inline');
		}
	})

	jQuery('.Ahoveradio').on('click', function(){
		var txt = document.getElementById('AHRGB');
		if(txt != null){
			jQuery('#AHRGB').remove();
		}
	})

	jQuery('#H2rgb').click(function(){
		var txt = document.getElementById('H2RGB');
		if(txt == null){
			jQuery('#H2rgb').after('<input type="text" id="H2RGB" name="h2_color" style="display:none">')
		}

		if(jQuery('#H2RGB').css('display') == "none"){
			jQuery('#H2RGB').css('display', 'inline');
		}
	})

	jQuery('.h2radio').on('click', function(){
		var txt = document.getElementById('H2RGB');
		if(txt != null){
			jQuery('#H2RGB').remove();
		}
	})
	
});

/*edit.php?post_type=event*/