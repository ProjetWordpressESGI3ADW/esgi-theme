"use strict";

var menu = {	
	init : function(){		
		menu.setOpenNavbarSide();
		menu.toggle();
	},

	/**
	*	Setter
	*/
	setOpenNavbarSide : function(){
		this._openNavbarSide = jQuery('#open-navbar-side-menu');
	},

	/**
	*	Getter
	*/	
	getOpenNavbarSide : function(){
		return this._openNavbarSide;
	},
	toggle : function(){				
		menu.getOpenNavbarSide().on('click', function(){				
			console.log("test");
		});
	}
};


menu.init();
