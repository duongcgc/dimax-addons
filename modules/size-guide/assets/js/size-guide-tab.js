jQuery( document ).ready( function( $ ) {
	$( '.dimax-size-guide-tabs' ).on( 'click', '.dimax-size-guide-tabs__nav li', function() {
        var $tab = $( this ),
            index = $tab.data( 'target' ),
            $panels = $tab.closest( '.dimax-size-guide-tabs' ).find( '.dimax-size-guide-tabs__panels' ),
            $panel = $panels.find( '.dimax-size-guide-tabs__panel[data-panel="' + index + '"]' );

        if ( $tab.hasClass( 'active' ) ) {
            return;
        }

        $tab.addClass( 'active' ).siblings( 'li.active' ).removeClass( 'active' );

        if ( $panel.length ) {
            $panel.addClass( 'active' ).siblings( '.dimax-size-guide-tabs__panel.active' ).removeClass( 'active' );
        }
    } );
} );