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
		// If phpBB version 3.2 or less cancel
		if (phpbb_version_compare(PHPBB_VERSION, '3.3.0', '<'))
		{
			return false;
		}

		$ext_manager = $this->container->get('ext.manager');
		$language	 = $this->container->get('language');
		$language->add_lang('info_acp_activetopics', 'imcger/activetopics');

		// Check php and phpBB extension requirments
		$ext_requirements = new \imcger\numberofunrdposts\core\imcger_ext_requirements($ext_manager, $language, $this->extension_name);

		return $ext_requirements->check();
	}
}
