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
	private bool $display_at;
	private bool $display_at_pos;
	private int  $num_disp_topics;

	public function __construct
	(
		protected \phpbb\user $user,
		protected \phpbb\config\config $config,
		protected \phpbb\template\template $template,
		protected \phpbb\db\driver\driver_interface $db,
		protected \phpbb\request\request_interface $request,
		protected \phpbb\pagination $pagination,
		protected \phpbb\language\language $language,
		protected string $root_path,
		protected string $php_ext,
	)
	{
		$this->show_parent		= false;
		$this->display_at		= false;
		$this->display_at_pos	= false;
		$this->num_disp_topics	= 0;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'core.generate_forum_nav'		 	=> 'get_forum_data',
			'core.viewforum_get_topic_ids_data'	=> 'viewforum_get_topic_ids_data',
			'core.viewforum_modify_topics_data'	=> 'viewforum_modify_topics_data',
			'core.viewforum_modify_topicrow' 	=> 'set_template_vars_topic_row',
		];
	}

	/**
	 * Checking if active topics are enabled and set variables
	 */
	public function get_forum_data(object $event): void
	{
		$forum_data = $event['forum_data'];

		// Display active topics?
		$this->display_at = $forum_data['forum_type'] == FORUM_CAT && ($forum_data['forum_flags'] & FORUM_FLAG_ACTIVE_TOPICS);

		if ($this->display_at)
		{
			$this->show_parent	  = $forum_data['imcger_at_show_forum_parents'];
			$this->display_at_pos = $forum_data['imcger_display_active_position'];
		}
	}

	/**
	 * Settings for SQL queries and pagination
	 */
	public function viewforum_get_topic_ids_data(object $event): void
	{
		if ($this->display_at)
		{
			// Count topics
			$sql_count_ary = $event['sql_ary'];
			$sql_count_ary['SELECT'] = 'COUNT(t.topic_id) as num_topics';

			$sql = $this->db->sql_build_query('SELECT', $sql_count_ary);
			$this->db->sql_query($sql);

			$num_topics		 = (int) $this->db->sql_fetchfield('num_topics');
			$num_pages		 = $event['forum_data']['imcger_at_num_pages'];
			$topics_per_page = $event['forum_data']['forum_topics_per_page'] ?: $this->config['topics_per_page'];
			$topics_start	 = $this->request->variable('imc_at_start', 0);
			$topics_start	 = $this->validate_start($topics_start, $topics_per_page, $num_topics);
			$num_disp_topics = min($num_pages * $topics_per_page, $num_topics);

			// Set a query with a start and limit
			$event['sql_start'] = $topics_start;
			$event['sql_limit'] = $topics_per_page;

			// Get URL-parameters for pagination
			parse_str($this->user->page['query_string'], $append_params);
			unset($append_params['imc_at_start']);

			$pagination_url = append_sid($this->root_path . $this->user->page['page_name'], $append_params);
			$this->pagination->generate_template_pagination($pagination_url, 'pagination',
				'imc_at_start', $num_disp_topics, $topics_per_page, $topics_start);

			$this->num_disp_topics = $num_disp_topics > $topics_per_page ? $num_disp_topics : 0;
		}
	}

	/**
	 * Set template variable
	 */
	public function viewforum_modify_topics_data(): void
	{
		if ($this->display_at)
		{
			$this->template->assign_vars([
				'IMCGER_AT_DISPLAY_POS' => $this->display_at_pos,
				'TOTAL_TOPICS'			=> $this->num_disp_topics ? $this->language->lang('VIEW_FORUM_TOPICS', (int) $this->num_disp_topics) : '',
				'S_DISPLAY_SEARCHBOX'	=> false,
				'U_MARK_TOPICS'			=> '',
			]);
		}
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

	public function validate_start(int $start, int $per_page, int $num_items): int
	{
		$start = $start >= $num_items ? $num_items - 1 : $start;
		$start = intdiv($start, $per_page) * $per_page;
		$start = max(0, $start);

		return $start;
	}
}
