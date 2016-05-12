<?php
/**
 * @version     $Id$ 2.0.7 0
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 *
 * added/fixed in version 2.0.13
 * - added link to download any attachment in the "Attachmenets" window
 * 
 * Modified by NVYush on 03.2014
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<?php 
	// import joomla clases to manage file system
	jimport('joomla.filesystem.file');

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
		<th width="12%" class="nowrap left">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_FILE'), 'name', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="12%" class="nowrap left">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_NAME'), 'ms_name', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="10%" class="nowrap center">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_EMAIL'), 'ms_email', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th class="nowrap left">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_SUBJECT'), 'ms_subject', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="5%" class="nowrap center">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_SENDERS_IP'), 'ms_sender_ip', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="5%" class="nowrap center">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_STATUS'), 'recorded_text', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="15%" class="nowrap center">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_DATE_ADDED'), 'date_added', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="1%" class="nowrap center">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_ID'), 'id', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
	</tr>
</thead>
<tfoot>
	<tr>
		<td colspan="9">
			<?php echo $this->pageNav->getListFooter(); ?>
		</td>
	</tr>
</tfoot>
<tbody>
	<?php
	if (count($this->rows) == 0) {
	?>
		<tr><td colspan="9" id="no_record">
			<?php echo JText::_('COM_AICONTACTSAFE_NO_RECORD_FOUND'); ?>
		</td></tr>
	<?php
	} else {
		foreach ($this->rows as $i => $row) {
			$checked = JHtml::_('grid.id', $i, $row->id, false, 'cid');
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo $checked; ?><input type="hidden" id="file_<?php echo (int)$row->id; ?>" name="file_<?php echo (int)$row->id; ?>" value="<?php echo htmlspecialchars($row->name); ?>" />
				</td>
				<td>
					<?php
						echo JFile::exists($this->path_upload.DIRECTORY_SEPARATOR.$row->name) ?
							'<a href="'.JUri::base().'index.php?option=com_aicontactsafe&sTask=attachments&task=download&file='.$row->name.'&format=raw" target="_blank" class="attachments_download">'.$row->name.'</a>' :
							$row->name;
					?>
				</td>
				<td>
					<?php echo $row->ms_name; ?>
				</td>
				<td>
					<?php echo $row->ms_email; ?>
				</td>
				<td>
					<?php echo $row->ms_subject; ?>
				</td>
				<td class="center">
					<a class="aiContactSafe" href="http://whois.domaintools.com/<?php echo $row->ms_sender_ip; ?>" target="_blank"><?php echo $row->ms_sender_ip; ?></a>
				</td>
				<td class="center">
					<?php echo $row->recorded_text; ?>
				</td>
				<td class="center">
					<?php echo JHtml::_('date',  $row->date_added, $this->_config_values['date_format'] ); ?>
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
