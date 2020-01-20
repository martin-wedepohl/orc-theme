( function ( $ ) {
	'use strict';
	
   jQuery(window).ready(function() {
      var windowWidth = jQuery(window).width();
      /*** DISABLE PARALLAX ON MOBILE ON LOAD ***/
      if(windowWidth <= 990) {
          jQuery('.vc_parallax-content-moving').each(function () {
              jQuery(this).removeClass('vc_parallax');
          });
      }
      
      /*** DISABLE PARALLAX ON MOBILE ON RESIZE ***/
      jQuery(window).on('resize', function () {
          var windowWidth = jQuery(window).width();
          /*** DISABLE PARALLAX ON MOBILE ON LOAD ***/
          if(windowWidth <= 990) {
              jQuery('.vc_parallax-content-moving').each(function () {
                  jQuery(this).removeClass('vc_parallax');
              });
          } else {
              jQuery('.vc_parallax-content-moving').each(function () {
                  jQuery(this).addClass('vc_parallax');
              });
          }
      });
      
   });

}( jQuery ));