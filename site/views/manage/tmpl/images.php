<?php
/**
 * @package		com_meedya
 * @copyright	Copyright (C) 2017 Ron Crans. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');
JHtml::_('bootstrap.framework');
$jdoc = JFactory::getDocument();
$jdoc->addStyleSheet('components/com_meedya/static/vendor/blb/basicLightbox.min.css');
$jdoc->addStyleSheet('components/com_meedya/static/css/gallery.css'.$this->bgt);
$jdoc->addStyleSheet('components/com_meedya/static/css/manage.css'.$this->bgt);
$jdoc->addScript('components/com_meedya/static/js/manage.js'.$this->bgt);
$jdoc->addScript('components/com_meedya/static/vendor/blb/basicLightbox.min.js');

function dateF ($dt)
{
	if (!$dt) return '';
	return date('M j, Y, g:i a', strtotime($dt));
}

?>
<script>
function editImg (iid) {
	window.location = "<?=JRoute::_('index.php?option=com_meedya')?>?task=manage.imgEdit&items="+iid;
}
</script>
<style>
.mitem, .litem {width:120px; height:120px;}
.mitem {/*border:1px dashed transparent;*/}
.litem {cursor:pointer;}
.islct {border-color:blue;}
/* icons and buttons */
.action-icon {
	font-size: larger;
	margin-right: 0.5em;
}
.action-icon.acticon {
	color: rgba(51,51,51,1);
}
.action-icon.inaicon {
	color: rgba(51,51,51,0.5);
/*	cursor: pointer;*/
}
</style>
<div class="meedya-gallery">
	<?php if ($this->manage) echo JHtml::_('meedya.manageMenu', 1); ?>
	<?php echo JHtml::_('meedya.pageHeader', $this->params, $this->action.'XXXX'); ?>
	<form action="index.php?option=com_meedya&Itemid=<?php echo $this->itemId; ?>" method="post" name="adminForm" id="adminForm">
		<?php
			if ($this->mode == 'G') {
				echo '<a href="'.$this->linkUrl.'&mode=L"><span class="icon-list-2 action-icon inaicon" title="List View"> </span></a>';
				echo '<span class="icon-grid-2 action-icon acticon" title="Grid View"> </span>';
			} else {
				echo '<span class="icon-list-2 action-icon acticon" title="List View"> </span>';
				echo '<a href="'.$this->linkUrl.'&mode=G"><span class="icon-grid-2 action-icon inaicon" title="Grid View"> </span></a>';
			}
		?>
		<?php //echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>
		<?php $fOpts = array('filterButton' => true); ?>
		<?php echo JLayoutHelper::render('search', array('view' => $this, 'options' => $fOpts), JPATH_ROOT.'/components/com_meedya/layouts'); ?>
		<div class="actbuts">
		<!--	<button class="btn btn-mini" title="select all images" onclick="selAllImg(event, true)">Select All</button>
			<button class="btn btn-mini" title="un-select all images" onclick="selAllImg(event, false)">Select None</button>
			<button class="btn btn-mini" title="edit selected images" onclick="editSelected(event)"><i class="icon-pencil"></i> Edit selected items</button>
			<button class="btn btn-mini" title="new album with selected items" onclick="addSelected(event)"><i class="icon-plus-circle"></i> Create new album with selected items</button>
			<button class="btn btn-mini" title="totally remove selected items" onclick="removeSelected(event)"><i class="icon-minus-circle"></i> Totally remove selected items</button> -->
			<?php echo JHtml::_('meedya.actionButtons', array('sela','seln','edts','adds','dels')); ?>
		</div>
		<?php echo $this->loadTemplate($this->mode == 'G' ? 'grid' : 'list'); ?>
		<input type="hidden" name="task" value="manage.editImgs" />
		<input type="hidden" name="mode" value="<?=$this->mode?>" />
	</form>
</div>
<div class="page-footer">
	<?php echo $this->pagination->getListFooter(); ?>
</div>
<script>
jQuery('#system-message-container').delay(5000).slideUp("slow");
var blb_path = "<?=JUri::root(true).'/'.$this->gallpath?>/med/";
echo.init({
	baseUrl: "<?=JUri::root(true).'/'.$this->gallpath?>/",
	offset: 200,
	throttle: 250,
	debounce: false
});
</script>