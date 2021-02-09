<?php

/*
 * Author: Juergen Schwind
 * Copyright: Juergen Schwind
 * Link: http://oswframe.com
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details:
 * http://www.gnu.org/licenses/gpl.html
 *
 */

$links=$this->getSendElementOption($ddm_group, $element, 'data');
$links_anz=0;
if(is_array($links)) {
	$links_anz=count($links);
}

?>

<?php if($links_anz>0):?>
<ul class="nav nav-tabs ddm_element_<?php echo $this->getViewElementValue($ddm_group, $element, 'id')?>">
<?php $i=0;foreach($links as $link_id => $__link):$i++;?>
<?php
if (isset($__link['navigation_id'])) {
	$link_id=$__link['navigation_id'];
}
?>
	<li <?php if($this->getParameter($ddm_group, 'ddm_navigation_id')==$link_id):?> class="active"<?php endif?>><a<?php echo (((isset($__link['target']))) ? ' target="'.$__link['target'].'"' : '');?> href="<?php echo osW_Template::getInstance()->buildhrefLink(((($__link['module'])) ? $__link['module'] : $this->getDirectModule($ddm_group)), 'ddm_navigation_id='.$link_id.((($__link['parameter'])) ? '&'.$__link['parameter'] : ''))?>"><?php echo ((($__link['text'])) ? h()->_outputString($__link['text']) : 'undefined')?></a></li>
<?php endforeach?>
</ul>
<div class="clearfix"><br/></div>
<?php endif?>