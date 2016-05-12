<?php
/**
 * @version     $Id$ 2.0.1 0
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 *
 * added/fixed in version 2.0.1
 * - added link to whois.domaintools.com to see more informations about the sender's IP
 * 
 * Modified by NVYush on 03.2014
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

echo '<div id="aicontactsafe_toolbar">' . $this->toolbar . '</div><br style="clear:all;" />';
?>

<?php 
	// header of the adminForm
	// don't remove this line
	echo $this->getTmplHeader();
?>

<h3><?php echo JText::_('COM_AICONTACTSAFE_MESSAGES'); ?></h3>
<div style="display: block;">
	<div style="display: inline-block;">
		<?php echo JText::_('COM_AICONTACTSAFE_NAME'); ?>
		<input type="text" name="filter_string" id="filter_string" value="<?php echo $this->escape($this->filter_string); ?>" class="text_area" onchange="document.adminForm.submit();" title="<?php echo JText::_('COM_AICONTACTSAFE_FILTER_BY_NAME');?>"/>
	</div>
	<div style="display: inline-block;">
		<?php echo JText::_('COM_AICONTACTSAFE_EMAIL'); ?>
		<input type="text" name="filter_email" id="filter_email" value="<?php echo $this->escape($this->filter_email); ?>" class="text_area" onchange="document.adminForm.submit();" title="<?php echo JText::_('COM_AICONTACTSAFE_FILTER_BY_EMAIL');?>"/>
	</div>
	<div style="display: inline-block;">
		<?php echo JText::_('COM_AICONTACTSAFE_SUBJECT'); ?>
		<input type="text" name="filter_subject" id="filter_subject" value="<?php echo $this->escape($this->filter_subject); ?>" class="text_area" onchange="document.adminForm.submit();" title="<?php echo JText::_('COM_AICONTACTSAFE_FILTER_BY_SUBJECT');?>"/>
	</div>
	<div style="display: inline-block;">
		<?php echo JText::_('COM_AICONTACTSAFE_PROFILE'); ?>
		<?php echo $this->filter_profile; ?>
	</div>
	<div style="display: inline-block;">
		<?php echo JText::_('COM_AICONTACTSAFE_STATUS'); ?>
		<?php echo $this->filter_status; ?>
	</div>
	<div style="display: inline-block;">
		<button class="btn" onclick="this.form.submit();"><?php echo JText::_('COM_AICONTACTSAFE_GO'); ?></button>
		<button class="btn" onclick="document.getElementById('filter_string').value='';document.getElementById('filter_email').value='';document.getElementById('filter_subject').value='';document.getElementById('filter_profile').value='0';document.getElementById('filter_status').value='<?php echo $this->escape($this->_config_values['default_status_filter']); ?>';document.getElementById('filter_order').value='';document.getElementById('filter_order_Dir').value='';this.form.submit();"><?php echo JText::_('COM_AICONTACTSAFE_RESET'); ?></button>
	</div>
</div>

<table class="table table-striped">
<thead>
	<tr>
		<th width="1%" class="nowrap center">
			<?php echo JHtml::_('grid.checkall'); ?>
		</th>
		<th width="10%" class="left">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_NAME'), 'name', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="5%" class="nowrap center">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_EMAIL'), 'email', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th class="nowrap center">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_SUBJECT'), 'subject', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="5%" class="nowrap center">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_PROFILE'), 'profile', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="3%" class="nowrap center">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_STATUS'), 'status', @$this->filter_order_Dir, @$this->filter_order ); ?>
		</th>
		<th width="10%" class="nowrap center">
			<?php echo JHtml::_('grid.sort', JText::_('COM_AICONTACTSAFE_DATE_ADDED'), 'date_added', @$this->filter_order_Dir, @$this->filter_order ); ?>
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
		if ($this->_config_values['activate_ip_ban']) {
			// get the array with banned ips
			$ips_banned = explode(';',$this->_config_values['ban_ips']);
			$img_banned = JUri::root().'administrator/components/com_aicontactsafe/images/ip_banned.gif';
		}
		foreach ($this->rows as $i => $row) {
			$checked = JHtml::_('grid.id', $i, $row->id, false, 'cid');
			?>
			<tr class="row<?php echo $i % 2; ?>" style="color:<?php echo $row->color; ?>;">
				<td class="center">
					<?php echo $checked; ?>
				</td>
				<td>
					<a href="<?php echo $row->view; ?>" class="aicontactsafe_edit"><?php echo $row->name; ?></a>
				</td>
				<td class="center">
					<?php echo $row->email; ?>
				</td>
				<td>
					<?php echo $row->subject; ?>
				</td>
				<td class="center">
					<?php echo $row->profile; ?>
				</td>
				<td class="center">
					<?php echo $row->status; ?>
				</td>
				<td class="center">
					<?php echo JHtml::_('date',  $row->date_added, $this->_config_values['date_format'] ); ?>
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
