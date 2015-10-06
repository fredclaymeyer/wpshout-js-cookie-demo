(function ($) {

	$(document).ready(function() {
		var faveText = "Your current favorite food is ";
		var noFaveText = "You haven't yet told us your favorite food!";
		var faveTyped = '';
		var cookieName = 'favorite_food';
		var fave = '';

		$( '.current-favorite' ).html( fave );

		/* Return if no cookies */
		if( ! cookie.enabled() ) {
			$( '.favorite-food-form' ).html( "Your system doesn't accept cookies! :|" );
			return;
		} 

		/* Ajax request to get current cookie despite caching */
		$.post(
			ajaxUrl.url, 
			{
				'action': 'wpshout_get_fave_food_cookie',
				'cookie': cookieName,
			}, 
			function( response ) {
				console.log( response );
				fave = response;
				if( typeof( fave ) === 'undefined' ) {
					$( '.current-favorite' ).html( noFaveText );
				} else {
					$( '.current-favorite' ).html( faveText + fave );
				}
			}
		);

		/* Track form changes */
		$( '.favorite-food-input' ).on( "input", function() {
			faveTyped =  $( this ).val();
			if( faveTyped != '' ) {
				$( '.favorite-food-submit' ).removeAttr( 'disabled' );
			} else {
				$( '.favorite-food-submit' ).attr( 'disabled', 'disabled' );
			}
		});

		/* Update favorite food through form */
		$( '.favorite-food-submit' ).click(function() {
			cookie.remove( cookieName );

			cookie.set( cookieName, faveTyped, {
			   expires: 999, // Expires in 999 days
			   path: '/',
			});
			
			fave = cookie.get( cookieName );
			$( '.current-favorite' ).html( faveText + fave );
		});
	});


}(jQuery));