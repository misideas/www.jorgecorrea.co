<?php
/**
 * @version     $Id$ 2.0.7 0
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
		<th class="nowrap left">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_NAME'), 'name', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="10%" class="nowrap center">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_COLOR'), 'color', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="10%" class="nowrap">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_ORDERING'), 'ordering', @$this->filter_order_Dir, @$this->filter_order ); ?>
			<?php echo JHtml::_('grid.order',  $this->rows ); ?>
		</th>
		<th width="15%" class="nowrap center">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_DATE_ADDED'), 'date_added', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="15%" class="nowrap center">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_LAST_UPDATE'), 'last_update', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="1%" class="nowrap center">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_ID'), 'id', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
	</tr>
</thead>
<tfoot>
	<tr>
		<td colspan="7">
			<?php echo $this->pageNav->getListFooter(); ?>
		</td>
	</tr>
</tfoot>
<tbody>
	<?php
	if (count($this->rows) == 0) {
	?>
		<tr><td colspan="7" id="no_record">
			<?php echo JText::_('COM_AICONTACTSAFE_NO_RECORD_FOUND'); ?>
		</td></tr>
	<?php
	} else {
		$n = count($this->rows);
		
		foreach ($this->rows as $i => $row) {
			$checked = JHtml::_('grid.id', $i, $row->id, false, 'cid');
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo $checked; ?>
				</td>
				<td>
					<a href="<?php echo $row->edit; ?>" class="aicontactsafe_edit"><?php echo $row->name; ?></a>
				</td>
				<td class="center">
					<span style="color:<?php echo $row->color; ?>"><?php echo $row->color; ?></span>
				</td>
				<td class="left">
					<span><?php echo $this->pageNav->orderUpIcon( $i, true, 'orderup', JText::_('COM_AICONTACTSAFE_MOVE_UP'), true ); ?></span>
					<span><?php echo $this->pageNav->orderDownIcon( $i, $n, true, 'orderdown', JText::_('COM_AICONTACTSAFE_MOVE_DOWN'), true );?></span>
					<input class="text-area-order input-mini" type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>"  />
				</td>
				<td class="center">
					<?php echo JHtml::_('date',  $row->date_added, $this->_config_values['date_format'] ); ?>
				</td>
				<td class="center">
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
