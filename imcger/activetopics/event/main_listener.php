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
class main_listener implements EventSubscriberInterface
{
	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var int forum_id */
	protected $forum_id;

	/** @var string phpbb_root_path */
	protected $phpbb_root_path;

	/** @var string phpEx */
	protected $php_ext;

	/**
	 * listener constructor.
	 *
	 * @param \phpbb\template\template			$template
	 * @param \phpbb\db\driver\driver_interface $db
	 * @param string							$php_ext
	 */
	public function __construct
	(
		\phpbb\template\template $template,
		\phpbb\db\driver\driver_interface $db,
		$root_path,
		$php_ext
	)
	{
		$this->template			= $template;
		$this->db				= $db;
		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
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
			'core.viewforum_modify_page_title'	=> 'set_template_vars',
			'core.viewforum_modify_topicrow'	=> 'set_template_vars_forum_name',
		];
	}

	/**
	 * Set template vars
	 *
	 * @return null
	 * @access public
	 */
	public function set_template_vars($event)
	{
		$this->forum_id = $event['forum_id'];

		$sql = 'SELECT imcger_display_active_position FROM ' . FORUMS_TABLE . '
				WHERE forum_id = ' . (int) $this->forum_id;

		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$this->template->assign_vars([
			'IMCGER_DISPLAY_ACTIVE_POSITION' => (int) $row['imcger_display_active_position'],
		]);
	}

	/**
	 * Set template vars
	 *
	 * @return null
	 * @access public
	 */
	public function set_template_vars_forum_name($event)
	{
		$topic_row		 = $event['topic_row'];
		$links_forum	 = '';
		$topic_forum_id	 = $topic_row['FORUM_ID'];

		do
		{
			$sql = 'SELECT forum_name, parent_id FROM ' . FORUMS_TABLE . '
					WHERE forum_id = ' . (int) $topic_forum_id;

			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			$u_view_forum = append_sid("{$this->phpbb_root_path}viewforum.$this->php_ext", 'f=' . $topic_forum_id);
			$link_forum	  = '<a href="' . $u_view_forum . '">' . $row['forum_name'] . '</a>';

			$links_forum	= strlen($links_forum) == 0 ? $link_forum : $link_forum . ' &raquo; ' . $links_forum;
			$topic_forum_id = $row['parent_id'];

		} while ($row['parent_id'] != 0 && $row['parent_id'] != $this->forum_id);

		$topic_row['IMCGER_LINKS_FORUM'] = $links_forum;
		$event['topic_row'] = $topic_row;
	}
}
