(function($) {
	var stickyHeader = $( '.site-header' );
	var body = $( 'body' );
	var adminBar = esgiadminbar;
	var stickyHeaderOffset;

	if ( adminBar > 0 ) {
		stickyHeaderOffset = stickyHeader.offset().top - 32;
	} else {
		stickyHeaderOffset = stickyHeader.offset().top;
	}

	var stickyTime = function() {
		if( $(window).scrollTop() > stickyHeaderOffset ) {
			body.addClass( 'sticking' );
		} else {
			body.removeClass( 'sticking' );
		}
	}

	function linkedImages() {
		var imgs = $( '.entry-content img' );

		for ( var i = 0, imgslength = imgs.length; i < imgslength; i++ ) {
			if ( '' !== $( imgs[i] ).closest( 'a' ) ) {
				$( imgs[i] ).closest( 'a' ).addClass( 'no-line' );
			}
		}
	}

	$( window ).load( function() {
		linkedImages();
		stickyTime();
	} );

	$( window ).scroll( function() {
		stickyTime();
	} );

	$( window ).on( 'resize post-load', function() {
		linkedImages();
	} );
})(jQuery);
