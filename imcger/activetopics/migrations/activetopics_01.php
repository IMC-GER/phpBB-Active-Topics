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

class activetopics_01 extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v330\v330'];
	}

	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists(FORUMS_TABLE, 'imcger_display_active_position');
	}

	public function update_schema()
	{
		return [
			'add_columns'	=> [
				FORUMS_TABLE => [
					'imcger_display_active_position' => ['UINT:2', 0],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns'	=> [
				FORUMS_TABLE => [
					'imcger_display_active_position',
				],
			],
		];
	}

	public function revert_data()
	{
		return [
			['custom', [[$this, 'reset_topics_per_page']]],
		];
	}

	public function reset_topics_per_page()
	{
		$sql = 'UPDATE ' . FORUMS_TABLE . '
				SET forum_topics_per_page = 0
				WHERE forum_type = ' . FORUM_CAT;
		$this->db->sql_query($sql);
	}
}
