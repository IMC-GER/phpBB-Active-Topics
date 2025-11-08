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
		global $phpEx, $phpbb_root_path;

		if (phpbb_version_compare(PHPBB_VERSION, '3.2.0', '<'))
		{
			return false;
		}

		$language		= $this->container->get('language');
		$ext_manager	= $this->container->get('ext.manager');
		$metadata		= $ext_manager->create_extension_metadata_manager($this->extension_name)->get_metadata();
		$error_message	= [];

		$name = explode('/', $this->extension_name)[1];
		$language->add_lang('info_acp_' . $name, $this->extension_name);

		$require_php	= explode(',', $metadata['require']['php']);
		$require_phpbb	= explode(',', $metadata['require']['phpbb/phpbb'] ?? $metadata['extra']['soft-require']['phpbb/phpbb']);

		foreach ($require_php as $value)
		{
			$required = $this->split_compare_data(htmlspecialchars_decode($value, ENT_QUOTES || ENT_SUBSTITUTE || ENT_HTML5));

			if (!phpbb_version_compare(PHP_VERSION, $required['version'], $required['operator']))
			{
				$error_message[] = $language->lang('IMCGER_AT_REQUIRE_PHP', PHP_VERSION, $metadata['require']['php']);
			}
		}

		foreach ($require_phpbb as $value)
		{
			$required = $this->split_compare_data(htmlspecialchars_decode($value, ENT_QUOTES || ENT_SUBSTITUTE || ENT_HTML5));

			if (!phpbb_version_compare(PHPBB_VERSION, $required['version'], $required['operator']))
			{
				$error_message[] = $language->lang('IMCGER_AT_REQUIRE_PHPBB', PHPBB_VERSION, $metadata['require']['phpbb/phpbb']);
			}
		}

		/* When phpBB v3.2 use trigger_error() for message output. */
		if (phpbb_version_compare(PHPBB_VERSION, '3.3.0', '<') && !empty($error_message))
		{
			$message = implode('<br>', $error_message);
			trigger_error($message . adm_back_link(append_sid("{$phpbb_root_path}adm/index.{$phpEx}", 'i=acp_extensions&mode=main')), E_USER_WARNING);
			return false;
		}

		return $error_message ?: true;
	}

	protected function split_compare_data(string $string): array
	{
		$pattern = '#(<=|>=|==|!=|<>|<|>|=|lt|le|gt|ge|eq|ne)\s*([0-9][0-9a-z\.\-\@]*)#';
		$matches = [];
		$string	 = str_replace('@', '-', $string);

		if (!preg_match($pattern, $string, $matches))
		{
			return [];
		}

		$data = [];
		$data['version']  = $matches[2];
		$data['operator'] = $matches[1];

		return $data;
	}
}
