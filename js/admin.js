"use strict";
window.addEventListener('load', function load(){
	// Cette ligne permet la 'supression' de l'event de load pour liberer du cache 
	//(on devrait faire ça idéalement pour tous les events utilisés une seule fois) 
	window.removeEventListener('load', load, false);
	dom.init();
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
