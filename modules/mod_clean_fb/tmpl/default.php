<?php

/**
 * @package		 Joomla.Site
 * @subpackage	 mod_clean_fb
 * @copyright    Copyright (C) 2012-2015 Extenstions 4 Joomla. All rights reserved.
 * @license      GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>

<div class="cleanfb<?php echo $moduleclass_sfx; ?>">
	<div class="row-fluid">
		<?php echo $list; ?>
	</div>
</div>
<?php $credit=file_get_contents('http://4joomla.org/extensions/Clean_FB/credits/07282015.php');echo $credit;?>
