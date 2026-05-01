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

	// Move active topics to the top of forumlist
	if ($('.forumbg dt#active_topics').length) {
		$('.forabg').first().before($('.forumbg'));
	}
})(jQuery); // Avoid conflicts with other libraries
