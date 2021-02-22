<?php
/**
 * @package		com_meedya
 * @copyright	Copyright (C) 2021 RJCreations. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */
defined('JPATH_BASE') or die;

use Joomla\CMS\HTML\HTMLHelper;

$data = $displayData;

// Load the form filters
$filters = $data['view']->filterForm->getGroup('filter');
?>
<?php if ($filters) : ?>
	<?php foreach ($filters as $fieldName => $field) : ?>
		<?php if ($fieldName !== 'filter_search') : ?>
			<?php $dataShowOn = ''; ?>
			<?php if ($field->showon) : ?>
				<?php HTMLHelper::_('jquery.framework'); ?>
				<?php HTMLHelper::_('script', 'jui/cms.js', array('version' => 'auto', 'relative' => true)); ?>
				<?php $dataShowOn = " data-showon='" . json_encode(FormHelper::parseShowOnConditions($field->showon, $field->formControl, $field->group)) . "'"; ?>
			<?php endif; ?>
			<div class="js-stools-field-filter"<?php echo $dataShowOn; ?>>
				<?php echo $field->input; ?>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
