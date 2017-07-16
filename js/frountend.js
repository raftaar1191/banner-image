var $ = jQuery;
var class_add = false;
(function(){
    $( document ).ready( function( $ ){
        $( 'div.banner-image-wp-head' ).on( 'click', '.banner-close', function( e ){
            e.preventDefault();
            $( this ).closest( 'div.banner-image-wp-head' ).fadeOut( 500, function(){
                $( this ).remove();
            });
        });

        $( document ).scroll( function() {
            if( false === class_add ) {
                $( 'div.banner-image-wp-head' ).addClass( 'banner-image-fixed' );
                class_add = true;
            }
        });
    });
})();