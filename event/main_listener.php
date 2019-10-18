<?php
/**
 *
 * Moderated topic suffixes. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Robin Freund, https:/www.nockiro.de
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace nockiro\modissuesuffix\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Moderated topic suffixes Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	public static function getSubscribedEvents()
	{
		return array(
			'core.permissions'							=> 'setup_permissions',
			'core.user_setup'							=> 'load_language_on_setup',
			'marttiphpbb.topicsuffixtags'	=> 				'marttiphpbb_topicsuffixtags',
			
			'core.posting_modify_template_vars'		=> 'topic_modify_template_var',
			'core.posting_modify_submission_errors'		=> 'topic_issue_add_to_post_data',
			'core.posting_modify_submit_post_before'		=> 'topic_issue_add',
			'core.submit_post_modify_sql_data'		=> 'submit_post_modify_sql_data'
		);
	}

	/* @var \phpbb\language\language */
	protected $language;
	/* @var \phpbb\auth */
	protected $auth;
	/* @var \phpbb\config\config */
	protected $config;
	/** @var \phpbb\request\request */
	protected $request;
	/** @var \phpbb\template\template */
	protected $template;

	/**
	 * Constructor
	 *
	 * @param \phpbb\language\language	$language	Language object
	 */
	public function __construct(\phpbb\language\language $language, \phpbb\auth\auth $auth, \phpbb\config\config $config,
			\phpbb\request\request $request,
			\phpbb\template\template $template)
	{
		$this->language = $language;
		$this->auth = $auth;
		$this->config = $config;
		$this->request = $request;
		$this->template = $template;
	}
	
	/**
	 * Load common language files during user setup
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function setup_permissions($event)
	{
		$permissions = $event['permissions'];
		$permissions['a_modissuesuffix_viewIssue'] = array('lang' => 'ACL_A_MODISSUESUFFIX_VIEWISSUE');
		$event['permissions'] = $permissions;
	}
	
	/**
	 * Load common language files during user setup
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'nockiro/modissuesuffix',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	
	/** Showing tags **/
	
	public function marttiphpbb_topicsuffixtags($event)
	{
		$tags = $event['tags'];
		if ($this->auth->acl_get("a_modissuesuffix_viewIssue")) {
			$issueid = $event['topic_data']['linked_issue_id'];
			if ($issueid != 0)
				$tags[] = '<span style="color: gray; font-size: 1.05em;">[<a style="color: gray" href="' . $this->config["nockiro_modissuesuffix_gitlabURL"] . $issueid .'">#' . $issueid . '</a>]</span>';
		}
		$event['tags'] = $tags;
	}
	
	/** Allowing to write tags **/
	

	public function topic_modify_template_var($event)
	{
		$mode = $event['mode'];
		$post_data = $event['post_data'];
		
		$page_data = $event['page_data'];		
				
		if ($this->auth->acl_get("a_modissuesuffix_viewIssue") && ($mode == 'post' || ($mode == 'edit' && $post_data['topic_first_post_id'] == $post_data['post_id'])))
		{			
			// first: check if there is an id in the post buffer
			$post_data['linked_issue_id'] = (!empty($post_data['linked_issue_id'])) ? $post_data['linked_issue_id'] : '';
			
			// then: if there was nothing in the post buffer, check if the post has data yet
			/*if (empty($post_data['topic_issue'])) {
				$post_data['topic_issue'] = (!empty( $event['topic_data']['linked_issue_id'] )) ? $event['topic_data']['linked_issue_id'] : '';
			}*/
			
			$page_data['TOPIC_ISSUE'] = $post_data['linked_issue_id'];//$this->request->variable('topic_issue', $post_data['topic_issue'], true);
			$page_data['S_ISSUE_TOPIC'] = true;
		}

		$event['page_data']	= $page_data;
	}

	public function topic_issue_add_to_post_data($event)
	{
		if ($this->auth->acl_get('a_modissuesuffix_viewIssue'))
		{
			$event['post_data'] = array_merge($event['post_data'], array(
				'topic_issue'	=> $this->request->variable('topic_issue', '', true),
			));
		}
	}
	
	public function topic_issue_add($event)
	{
		$event['data'] = array_merge($event['data'], array(
			'topic_issue'	=> $event['post_data']['topic_issue'],
		));
	}

	public function submit_post_modify_sql_data($event)
	{
		$mode = $event['post_mode'];
		$topic_issue = $event['data']['topic_issue'];		
		
		if (empty($event['data']['topic_issue']))
			$topic_issue = 0;
		
		$data_sql = $event['sql_data'];
		if (in_array($mode, array('post', 'edit_topic', 'edit_first_post')))
		{
			$data_sql[TOPICS_TABLE]['sql']['linked_issue_id'] = $topic_issue;
		}
		$event['sql_data'] = $data_sql;
	}
}
