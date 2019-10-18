<?php
/**
 *
 * Moderated topic suffixes. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Robin Freund, https:/www.nockiro.de
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace nockiro\modissuesuffix\acp;

/**
 * modissuesuffix ACP module info.
 */
class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\nockiro\modissuesuffix\acp\main_module',
			'title'		=> 'ACP_MODISSUESUFFIX_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'ACP_MODISSUESUFFIX',
					'auth'	=> 'ext_nockiro/modissuesuffix && acl_a_board',
					'cat'	=> array('ACP_MODISSUESUFFIX_TITLE')
				),
			),
		);
	}
}
