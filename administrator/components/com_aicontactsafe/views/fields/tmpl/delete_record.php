<?php
/**
 * @version     $Id$ 2.0.0 0
 * @package     Joomla
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 */
 * 
 * Modified by NVYush on 03.2014
// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<?php 
	// header of the adminForm
	// don't remove this line
	echo $this->getTmplHeader();
?>

<fieldset class="adminform">
	<legend><?php echo JText::_('COM_AICONTACTSAFE_DELETE_FIELD'); ?></legend>
	<table id="type">
	<?php
		foreach($this->rows as $i => $row) {
			$checked = JHtml::_('grid.id', $i, $row->id, false, 'cid');
	?>
		<tr>
			<td style="width:1; text-align:center;"><?php echo $checked; ?></td>
			<td style="text-align:left;"><?php echo $row->name; ?></td>
		</tr>
	<?php
		}
	?>
	</table>
</fieldset>
	
<?php 
	// footer of the adminForm
	// don't remove this line
	echo $this->getTmplFooter();
?>
