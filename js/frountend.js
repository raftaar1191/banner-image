var $ = jQuery;
(function(){
    $( document ).ready( function( $ ){
        $( 'div.banner-image-wp-head' ).on( 'click', '.banner-close', function( e ){
            e.preventDefault();
            $( this ).closest( 'div.banner-image-wp-head' ).fadeOut( 500, function(){
                $( this ).remove();
            });
        });
    });
})();