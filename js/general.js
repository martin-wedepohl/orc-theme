( function ( $ ) {
	'use strict';
	
	jQuery(document).ready(function() {

		$('a.privacy-policy-link').click(function(e) {
			e.preventDefault();
			var url = $(this).attr('href');
			window.open(url, '_blank');
		});

   }); // End (document).ready
	
}( jQuery ));