/*global redux_change, redux*/

(function( $ ) {
    "use strict";

    redux.field_objects = redux.field_objects || {};
    redux.field_objects.select_image = redux.field_objects.select_image || {};

    $( document ).ready(
        function() {
            //redux.field_objects.select_image.init();
        }
    );

    redux.field_objects.select_image.init = function( selector ) {

        if ( !selector ) {
            selector = $( document ).find( ".redux-group-tab:visible" ).find( '.redux-container-select_image:visible' );
        }

        $( selector ).each(
            function() {
                var el = $( this );
                var parent = el;
                if ( !el.hasClass( 'redux-field-container' ) ) {
                    parent = el.parents( '.redux-field-container:first' );
                }
                if ( parent.is( ":hidden" ) ) { // Skip hidden fields
                    return;
                }
                if ( parent.hasClass( 'redux-field-init' ) ) {
                    parent.removeClass( 'redux-field-init' );
                } else {
                    return;
                }
                var default_params = {
                    width: 'resolve',
                    triggerChange: true,
                    allowClear: true
                };

                var select2_handle = el.find( '.redux-container-select_image' ).find( '.select2_params' );

                if ( select2_handle.size() > 0 ) {
                    var select2_params = select2_handle.val();

                    select2_params = JSON.parse( select2_params );
                    default_params = $.extend( {}, default_params, select2_params );
                }

                el.find( 'select.redux-select-images' ).select2( default_params );

                el.find( '.redux-select-images' ).on(
                    'change', function() {
                        var preview = $( this ).parents( '.redux-field:first' ).find( '.redux-preview-image' );
						
                        if(typeof $( this ).select2().find(":selected").data("demolink")!="undefined"){
                            if($( this ).select2().find(":selected").data("demolink")!=""){
                                preview.next('#theme-selected-demo-link').remove();
                                var demo = $( this ).select2().find(":selected").data("demolink");
                                preview.after('<a href="'+demo+'" id="theme-selected-demo-link" target="_blank"> Demo </a>');

                                preview.attr('onclick','return window.open(\''+demo+'\')');
                            }
                            else {
                                preview.attr('onclick','');
                                preview.next('#theme-selected-demo-link').remove();
                            }

                        }
						if(typeof $( this ).select2().find(":selected").data("image")!="undefined"){
							if($( this ).select2().find(":selected").data("image")===""){
								preview.fadeOut(
									'medium', function() {
										preview.attr( 'src', '' );
									}
								);
							}else{
								preview.attr( 'src', $( this ).select2().find(":selected").data("image") );
								preview.attr( 'alt', $( this ).select2().find(":selected").data("alt") );
								preview.fadeIn().css( 'visibility', 'visible' );
							}
						}else{
							if ( $( this ).val() === "" ) {
								preview.fadeOut(
									'medium', function() {
										preview.attr( 'src', '' );
									}
								);
							} else {
								preview.attr( 'src', $( this ).val() );
								preview.fadeIn().css( 'visibility', 'visible' );
							}
						}
                    }
                );
            }
        );
    };
})( jQuery );