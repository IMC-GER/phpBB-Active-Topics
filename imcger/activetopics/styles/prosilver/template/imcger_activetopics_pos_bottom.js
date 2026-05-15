/**
 * Active Topics
 * An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023, Thorsten Ahlers
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

(function($) {  // Avoid conflicts with other libraries

	'use strict';

	// Move the pagination to bottom of the active topics list
	if ($('.forumbg dt#active_topics').length) {
		$('.forumbg').first().after($('.action-bar.bar-top'));
	}
})(jQuery); // Avoid conflicts with other libraries
