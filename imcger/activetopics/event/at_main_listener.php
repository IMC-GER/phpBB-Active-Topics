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

class at_main_listener implements EventSubscriberInterface
{
	private int  $forum_id;
	private bool $show_parent;

	public function __construct
	(
		protected \phpbb\template\template $template,
		protected \phpbb\db\driver\driver_interface $db,
		protected string $phpbb_root_path,
		protected string $php_ext,
	)
	{
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'core.viewforum_modify_topicrow'	=> 'set_template_vars_forum_name',
			'core.generate_forum_nav'			=> 'get_forum_data',
		];
	}

	/**
	 * Get forum vars
	 */
	public function get_forum_data(object $event): void
	{
		$this->forum_id		= $event['forum_data']['forum_id'];
		$this->show_parent	= $event['forum_data']['imcger_at_show_forum_parents'];

		$this->template->assign_vars([
			'IMCGER_DISPLAY_ACTIVE_POSITION' => (bool) $event['forum_data']['imcger_display_active_position'],
		]);
	}

	/**
	 * Set template vars
	 */
	public function set_template_vars_forum_name(object $event): void
	{
		if (!$this->show_parent)
		{
			return;
		}

		$topic_row		 = $event['topic_row'];
		$links_forum	 = '';
		$topic_forum_id	 = $topic_row['FORUM_ID'];

		do
		{
			$sql = 'SELECT forum_name, parent_id
					FROM ' . FORUMS_TABLE . '
					WHERE forum_id = ' . (int) $topic_forum_id;

			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			$u_view_forum = append_sid("{$this->phpbb_root_path}viewforum.{$this->php_ext}", 'f=' . $topic_forum_id);
			$link_forum	  = '<a href="' . $u_view_forum . '">' . $row['forum_name'] . '</a>';

			$links_forum	= strlen($links_forum) == 0 ? $link_forum : $link_forum . ' &raquo; ' . $links_forum;
			$topic_forum_id = $row['parent_id'];

		} while ($row['parent_id'] != 0 && $row['parent_id'] != $this->forum_id);

		$topic_row['IMCGER_AT_FORUM_PARENTS'] = $links_forum;
		$event['topic_row'] = $topic_row;
	}
}
