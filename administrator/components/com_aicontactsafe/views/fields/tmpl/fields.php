<?php
/**
 * @version     $Id$ 2.0.0 0
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 * 
 * Modified by NVYush on 03.2014
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<?php 
	// header of the adminForm
	// don't remove this line
	echo $this->getTmplHeader();
?>

<div style="display: block;">
	<div style="display: inline-block;">
		<input type="text" name="filter_string" id="filter_string" value="<?php echo $this->filter_string;?>" class="text_area" onchange="document.adminForm.submit();" title="<?php echo JText::_('COM_AICONTACTSAFE_FILTER_BY_NAME');?>"/>
	</div>
	<div style="display: inline-block;">
		<button class="btn" onclick="this.form.submit();"><?php echo JText::_('COM_AICONTACTSAFE_GO'); ?></button>
		<button class="btn" onclick="document.getElementById('filter_string').value='';document.getElementById('filter_order').value='';document.getElementById('filter_order_Dir').value='';this.form.submit();"><?php echo JText::_('COM_AICONTACTSAFE_RESET'); ?></button>
	</div>
</div>

<table class="table table-striped">
<thead>
	<tr>
		<th width="1%" class="nowrap center">
			<?php echo JHtml::_('grid.checkall'); ?>
		</th>
		<th width="15%" class="left">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_NAME'), 'name', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th class="left">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_FIELD_LABEL'), 'field_label', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="5%" class="center">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_TO_RIGHT'), 'label_after_field', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="15%" class="left">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_FIELD_TYPE'), 'field_type', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="5%" class="center">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_FIELD_REQUIRED'), 'field_required', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="5%" class="center">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_PUBLISHED'), 'published', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="10%" class="center">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_DATE_ADDED'), 'date_added', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="10%" class="center">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_LAST_UPDATE'), 'last_update', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="1%" class="center">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_ID'), 'id', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
	</tr>
</thead>
<tfoot>
	<tr>
		<td colspan="10">
			<?php echo $this->pageNav->getListFooter(); ?>
		</td>
	</tr>
</tfoot>
<tbody>
	<?php
	if (count($this->rows) == 0) {
	?>
		<tr><td colspan="10" id="no_record">
			<?php echo JText::_('COM_AICONTACTSAFE_NO_RECORD_FOUND'); ?>
		</td></tr>
	<?php
	} else {
		foreach ($this->rows as $i => $row) {
			$checked = JHtml::_('grid.id', $i, $row->id, false, 'cid');
			if ($row->published) {
				$img = JUri::root().'administrator/components/com_aicontactsafe/images/ok.gif';
				$alt = JText::_('COM_AICONTACTSAFE_PUBLISHED');
			} else {
				$img = JUri::root().'administrator/components/com_aicontactsafe/images/not_ok.gif';
				$alt = JText::_('COM_AICONTACTSAFE_UNPUBLISHED');
			}
			if ($row->field_required) {
				$img_required = JUri::root().'administrator/components/com_aicontactsafe/images/required.gif';
				$alt_required = JText::_('COM_AICONTACTSAFE_REQUIRED');
			} else {
				$img_required = JUri::root().'administrator/components/com_aicontactsafe/images/blank.gif';
				$alt_required = '';
			}
			if ($row->label_after_field) {
				$img_to_right = JUri::root().'administrator/components/com_aicontactsafe/images/ok.gif';
				$alt_to_right = JText::_('COM_AICONTACTSAFE_TO_RIGHT');
			} else {
				$img_to_right = JUri::root().'administrator/components/com_aicontactsafe/images/blank.gif';
				$alt_to_right = '';
			}
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo $checked; ?>
				</td>
				<td>
					<a href="<?php echo $row->edit; ?>" class="aicontactsafe_edit"><?php echo $row->name; ?></a>
				</td>
				<td>
					<?php echo $row->field_label; ?>
				</td>
				<td class="center">
					<img src="<?php echo $img_to_right;?>" style="width:16; height:16; border-width:0;" alt="<?php echo $alt_to_right; ?>" />
				</td>
				<td>
					<?php echo $row->field_type_text; ?>
				</td>
				<td class="center">
					<img src="<?php echo $img_required;?>" style="width:16; height:16; border-width:0;" alt="<?php echo $alt_required; ?>" />
				</td>
				<td class="center">
					<span class="editlinktip hasTip" title="<?php echo JText::_('COM_AICONTACTSAFE_PUBLISH_INFORMATION');?>">
						<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $row->published ? 'unpublish' : 'publish' ?>')">
							<img src="<?php echo $img;?>" style="width:16; height:16; border-width:0" alt="<?php echo $alt; ?>" />
						</a>
					</span>
				</td>
				<td class="center nowrap">
					<?php echo JHtml::_('date',  $row->date_added, $this->_config_values['date_format'] ); ?>
				</td>
				<td class="center nowrap">
					<?php echo JHtml::_('date',  $row->last_update, $this->_config_values['date_format'] ); ?>
				</td>
				<td class="center">
					<?php echo $row->id; ?>
				</td>
			</tr>
			<?php
		}
	}
	?>
</tbody>
</table>

<?php 
	// footer of the adminForm
	// don't remove this line
	echo $this->getTmplFooter();
?>
