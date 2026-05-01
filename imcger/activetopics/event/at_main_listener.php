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
	private bool $show_parent;

	public function __construct
	(
		protected \phpbb\template\template $template,
		protected \phpbb\db\driver\driver_interface $db,
		protected string $root_path,
		protected string $php_ext,
	)
	{
		$this->show_parent = false;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'core.viewforum_modify_topicrow' => 'set_template_vars_topic_row',
			'core.generate_forum_nav'		 => 'get_forum_data',
		];
	}

	/**
	 * Get forum vars
	 */
	public function get_forum_data(object $event): void
	{
		$this->show_parent = $event['forum_data']['imcger_at_show_forum_parents'];

		$this->template->assign_vars([
			'IMCGER_DISPLAY_ACTIVE_POSITION' => (bool) $event['forum_data']['imcger_display_active_position'],
		]);
	}

	/**
	 * Set template vars for parent forums in topic row
	 */
	public function set_template_vars_topic_row(object $event): void
	{
		if ($this->show_parent)
		{
			$topic_row		= $event['topic_row'];
			$links_forum	= [];
			$topic_forum_id	= $topic_row['FORUM_ID'];

			$sql_array = [
				'SELECT'    => 'f.forum_name, f.forum_id',
				'FROM'      => [FORUMS_TABLE => 'f'],
				'LEFT_JOIN' => [
					[
						'FROM' => [FORUMS_TABLE => 'ft'],
						'ON'   => 'ft.forum_id = ' . (int) $topic_forum_id,
					],
				],
				'WHERE'     => 'f.forum_id = ' . (int) $topic_forum_id . '
						OR f.left_id < ft.left_id
						AND f.right_id > ft.right_id',
				'ORDER_BY'  => 'f.left_id ASC',
			];

			$sql    = $this->db->sql_build_query('SELECT', $sql_array);
			$result = $this->db->sql_query($sql);
			$forums	= $this->db->sql_fetchrowset($result);
			$this->db->sql_freeresult($result);

			foreach ($forums as $forum)
			{
				$u_view_forum = append_sid("{$this->root_path}viewforum.{$this->php_ext}", 'f=' . $forum['forum_id']);
				$links_forum  = array_merge($links_forum, ['<a href="' . $u_view_forum . '">' . $forum['forum_name'] . '</a>']);
			}

			$topic_row['IMCGER_AT_FORUM_PARENTS'] = join(' &raquo; ', $links_forum);
			$event['topic_row'] = $topic_row;
		}
	}
}
