<?php
/**
 * Active Topics
 * An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023, Thorsten Ahlers
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace imcger\activetopics\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class at_acp_listener implements EventSubscriberInterface
{
	public function __construct
	(
		protected \phpbb\request\request $request,
	)
	{
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'core.acp_manage_forums_request_data'	 => 'acp_manage_forums_request_data',
			'core.acp_manage_forums_initialise_data' => 'acp_manage_forums_initialise_data',
			'core.acp_manage_forums_display_form'	 => 'acp_manage_forums_display_form',
		];
	}

	/**
	 * Submit form (add/update)
	 */
	public function acp_manage_forums_request_data(object $event): void
	{
		$forum_data = $event['forum_data'];
		$forum_data['imcger_display_active_position'] = $this->request->variable('imcger_display_active_position', false);
		$forum_data['imcger_at_num_pages']			  = max(1, min(9999, $this->request->variable('imcger_at_num_pages', 1)));
		$forum_data['imcger_at_show_forum_parents']	  = max(0, min(2, $this->request->variable('imcger_at_show_forum_parents', 0)));
		$event['forum_data'] = $forum_data;
	}

	/**
	 * Default settings for new forums
	 */
	public function acp_manage_forums_initialise_data(object $event): void
	{
		if ($event['action'] == 'add')
		{
			$forum_data = $event['forum_data'];
			$forum_data['imcger_display_active_position'] = '0';
			$forum_data['imcger_at_num_pages']			  = '1';
			$forum_data['imcger_at_show_forum_parents']	  = '0';
			$event['forum_data'] = $forum_data;
		}
	}

	/**
	 * ACP forums template output
	 */
	public function acp_manage_forums_display_form(object $event): void
	{
		$template_data = $event['template_data'];
		$template_data['IMCGER_AT_DISPLAY_POS']		   = $this->select_struct((int) $event['forum_data']['imcger_display_active_position'], [
			'IMCGER_AT_TOP'				=> 1,
			'IMCGER_AT_BOTTOM'			=> 0,
		]);
		$template_data['IMCGER_AT_NUM_PAGES']		   = $event['forum_data']['imcger_at_num_pages'];
		$template_data['IMCGER_AT_SHOW_FORUM_PARENTS'] = $this->select_struct((int) $event['forum_data']['imcger_at_show_forum_parents'], [
			'IMCGER_AT_NONE'			=> 0,
			'IMCGER_AT_FORUM'			=> 2,
			'IMCGER_AT_FORUM_PARENTS'	=> 1,
		]);
		$event['template_data'] = $template_data;
	}

	/**
	 * Creates an array of variables for the SelectBox macro
	 */
	public function select_struct(array|string $cfg_value, array $options): array
	{
		$options_tpl = [];

		foreach ($options as $opt_key => $opt_value)
		{
			if (!is_array($opt_value))
			{
				$opt_value = [$opt_value];
			}
			$options_tpl[] = [
				'label'		=> $opt_key,
				'value'		=> $opt_value[0],
				'bold'		=> $opt_value[1] ?? false,
				'selected'	=> is_array($cfg_value) ? in_array($opt_value[0], $cfg_value) : $opt_value[0] == $cfg_value,
			];
		}

		return $options_tpl;
	}
}
