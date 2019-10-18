<?php
/**
 *
 * Moderated topic suffixes. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Robin Freund, https:/www.nockiro.de
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace nockiro\modissuesuffix\migrations;

class install_sample_data extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->config->offsetExists('nockiro_modissuesuffix_gitlabURL');
	}

	public static function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

	/**
	 * Add, update or delete data stored in the database during extension installation.
	 *
	 * https://area51.phpbb.com/docs/dev/3.2.x/migrations/data_changes.html
	 *  config.add: Add config data.
	 *  config.update: Update config data.
	 *  config.remove: Remove config.
	 *  config_text.add: Add config_text data.
	 *  config_text.update: Update config_text data.
	 *  config_text.remove: Remove config_text.
	 *  module.add: Add a new CP module.
	 *  module.remove: Remove a CP module.
	 *  permission.add: Add a new permission.
	 *  permission.remove: Remove a permission.
	 *  permission.role_add: Add a new permission role.
	 *  permission.role_update: Update a permission role.
	 *  permission.role_remove: Remove a permission role.
	 *  permission.permission_set: Set a permission to Yes or Never.
	 *  permission.permission_unset: Set a permission to No.
	 *  custom: Run a callable function to perform more complex operations.
	 *
	 * @return array Array of data update instructions
	 */
	public function update_data()
	{
		return array(
			// Add a new config_text table setting
			array('config.add', array('nockiro_modissuesuffix_gitlabURL', '')),

			// Add new permissions
			array('permission.add', array('a_modissuesuffix_viewIssue')), // New admin permission

			// Set our new permissions
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'a_modissuesuffix_viewIssue')), // Give ROLE_ADMIN_FULL a_new_nockiro_modissuesuffix permission
		);
	}	
	
}
