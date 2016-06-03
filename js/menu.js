"use strict";

jQuery( document ).ready(function() {
	menu.init();
});

var menu = {	
	init : function(){				
		/**
		*	Setter
		*/
		menu.setOpenNavbarSide();
		menu.setNavbarSide();
		menu.setNavbarSideCollapse();

		/**
		*	Functions
		*/
		menu.toggle();
	},

	/**
	*	Setter
	*/
	setOpenNavbarSide : function(){
		this._openNavbarSide = jQuery('#open-navbar-side-menu');
	},

	setNavbarSide : function(){
		this._navbarSide = jQuery('.navbar-side-menu');
	},

	setNavbarSideCollapse : function(){
		this._navbarSideCollapse = jQuery('.navbar-side-menu.navbar-side-menu-collapse');
	},

	/**
	*	Getter
	*/	
	getOpenNavbarSide : function(){
		return this._openNavbarSide;
	},

	getNavbarSide : function(){
		return this._navbarSide;
	},

	getNavbarSideCollapse : function(){
		return this._navbarSideCollapse;
	},

	/**
	*	Functions
	*/
	toggle : function(){	
		menu.getOpenNavbarSide().on('click', function(){									
            if(menu.getNavbarSide().hasClass('navbar-side-menu-collapse'))
                menu.getNavbarSide().removeClass('navbar-side-menu-collapse');
            else
                menu.getNavbarSide().addClass('navbar-side-menu-collapse');                
		});
	}
};


