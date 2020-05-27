<?php
/**
 * @package		com_meedya
 * @copyright	Copyright (C) 2020 RJCreations. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

define('RJC_DBUG', JDEBUG && file_exists(JPATH_ROOT.'/rjcdev.php'));

// provide a general helper class for the rest of the component
JLoader::register('MeedyaHelper', JPATH_COMPONENT.'/helpers/meedya.php');

if (RJC_DBUG) {
	$cml = array(
		'text_file'=>'com_meedya.log.php',
		'text_entry_format'=>'{DATETIME}			{PRIORITY}			{MESSAGE}'
	);
	JLog::addLogger($cml, JLog::ALL, array('com_meedya'));
}

$controller = JControllerLegacy::getInstance('Meedya');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
