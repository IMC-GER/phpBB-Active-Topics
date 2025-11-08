<?php
/**
 * Active Topics
 * An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023, Thorsten Ahlers
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ »« „“ ” …
//

$lang = array_merge($lang, [
	'IMCGER_AT_REQUIRE_PHP'		=> 'Yours php Version is %1$s. Version %2$s is required.',
	'IMCGER_AT_REQUIRE_PHPBB'	=> 'Yours phpBB Version is %1$s. Version %2$s is required.',

	'IMCGER_AT_TOPICS_PER_PAGE'				=> 'Active topics per page',
	'IMCGER_AT_POSITION'					=> 'Display active topics above',
	'IMCGER_AT_POSITION_EXPLAIN'			=> 'If this setting is set to "Yes", active topics of the selected sub-forums are displayed on the page above this category.',
	'IMCGER_AT_SHOW_FORUM_PARENTS'			=> 'Display parent forums',
	'IMCGER_AT_SHOW_FORUM_PARENTS_EXPLAIN'	=> 'Display parent forums inside the topic row of active topics.',
]);
