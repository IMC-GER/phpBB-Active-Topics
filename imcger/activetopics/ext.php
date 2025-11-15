<?php
/**
 * Active Topics
 * An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023, Thorsten Ahlers
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace imcger\activetopics;

class ext extends \phpbb\extension\base
{
	public function is_enableable()
	{
		if (phpbb_version_compare(PHPBB_VERSION, '3.3.0', '<'))
		{
			return false;
		}

		$ext_requirements = new \imcger\activetopics\core\ext_requirements($this->extension_name);

		return $ext_requirements->check();
	}
}
