<?php
/**
 * Active Topics
 * An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023, Thorsten Ahlers
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace imcger\activetopics\migrations;

class activetopics_04 extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\imcger\activetopics\migrations\activetopics_03'];
	}

	public function update_schema()
	{
		return [
			'change_columns' => [
				FORUMS_TABLE => ['imcger_at_show_forum_parents' => ['TINT:2', 0],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'change_columns' => [
				FORUMS_TABLE => ['imcger_at_show_forum_parents' => ['BOOL', 0],
				],
			],
		];
	}
}
