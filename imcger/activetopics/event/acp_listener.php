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

/**
 * Event listener
 */
class acp_listener implements EventSubscriberInterface
{
	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\language\language */
	protected $language;

	/**
	 * listener constructor.
	 *
	 * @param \phpbb\request\request	$request
	 * @param \phpbb\language\language	$language
	 */
	public function __construct
	(
		\phpbb\request\request $request,
		\phpbb\language\language $language
	)
	{
		$this->request	= $request;
		$this->language	= $language;
	}

	/**
	 * Get subscribed events
	 *
	 * @return array
	 * @static
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.acp_manage_forums_request_data'	 => 'acp_manage_forums_request_data',
			'core.acp_manage_forums_initialise_data' => 'acp_manage_forums_initialise_data',
			'core.acp_manage_forums_display_form'	 => 'acp_manage_forums_display_form',
		];
	}

	/**
	 * Submit form (add/update)
	 *
	 * @param \phpbb\event\data $event The event object
	 * @return null
	 * @access public
	 */
	public function acp_manage_forums_request_data($event)
	{
		$array = $event['forum_data'];
		$array['imcger_display_active_position'] = $this->request->variable('imcger_display_active_position', 0);
		$event['forum_data'] = $array;
	}

	/**
	 * Default settings for new forums
	 *
	 * @param \phpbb\event\data $event The event object
	 * @return null
	 * @access public
	 */
	public function acp_manage_forums_initialise_data($event)
	{
		if ($event['action'] == 'add')
		{
			$array = $event['forum_data'];
			$array['imcger_display_active_position'] = '0';
			$event['forum_data'] = $array;
		}
	}

	/**
	 * ACP forums template output
	 *
	 * @param \phpbb\event\data $event The event object
	 * @return null
	 * @access public
	 */
	public function acp_manage_forums_display_form($event)
	{
		$this->language->add_lang('common', 'imcger/activetopics');

		$array = $event['template_data'];
		$array['IMCGER_DISPLAY_ACTIVE_POSITION'] = $event['forum_data']['imcger_display_active_position'];
		$event['template_data'] = $array;
	}
}
