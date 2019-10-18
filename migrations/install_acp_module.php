<?php
/**
 *
 * Moderated topic suffixes. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Robin Freund, https://www.nockiro.de
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace nockiro\modissuesuffix\migrations;

class install_acp_module extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

	public function update_data()
	{
		return array(
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_MODISSUESUFFIX_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_MODISSUESUFFIX_TITLE',
				array(
					'module_basename'	=> '\nockiro\modissuesuffix\acp\main_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
