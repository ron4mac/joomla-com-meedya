<?php
/**
 * @package		com_meedya
 * @copyright	Copyright (C) 2019 Ron Crans. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

echo '<div id="imglist">
';

foreach ($this->iids as $item) {
	//echo'<xmp>';var_dump($item);echo'</xmp>';
	echo '<div class="lstItem row-fluid">';
	echo JHtml::_('meedya.imageThumbElement', $item, false, 'item span2');
//	echo "\n".'<img src="components/com_meedya/static/img/img.png" data-echo="thm/'.$item->file
//		.'" data-img="'.$item->file
//		.'" class="litem" onclick="return lboxImg(event, this)" />';
//	echo '<div class="span2">'.$item->title.'</div>';
//	echo '<div class="span2">'.$item->desc.'</div>';
	echo '<div class="span6">'.$item->title.'<br />'.$item->desc.'</div>';
//	echo '<div class="span2">'.$item->album.'</div>';
	echo '<div class="span2">'.dateF($item->timed).'</div>';
	echo '<div class="span2">'.dateF($item->expodt).'</div>';
	echo '</div>';
}

echo '</div>
';
