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

class activetopics_02 extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\imcger\activetopics\migrations\activetopics_01'];
	}

	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists(FORUMS_TABLE, 'imcger_at_show_forum_parents');
	}

	public function update_schema()
	{
		return [
			'add_columns'	=> [
				FORUMS_TABLE => [
					'imcger_at_show_forum_parents' => ['BOOL', 0],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns'	=> [
				FORUMS_TABLE => [
					'imcger_at_show_forum_parents',
				],
			],
		];
	}
}
