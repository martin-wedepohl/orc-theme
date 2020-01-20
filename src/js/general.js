( function ( $ ) {
	'use strict';
	
	jQuery(document).ready(function() {

        // Open privacy page in a new window
		$('a.privacy-policy-link').click(function(e) {
			e.preventDefault();
			var url = $(this).attr('href');
			window.open(url, '_blank');
		});
        
        // Display title of image below image in Post Grid
        $('a.vc_gitem-link.vc-zone-link').each(function() {
            var thetitle = $(this).attr('title');
            $(this).parents('.vc_grid-item').append('<figure><figcaption class="aligncenter">' + thetitle + '</figcaption></figure>');
        });
        

   }); // End (document).ready
	
}( jQuery ));