<?php
/**
 * @package		com_meedya
 * @copyright	Copyright (C) 2017 Ron Crans. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JLoader::register('MeedyaHelper', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/meedya.php');
//JLoader::register('JHtmlMeedya', JPATH_COMPONENT . '/helpers/html/meedya.php');

class MeedyaController extends JControllerLegacy
{
	protected $uid = 0;

	public function __construct ($config = array())
	{
		if (JDEBUG) {
			JLog::add('MeedyaController', JLog::DEBUG, 'com_meedya');
		}
		parent::__construct($config);
		$this->uid = JFactory::getUser()->get('id');
	}

	public function display ($cachable = false, $urlparams = false)
	{
		if ($this->uid && !file_exists(MeedyaHelper::userDataPath())) {
			$this->input->set('layout', 'startup');
		}
		return parent::display($cachable, $urlparams);
	}

	public function begin ()
	{
		if (!$this->uid) return;
		$htm = '<!DOCTYPE html><title></title>';
		$udp = MeedyaHelper::userDataPath();
		mkdir($udp.'/img', 0777, true);
		mkdir($udp.'/thm', 0777, true);
		mkdir($udp.'/med', 0777, true);
		file_put_contents($udp.'/index.html', $htm);
		file_put_contents($udp.'/img/index.html', $htm);
		file_put_contents($udp.'/thm/index.html', $htm);
		file_put_contents($udp.'/med/index.html', $htm);
		$this->setRedirect(JRoute::_('index.php?option=com_meedya', false));
	}

}