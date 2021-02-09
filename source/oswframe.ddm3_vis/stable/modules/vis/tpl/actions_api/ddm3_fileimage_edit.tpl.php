<ul class="ddm3_popup_list">
	<li>
		<div class="ddm3_popup_header">
			<div class="left">
				Bild bearbeiten
			</div>
			<div class="right ddm3_popup_header_slider_block">
				<div class="ddm3_popup_header_slider"></div>
				<span class="ddm3_popup_header_slider_value"></span>
			</div>
			<div class="ddm3_popup_header_navigation">
				<ul class="ddm3_popup_header_navigation_list">
					<li class="ddm3_popup_header_100">100%</li>
					<li class="ddm3_popup_header_fit">Fenster</li>
				</ul>
			</div>
		</div>
	</li>
	<li>
		<div class="ddm3_popup_navigation">
			<ul class="ddm3_popup_navigation_list ddm3_popup_navigation_list_overview">
				<li class="ddm3_popup_navigation_resize">Resize</li>
				<li class="ddm3_popup_navigation_crop">Crop</li>
				<li class="ddm3_popup_navigation_save">Speichern</li>
				<li class="ddm3_popup_navigation_close">Schließen</li>
			</ul>
			<ul class="ddm3_popup_navigation_list ddm3_popup_navigation_list_resize" style="display:none;">
				<li class="ddm3_popup_navigation_back">«</li>
				<li class="ddm3_popup_navigation_option">Breite/Höhe: <input type="text" id="width" size="5"/> x
					<input id="height" size="5"/></li>
				<li class="ddm3_popup_navigation_option">
					<input type="checkbox" id="aspect"/> Seitenverhältnis beibehalten
				</li>
				<li class="ddm3_popup_navigation_save">Speichern</li>
				<li class="ddm3_popup_navigation_reset">Verwerfen</li>
			</ul>
			<ul class="ddm3_popup_navigation_list ddm3_popup_navigation_list_crop" style="display:none;">
				<li class="ddm3_popup_navigation_back">«</li>
				<li class="ddm3_popup_navigation_option">X/Y: <input type="text" id="crop_x" size="5"/> x
					<input id="crop_y" size="5"/>
					<hidden id="_crop_x"/>
					<hidden id="_crop_y"/>
				</li>
				<li class="ddm3_popup_navigation_option">Breite/Höhe: <input type="text" id="crop_w" size="5"/> x
					<input id="crop_h" size="5"/>
					<hidden id="_crop_w"/>
					<hidden id="_crop_h"/>
				</li>
				<li class="ddm3_popup_navigation_save">Speichern</li>
				<li class="ddm3_popup_navigation_reset">Verwerfen</li>
			</ul>
		</div>
	</li>
	<li>
		<div class="ddm3_popup_content">
			<div class="ddm3_popup_content_image">
				<img alt="loading" src="<?php echo osW_Template::getInstance()->buildhrefLink('current', 'vistool='.osW_VIS::getInstance()->getTool().'&vispage=vis_api&action=ddm3_fileimage&ddm_element='.$element_data['ddm_group'].'_'.$element_data['ddm_element']) ?>"/>
			</div>
		</div>
	</li>
</ul>