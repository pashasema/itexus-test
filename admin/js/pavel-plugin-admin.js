(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 $(function() {
	 	$('.pavel-plugin_form').submit(function(event) {
	 		event.preventDefault();
	 		let data = {
	 			"action": "pavel_plugin_ajax",
	 			"url": $('.pavel-plugin_input').val(),
	 		}
	 		$.ajax({
	 			type: "POST",
	 			url: "/wp-admin/admin-ajax.php",
	 			data: data
	 		}).done(function (result) {
	 			$('.pavel-plugin_output').empty();
	 			$('.pavel-plugin_output').append(result);
	 		});
	 	})
	 });

	})( jQuery );
