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

	public function effectively_installed()
	{
		return isset($this->config['imcger_at_result_limit']);
	}

	public function update_data()
	{
		return [
			['config.add', ['imcger_at_result_limit', 7]],
		];
	}
}
