<?php
/**
 * @package		com_meedya
 * @copyright	Copyright (C) 2017 Ron Crans. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/*
 * This is a base view class to (hopefully) avoid duplication of code needed by all views
 */

// provide all views with a JHtml helper class
JLoader::register('JHtmlMeedya', JPATH_COMPONENT . '/helpers/html/meedya.php');

class MeedyaView extends JViewLegacy
{
	protected $state;
	protected $items = null;
	protected $params;
	protected $meedyaID;
	protected $gallpath;
	protected $pagination;
	protected $btmscript = [];	// accumulate here any scripts that will render at the bottom of content
	protected $bgt = '';	// set to time if debug; added to js/css urls to prevent caching

	public function __construct ($config = array())
	{
		if (RJC_DBUG) {
			MeedyaHelper::log('MeedyaView');
			$this->bgt = '?'.time();
		}
		parent::__construct($config);
		$this->params = JFactory::getApplication()->getParams();
//		$this->state = $this->get('State');
		$this->meedyaID = MeedyaHelper::getInstanceID();
		$this->gallpath = MeedyaHelper::userDataPath();
//		$this->pagination = $this->get('Pagination');
	}

	public function display ($tpl = null)
	{
		if (RJC_DBUG) { MeedyaHelper::log('MeedyaView - display'); }
//		$this->params = JFactory::getApplication()->getParams();
//		$this->state = $this->get('State');
//		$this->items = $this->get('Items');
	//	if (is_null($this->items)) $this->items = $this->getModel()->getItems();
		$this->pagination = $this->get('Pagination');

	//	echo'GOt here';var_dump($this->pagination,$this->items);jexit();
//		$jdoc = JFactory::getDocument();
//		$jdoc->addScript('components/com_meedya/static/js/'.MeedyaHelper::scriptVersion('echo'));
		MeedyaHelper::addScript('echo');
	//	JHtml::_('jquery.framework', false);
	//	$jdoc->addScript('components/com_meedya/static/js/jqUnveil.js');
		parent::display($tpl);
		if ($this->btmscript) echo "<script type=\"text/javascript\">\n".implode("\n", $this->btmscript)."\n</script>";
	}

	protected function getAlbumThumb ($albrec)
	{
		$pics = $albrec->items ? explode('|', $albrec->items) : array();
		if (!$albrec->thumb) {
			$albrec->thumb = $pics ? $this->getItemThumb($pics[0]) : false;
		}
		if ($albrec->thumb) {
			$thum = $this->gallpath.'/thm/'.$albrec->thumb;
		} else {
			$thum = 'components/com_meedya/static/img/noimages.jpg';
		}
		return $thum;
	}

	protected function getItemThumb ($iid)
	{
		$m = $this->getModel();
		return $m->getItemThumbFile($iid);
	}

	protected function getItemThumbPlus ($iid)
	{
		$m = $this->getModel();
		return $m->getItemThumbFilePlus($iid);
	}

	protected function getItemFile ($iid)
	{
		$m = $this->getModel();
		return $m->getItemFile($iid);
	}

}