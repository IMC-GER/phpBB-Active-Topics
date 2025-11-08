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
		protected \phpbb\language\language $language,
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
		$array = $event['forum_data'];
		$array['imcger_display_active_position'] = $this->request->variable('imcger_display_active_position', 0);
		$array['imcger_at_show_forum_parents']	 = $this->request->variable('imcger_at_show_forum_parents', 0);
		$event['forum_data'] = $array;
	}

	/**
	 * Default settings for new forums
	 */
	public function acp_manage_forums_initialise_data(object $event): void
	{
		if ($event['action'] == 'add')
		{
			$array = $event['forum_data'];
			$array['imcger_display_active_position'] = '0';
			$array['imcger_at_show_forum_parents']	 = '0';
			$event['forum_data'] = $array;
		}
	}

	/**
	 * ACP forums template output
	 */
	public function acp_manage_forums_display_form(object $event): void
	{
		$array = $event['template_data'];
		$array['IMCGER_DISPLAY_ACTIVE_POSITION'] = $event['forum_data']['imcger_display_active_position'];
		$array['IMCGER_AT_SHOW_FORUM_PARENTS'] = $event['forum_data']['imcger_at_show_forum_parents'];
		$event['template_data'] = $array;
	}
}
