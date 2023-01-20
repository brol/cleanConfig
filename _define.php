<?php 
/**
 * @brief cleanConfig, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugin
 *
 * @author Moe, Pierre Van Glabeke and contributors
 *
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Icon (icon.png) and images are from Silk Icons :
 * <http://www.famfamfam.com/lab/icons/silk/>
 */
if (!defined('DC_RC_PATH')) {return;}

$this->registerModule(
	/* Name        */		"clean:config",
	/* Description */		"Delete the blog settings or global settings",
	/* Author      */		"Moe (http://gniark.net/), Pierre Van Glabeke",
	/* Version     */		"1.4.7-dev",
	/* Properties */
	array(
		'permissions' => null,
		'type' => 'plugin',
		'requires' => [['core', '2.24']],
		'support' => 'http://lab.dotclear.org/wiki/plugin/cleanConfig',
		'details' => 'http://plugins.dotaddict.org/dc2/details/cleanConfig'
		)
);