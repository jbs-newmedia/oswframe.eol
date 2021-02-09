<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

class osW_DDM3 extends osW_Object {

	// PROPERTIES

	public $ddm=[];

	// METHODS CORE

	public function __construct() {
		parent::__construct(1, 2);
	}

	public function __destruct() {
		parent::__destruct();
	}

	public function addGroup($ddm_group, $options) {
		if (isset($this->ddm[$ddm_group]['options'])) {
			return false;
		}
		if (!isset($options['messages'])) {
			$options['messages']=[];
		}
		$options['messages']=$this->loadDefaultMessages($options['messages']);
		$this->ddm[$ddm_group]['options']=$options;

		if ((!isset($this->ddm[$ddm_group]['options']['layout_loaded']))||($this->ddm[$ddm_group]['options']['layout_loaded']!==true)) {
			if (!isset($this->ddm[$ddm_group]['options']['layout'])) {
				$this->ddm[$ddm_group]['options']['layout']='default';
			}
			$this->ddm[$ddm_group]['options']['layout_loaded']=true;

			$layout='frame/ddm3/style/'.$this->ddm[$ddm_group]['options']['layout'].'/css/layout.css';
			osW_Template::getInstance()->addCSSFileHead($layout);

			foreach (glob(vOut('settings_abspath').'frame/ddm3/style/'.$this->ddm[$ddm_group]['options']['layout'].'/css/*.css') as $filename) {
				$filename=str_replace(vOut('settings_abspath'), '', $filename);
				if ($filename!=$layout) {
					osW_Template::getInstance()->addCSSFileHead($filename);
				}
			}
		}

		$this->runDefaultScript('loader/group/php/', $ddm_group.'.inc.php', $ddm_group);

		return true;
	}

	public function loadDefaultMessages($messages) {
		$default_messages=['data_options'=>'Optionen', 'form_submit'=>'Absenden', 'form_reset'=>'Zurücksetzen', 'form_cancel'=>'Abbrechen', 'data_search'=>'Suchen', 'data_add'=>'Erstellen', 'data_edit'=>'Bearbeiten', 'data_delete'=>'Löschen', 'data_log'=>'Log', 'lock_error'=>'Datensatz durch "$user$" gesperrt. Keine Änderungen möglich.', 'form_title_required_icon'=>'*', 'form_title_sort_spacer'=>' ', 'form_title_asc_icon'=>'▲', 'form_title_desc_icon'=>'▼', 'form_title_cancel_icon'=>'✖', 'form_title_pages'=>'Seiten', 'form_title_pages_single'=>'Seite', 'form_title_pages_multi'=>'Seiten', 'form_title_counter'=>'Datensätze $elements_from$ - $elements_to$ ($elements_all$ insgesamt)', 'form_title_counter_single'=>'Datensatz $elements_from$ - $elements_to$ ($elements_all$ insgesamt)', 'form_title_counter_multi'=>'Datensätze $elements_from$ - $elements_to$ ($elements_all$ insgesamt)', 'form_title_asc'=>'Aufsteigend sortieren', 'form_title_desc'=>'Absteigend sortieren', 'form_title_sortorder_delete'=>'Sortierung entfernen', 'form_title_closer'=>':', 'form_required_notice'=>'* Pflichtfeld', 'form_required_notice_multi'=>'* Pflichtfelder', 'form_error'=>'Eingabefehler', 'data_noresults'=>'Keine Elemente vorhanden', 'text_char'=>'Zeichen', 'text_chars'=>'Zeichen', 'text_all'=>'Alle', 'text_yes'=>'Ja', 'text_no'=>'Nein', 'text_action'=>'Aktion', 'text_file_view'=>'Datei anzeigen', 'text_file_delete'=>'Datei löschen', 'text_image_view'=>'Bild anzeigen', 'text_image_delete'=>'Bild löschen', 'text_clock'=>'Uhr', 'text_search'=>'Suche', 'text_filter'=>'Filter', 'text_selected'=>'Ausgewählte', 'text_notselected'=>'Nicht Ausgewählte', 'text_selectall'=>'Alle auswählen', 'text_deselectall'=>'Keins auswählen', 'text_invertselection'=>'Auswahl umkehren', 'text_all'=>'Alle', 'create_time'=>'Erstellt am', 'create_user'=>'Erstellt von', 'update_time'=>'Geändert am', 'update_user'=>'Geändert von', 'search_title'=>'Datensätze durchsuchen', 'back_title'=>'Zurück zur Übersicht', 'sortorder_title'=>'Sortierung', 'createupdate_title'=>'Datensatzinformationen', 'send_title'=>'Datensatz übermitteln', 'send_success_title'=>'Datensatz wurde erfolgreich übermittelt', 'add_title'=>'Neuen Datensatz erstellen', 'add_success_title'=>'Datensatz wurde erfolgreich erstellt', 'add_error_title'=>'Datensatz konnte nicht erstellt werden', 'edit_title'=>'Datensatz bearbeiten', 'edit_load_error_title'=>'Datensatz wurde nicht gefunden', 'edit_success_title'=>'Datensatz wurde erfolgreich bearbeitet', 'edit_error_title'=>'Datensatz konnte nicht bearbeitet werden', 'delete_title'=>'Datensatz löschen', 'delete_load_error_title'=>'Datensatz wurde nicht gefunden', 'delete_success_title'=>'Datensatz wurde erfolgreich gelöscht', 'delete_error_title'=>'Datensatz konnte nicht gelöscht werden', 'validation_element_error'=>'Fehler bei $element_title$.', 'validation_element_filtererror'=>'Filter "$filter$" bei "$element_title$" wurde nicht gefunden.', 'validation_element_incorrect'=>'Ihre Eingabe bei "$element_title$" ist nicht korrekt.', 'validation_element_toshort'=>'Ihre Eingabe bei "$element_title$" ist zu kurz.', 'validation_element_tolong'=>'Ihre Eingabe bei "$element_title$" ist zu lang.', 'validation_element_tosmall'=>'Ihre Eingabe bei "$element_title$" ist zu klein.', 'validation_element_tobig'=>'Ihre Eingabe bei "$element_title$" ist zu groß.', 'validation_element_regerror'=>'Ihre Eingabe bei "$element_title$" ist nicht korrekt.', 'validation_element_double'=>'Ihre Eingaben bei "$element_title$" stimmen nicht überein.', 'validation_element_unique'=>'Ihre Eingabe bei "$element_title$" ist bereits vorhanden.', 'validation_element_miss'=>'Ihre Eingabe bei "$element_title$" fehlt.', 'validation_file_uploaderror'=>'Die Datei bei "$element_title$" konnte nicht hochgeladen werden.', 'validation_file_typeerror'=>'Die Datei bei "$element_title$" ist vom falschen Typ.', 'validation_file_extensionerror'=>'Die Datei bei "$element_title$" hat die falsche Endung.', 'validation_file_tosmall'=>'Die Datei bei "$element_title$" ist zu klein.', 'validation_file_tobig'=>'Die Datei bei "$element_title$" ist zu groß.', 'validation_file_miss'=>'Keine Datei bei "$element_title$" hochgeladen.', 'validation_image_uploaderror'=>'Die Datei bei "$element_title$" konnte nicht hochgeladen werden.', 'validation_image_fileerror'=>'Die Datei bei "$element_title$" ist kein Bild.', 'validation_image_typeerror'=>'Die Datei bei "$element_title$" ist vom falschen Typ.', 'validation_image_extensionerror'=>'Die Datei bei "$element_title$" hat die falsche Endung.', 'validation_image_tosmall'=>'Die Datei bei "$element_title$" ist zu klein.', 'validation_image_tobig'=>'Die Datei bei "$element_title$" ist zu groß.', 'validation_imagewidth_tosmall'=>'Die Breite bei "$element_title$" ist zu klein.', 'validation_imagewidth_tobig'=>'Die Breite bei "$element_title$" ist zu groß.', 'validation_imageheight_tosmall'=>'Die Höhe bei "$element_title$" ist zu klein.', 'validation_imageheight_tobig'=>'Die Höhe bei "$element_title$" ist zu groß.', 'validation_image_miss'=>'Keine Datei bei "$element_title$" hochgeladen.', 'module_not_found'=>'Modul "$module$" in "$path$" nicht gefunden'];
		if ($messages!=[]) {
			foreach ($messages as $key=>$value) {
				$default_messages[$key]=$value;
			}
		}

		return $default_messages;
	}

	/**
	 *
	 * Setzt den Wert einer Group-Option
	 *
	 * @param string $ddm_group
	 * @param string $option
	 * @param string $value
	 * @return boolean
	 */
	public function setGroupOption($ddm_group, $option, $value, $group='general') {
		$this->ddm[$ddm_group]['options'][$group][$option]=$value;

		return true;
	}

	public function setGroupMessages($ddm_group, $values) {
		$this->ddm[$ddm_group]['options']['messages']=$values;

		return true;
	}

	/**
	 *
	 * Gibt den Wert einer Group-Option zurück, wenn nicht vorhanden liefert es '' zurück
	 *
	 * @param string $ddm_group
	 * @param string $option
	 * @return string
	 */
	public function getGroupOption($ddm_group, $option, $group='general') {
		if (isset($this->ddm[$ddm_group]['options'][$group][$option])) {
			return $this->ddm[$ddm_group]['options'][$group][$option];
		}

		return '';
	}

	public function getGroupMessage($ddm_group, $option) {
		return $this->getGroupOption($ddm_group, $option, 'messages');
	}


	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function addElement($ddm_group, $type, $element, $options) {
		if ((!isset($options['enabled']))||($options['enabled']!==true)) {
			$options['id']=$element;
			if (isset($this->ddm[$ddm_group][$type]['elements'][$element])) {
				return false;
			}
			if (!isset($this->ddm[$ddm_group]['counts'])) {
				$this->ddm[$ddm_group]['counts']=[];
			}

			if ($type=='data') {
				$_data=['list', 'search', 'add', 'edit', 'delete'];

				$default_options=$this->runDefaultScript('defaultdata/'.$options['module'].'/php/', 'content.inc.php', $ddm_group);
				$options=array_replace_recursive($default_options, $options);

				$_tmp=[];
				foreach ($_data as $_type) {
					$_tmp[$_type]=[];
					if (isset($options['_'.$_type])) {
						$_tmp[$_type]=$options['_'.$_type];
						unset($options['_'.$_type]);
					}
				}

				foreach ($_data as $_type) {
					$data=array_replace_recursive($options, $_tmp[$_type]);
					if (((!isset($data['enabled']))||($data['enabled']===true))&&($this->getGroupOption($ddm_group, 'disable_'.$_type)!==true)) {
						$this->ddm[$ddm_group]['elements'][$_type][$element]=$data;
						$this->ddm[$ddm_group]['counts'][$_type.'_elements']=count($this->ddm[$ddm_group]['elements'][$_type]);
					}
				}
			} else {
				$default_options=$this->runDefaultScript('defaultdata/'.$options['module'].'/php/', 'content.inc.php', $ddm_group);
				$options=array_replace_recursive($default_options, $options);

				if ($this->getGroupOption($ddm_group, 'disable_'.$type)!==true) {
					$this->ddm[$ddm_group]['elements'][$type][$element]=$options;
					$this->ddm[$ddm_group]['counts'][$type.'_elements']=count($this->ddm[$ddm_group]['elements'][$type]);
				}
			}

			return true;
		}

		return false;
	}

	public function addPreViewElement($ddm_group, $element, $options) {
		return $this->addElement($ddm_group, 'preview', $element, $options);
	}

	public function addViewElement($ddm_group, $element, $options) {
		return $this->addElement($ddm_group, 'view', $element, $options);
	}

	public function addDataElement($ddm_group, $element, $options) {
		return $this->addElement($ddm_group, 'data', $element, $options);
	}

	public function addSendElement($ddm_group, $element, $options) {
		return $this->addElement($ddm_group, 'send', $element, $options);
	}

	public function addFinishElement($ddm_group, $element, $options) {
		return $this->addElement($ddm_group, 'finish', $element, $options);
	}

	public function addAfterFinishElement($ddm_group, $element, $options) {
		return $this->addElement($ddm_group, 'afterfinish', $element, $options);
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function setCounter($ddm_group, $counter, $value) {
		$this->ddm[$ddm_group]['counts'][$counter]=$value;
	}

	public function incCounter($ddm_group, $counter) {
		if (!isset($this->ddm[$ddm_group]['counts'][$counter])) {
			$this->setCounter($ddm_group, $counter, 0);
		}
		$this->ddm[$ddm_group]['counts'][$counter]=$this->ddm[$ddm_group]['counts'][$counter]+1;

		return $this->getCounter($ddm_group, $counter);
	}

	public function decCounter($ddm_group, $counter) {
		if (!isset($this->ddm[$ddm_group]['counts'][$counter])) {
			$this->setCounter($ddm_group, $counter, 0);
		}
		$this->ddm[$ddm_group]['counts'][$counter]=$this->ddm[$ddm_group]['counts'][$counter]-1;

		return $this->getCounter($ddm_group, $counter);
	}

	public function getCounter($ddm_group, $counter) {
		if (isset($this->ddm[$ddm_group]['counts'][$counter])) {
			return $this->ddm[$ddm_group]['counts'][$counter];
		}

		return false;
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function getOrderElementName($ddm_group, $element) {
		if (isset($this->ddm[$ddm_group]['orderelementnames'][$element])) {
			return $this->ddm[$ddm_group]['orderelementnames'][$element];
		} else {
			return '';
		}
	}

	public function setOrderElementName($ddm_group, $element, $value) {
		$this->ddm[$ddm_group]['orderelementnames'][$element]=$value;

		return true;
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function getElements($ddm_group, $type) {
		if (isset($this->ddm[$ddm_group]['elements'][$type])) {
			return $this->ddm[$ddm_group]['elements'][$type];
		} else {
			return [];
		}
	}

	public function getPreViewElements($ddm_group) {
		return $this->getElements($ddm_group, 'preview');
	}

	public function getViewElements($ddm_group) {
		return $this->getElements($ddm_group, 'view');
	}

	public function getListElements($ddm_group) {
		return $this->getElements($ddm_group, 'list');
	}

	public function getSearchElements($ddm_group) {
		return $this->getElements($ddm_group, 'search');
	}

	public function getAddElements($ddm_group) {
		return $this->getElements($ddm_group, 'add');
	}

	public function getEditElements($ddm_group) {
		return $this->getElements($ddm_group, 'edit');
	}

	public function getDeleteElements($ddm_group) {
		return $this->getElements($ddm_group, 'delete');
	}

	public function getSendElements($ddm_group) {
		return $this->getElements($ddm_group, 'send');
	}

	public function getFinishElements($ddm_group) {
		return $this->getElements($ddm_group, 'finish');
	}

	public function getAfterFinishElements($ddm_group) {
		return $this->getElements($ddm_group, 'afterfinish');
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function getElement($ddm_group, $type, $element) {
		if ((isset($this->ddm[$ddm_group]['elements'][$type]))&&(isset($this->ddm[$ddm_group]['elements'][$type][$element]))) {
			return $this->ddm[$ddm_group]['elements'][$type][$element];
		} else {
			return [];
		}
	}

	public function getPreViewElement($ddm_group, $element) {
		return $this->getElement($ddm_group, 'preview', $element);
	}

	public function getViewElement($ddm_group, $element) {
		return $this->getElement($ddm_group, 'view', $element);
	}

	public function getListElement($ddm_group, $element) {
		return $this->getElement($ddm_group, 'list', $element);
	}

	public function getSearchElement($ddm_group, $element) {
		return $this->getElement($ddm_group, 'search', $element);
	}

	public function getAddElement($ddm_group, $element) {
		return $this->getElement($ddm_group, 'add', $element);
	}

	public function getEditElement($ddm_group, $element) {
		return $this->getElement($ddm_group, 'edit', $element);
	}

	public function getDeleteElement($ddm_group, $element) {
		return $this->getElement($ddm_group, 'delete', $element);
	}

	public function getSendElement($ddm_group, $element) {
		return $this->getElement($ddm_group, 'send', $element);
	}

	public function getFinishElement($ddm_group, $element) {
		return $this->getElement($ddm_group, 'finish', $element);
	}

	public function getAfterFinishElement($ddm_group, $element) {
		return $this->getElement($ddm_group, 'afterfinish', $element);
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function getElementsValue($ddm_group, $type, $key, $group='') {
		$ar_tmp=[];
		foreach ($this->getElements($ddm_group, $type) as $id=>$options) {
			if ($group!='') {

			} else {
				if (isset($options[$key])) {
					$ar_tmp[$id]=$options[$key];
				}
			}
		}

		return $ar_tmp;
	}

	public function getViewElementsValue($ddm_group, $key, $group='') {
		return $this->getElementsValue($ddm_group, 'view', $key, $group);
	}

	public function getListElementsValue($ddm_group, $key, $group='') {
		return $this->getElementsValue($ddm_group, 'list', $key, $group);
	}

	public function getSearchElementsValue($ddm_group, $key, $group='') {
		return $this->getElementsValue($ddm_group, 'search', $key, $group);
	}

	public function getAddElementsValue($ddm_group, $key, $group='') {
		return $this->getElementsValue($ddm_group, 'add', $key, $group);
	}

	public function getEditElementsValue($ddm_group, $key, $group='') {
		return $this->getElementsValue($ddm_group, 'edit', $key, $group);
	}

	public function getDeleteElementsValue($ddm_group, $key, $group='') {
		return $this->getElementsValue($ddm_group, 'delete', $key, $group);
	}

	public function getSendElementsValue($ddm_group, $key, $group='') {
		return $this->getElementsValue($ddm_group, 'send', $key, $group);
	}

	public function getFinishElementsValue($ddm_group, $key, $group='') {
		return $this->getElementsValue($ddm_group, 'finish', $key, $group);
	}

	public function getAfterFinishElementsValue($ddm_group, $key, $group='') {
		return $this->getElementsValue($ddm_group, 'afterfinish', $key, $group);
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function getElementsName($ddm_group, $type, $group='') {
		$ar_tmp=[];
		$key='name';
		foreach ($this->getElements($ddm_group, $type) as $id=>$options) {
			if ($group!='') {

			} else {
				if (isset($options['name'])) {
					$ar_tmp[]=$options['name'];
				}
				if (isset($options['name_array'])) {
					foreach ($options['name_array'] as $name) {
						if ($options['options']['prefix']!='') {
							$ar_tmp[]=$options['options']['prefix'].$name;
						} else {
							$ar_tmp[]=$name;
						}
					}

				}
			}
		}

		return $ar_tmp;
	}

	public function getViewElementsName($ddm_group, $group='') {
		return $this->getElementsName($ddm_group, 'view', $group);
	}

	public function getListElementsName($ddm_group, $group='') {
		return $this->getElementsName($ddm_group, 'list', $group);
	}

	public function getSearchElementsName($ddm_group, $group='') {
		return $this->getElementsName($ddm_group, 'search', $group);
	}

	public function getAddElementsName($ddm_group, $group='') {
		return $this->getElementsName($ddm_group, 'add', $group);
	}

	public function getEditElementsName($ddm_group, $group='') {
		return $this->getElementsName($ddm_group, 'edit', $group);
	}

	public function getDeleteElementsName($ddm_group, $group='') {
		return $this->getElementsName($ddm_group, 'delete', $group);
	}

	public function getSendElementsName($ddm_group, $group='') {
		return $this->getElementsName($ddm_group, 'send', $group);
	}

	public function getFinishElementsName($ddm_group, $group='') {
		return $this->getElementsName($ddm_group, 'finish', $group);
	}

	public function getAfterFinishElementsName($ddm_group, $group='') {
		return $this->getElementsName($ddm_group, 'afterfinish', $group);
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function getElementValue($ddm_group, $type, $element, $option, $group='') {
		if ($group=='') {
			if (isset($this->ddm[$ddm_group]['elements'][$type][$element][$option])) {
				return $this->ddm[$ddm_group]['elements'][$type][$element][$option];
			}
			if ($type=='view') {
				$type='preview';
				if (isset($this->ddm[$ddm_group]['elements'][$type][$element][$option])) {
					return $this->ddm[$ddm_group]['elements'][$type][$element][$option];
				}
			}
		} else {
			if (isset($this->ddm[$ddm_group]['elements'][$type][$element][$group][$option])) {
				return $this->ddm[$ddm_group]['elements'][$type][$element][$group][$option];
			}
			if ($type=='view') {
				$type='preview';
				if (isset($this->ddm[$ddm_group]['elements'][$type][$element][$group][$option])) {
					return $this->ddm[$ddm_group]['elements'][$type][$element][$group][$option];
				}
			}
		}

		return '';
	}

	public function getViewElementValue($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'view', $element, $option, '');
	}

	public function getViewElementOption($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'view', $element, $option, 'options');
	}

	public function getListElementValue($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'list', $element, $option, '');
	}

	public function getListElementOption($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'list', $element, $option, 'options');
	}

	public function getSearchElementValue($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'search', $element, $option, '');
	}

	public function getSearchElementOption($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'search', $element, $option, 'options');
	}

	public function getSearchElementValidation($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'search', $element, $option, 'validation');
	}

	public function getAddElementValue($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'add', $element, $option, '');
	}

	public function getAddElementOption($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'add', $element, $option, 'options');
	}

	public function getAddElementValidation($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'add', $element, $option, 'validation');
	}

	public function getEditElementValue($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'edit', $element, $option, '');
	}

	public function getEditElementOption($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'edit', $element, $option, 'options');
	}

	public function getEditElementValidation($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'edit', $element, $option, 'validation');
	}

	public function getDeleteElementValue($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'delete', $element, $option, '');
	}

	public function getDeleteElementOption($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'delete', $element, $option, 'options');
	}

	public function getDeleteElementValidation($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'delete', $element, $option, 'validation');
	}

	public function getSendElementValue($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'send', $element, $option, '');
	}

	public function getSendElementOption($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'send', $element, $option, 'options');
	}

	public function getSendElementValidation($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'send', $element, $option, 'validation');
	}

	public function getFinishElementValue($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'finish', $element, $option, '');
	}

	public function getFinishElementOption($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'finish', $element, $option, 'options');
	}

	public function getFinishElementValidation($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'finish', $element, $option, 'validation');
	}

	public function getAfterFinishElementValue($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'afterfinish', $element, $option, '');
	}

	public function getAfterFinishElementOption($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'afterfinish', $element, $option, 'options');
	}

	public function getAfterFinishElementValidation($ddm_group, $element, $option) {
		return $this->getElementValue($ddm_group, 'afterfinish', $element, $option, 'validation');
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function setElementValue($ddm_group, $type, $element, $option, $value, $group='') {
		if ($group=='') {
			$this->ddm[$ddm_group]['elements'][$type][$element][$option]=$value;

			return true;
		} else {
			$this->ddm[$ddm_group]['elements'][$type][$element][$group][$option]=$value;

			return true;
		}

		return false;
	}

	public function setViewElementValue($ddm_group, $element, $option, $value) {
		return $this->setElementValue($ddm_group, 'view', $element, $option, $value, '');
	}

	public function setViewElementOption($ddm_group, $element, $option, $value) {
		return $this->setElementValue($ddm_group, 'view', $element, $option, $value, 'options');
	}

	public function setListElementValue($ddm_group, $element, $option, $value) {
		return $this->setElementValue($ddm_group, 'list', $element, $option, $value, '');
	}

	public function setListElementOption($ddm_group, $element, $option, $value) {
		return $this->setElementValue($ddm_group, 'list', $element, $option, $value, 'options');
	}

	public function setSearchElementValue($ddm_group, $element, $option, $value) {
		return $this->setElementValue($ddm_group, 'search', $element, $option, $value, '');
	}

	public function setSearchElementOption($ddm_group, $element, $option, $value) {
		return $this->setElementValue($ddm_group, 'search', $element, $option, $value, 'options');
	}

	public function setSearchElementValidation($ddm_group, $element, $option, $value) {
		return $this->setElementValue($ddm_group, 'search', $element, $option, $value, 'validation');
	}

	public function setAddElementValue($ddm_group, $element, $option, $value) {
		return $this->setElementValue($ddm_group, 'add', $element, $option, $value, '');
	}

	public function setAddElementOption($ddm_group, $element, $option, $value) {
		return $this->setElementValue($ddm_group, 'add', $element, $option, $value, 'options');
	}

	public function setAddElementValidation($ddm_group, $element, $option, $value) {
		return $this->setElementValue($ddm_group, 'add', $element, $option, $value, 'validation');
	}

	public function setEditElementValue($ddm_group, $element, $option, $value) {
		return $this->setElementValue($ddm_group, 'edit', $element, $option, $value, '');
	}

	public function setEditElementOption($ddm_group, $element, $option, $value) {
		return $this->setElementValue($ddm_group, 'edit', $element, $option, $value, 'options');
	}

	public function setEditElementValidation($ddm_group, $element, $option, $value) {
		return $this->setElementValue($ddm_group, 'edit', $element, $option, $value, 'validation');
	}

	public function setDeleteElementValue($ddm_group, $element, $option, $value) {
		return $this->setElementValue($ddm_group, 'delete', $element, $option, $value, '');
	}

	public function setDeleteElementOption($ddm_group, $element, $option, $value) {
		return $this->setElementValue($ddm_group, 'delete', $element, $option, $value, 'options');
	}

	public function setDeleteElementValidation($ddm_group, $element, $option, $value) {
		return $this->setElementValue($ddm_group, 'delete', $element, $option, $value, 'validation');
	}

	public function setSendElementValue($ddm_group, $element, $option, $value) {
		return $this->setElementValue($ddm_group, 'send', $element, $option, $value, '');
	}

	public function setSendElementOption($ddm_group, $element, $option, $value) {
		return $this->setElementValue($ddm_group, 'send', $element, $option, $value, 'options');
	}

	public function setSendElementValidation($ddm_group, $element, $option, $value) {
		return $this->setElementValue($ddm_group, 'send', $element, $option, $value, 'validation');
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function removeElements($ddm_group) {
		if (isset($this->ddm[$ddm_group]['elements'])) {
			unset($this->ddm[$ddm_group]['elements']);

			return true;
		}

		return false;
	}

	public function removeElement($ddm_group, $type, $element) {
		if (isset($this->ddm[$ddm_group]['elements'][$type][$element])) {
			unset($this->ddm[$ddm_group]['elements'][$type][$element]);

			return true;
		}

		return false;
	}


	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function removeElementValue($ddm_group, $type, $element, $option, $group='') {
		if ($group=='') {
			if (isset($this->ddm[$ddm_group]['elements'][$type][$element][$option])) {
				unset($this->ddm[$ddm_group]['elements'][$type][$element][$option]);

				return true;
			}
		} else {
			if (isset($this->ddm[$ddm_group]['elements'][$type][$element][$group][$option])) {
				unset($this->ddm[$ddm_group]['elements'][$type][$element][$group][$option]);

				return true;
			}
		}

		return false;
	}

	public function removeViewElementValue($ddm_group, $element, $option) {
		return $this->removeElementValue($ddm_group, 'view', $element, $option, '');
	}

	public function removeViewElementOption($ddm_group, $element, $option) {
		return $this->removeElementValue($ddm_group, 'view', $element, $option, 'options');
	}

	public function removeListElementValue($ddm_group, $element, $option) {
		return $this->removeElementValue($ddm_group, 'list', $element, $option, '');
	}

	public function removeListElementOption($ddm_group, $element, $option) {
		return $this->removeElementValue($ddm_group, 'list', $element, $option, 'options');
	}

	public function removeSearchElementValue($ddm_group, $element, $option) {
		return $this->removeElementValue($ddm_group, 'search', $element, $option, '');
	}

	public function removeSearchElementOption($ddm_group, $element, $option) {
		return $this->removeElementValue($ddm_group, 'search', $element, $option, 'options');
	}

	public function removeSearchElementValidation($ddm_group, $element, $option) {
		return $this->removeElementValue($ddm_group, 'search', $element, $option, 'validation');
	}

	public function removeAddElementValue($ddm_group, $element, $option) {
		return $this->removeElementValue($ddm_group, 'add', $element, $option, '');
	}

	public function removeAddElementOption($ddm_group, $element, $option) {
		return $this->removeElementValue($ddm_group, 'add', $element, $option, 'options');
	}

	public function removeAddElementValidation($ddm_group, $element, $option) {
		return $this->removeElementValue($ddm_group, 'add', $element, $option, 'validation');
	}

	public function removeEditElementValue($ddm_group, $element, $option) {
		return $this->removeElementValue($ddm_group, 'edit', $element, $option, '');
	}

	public function removeEditElementOption($ddm_group, $element, $option) {
		return $this->removeElementValue($ddm_group, 'edit', $element, $option, 'options');
	}

	public function removeEditElementValidation($ddm_group, $element, $option) {
		return $this->removeElementValue($ddm_group, 'edit', $element, $option, 'validation');
	}

	public function removeDeleteElementValue($ddm_group, $element, $option) {
		return $this->removeElementValue($ddm_group, 'delete', $element, $option, '');
	}

	public function removeDeleteElementOption($ddm_group, $element, $option) {
		return $this->removeElementValue($ddm_group, 'delete', $element, $option, 'options');
	}

	public function removeDeleteElementValidation($ddm_group, $element, $option) {
		return $this->removeElementValue($ddm_group, 'delete', $element, $option, 'validation');
	}

	public function removeSendElementValue($ddm_group, $element, $option) {
		return $this->removeElementValue($ddm_group, 'send', $element, $option, '');
	}

	public function removeSendElementOption($ddm_group, $element, $option) {
		return $this->removeElementValue($ddm_group, 'send', $element, $option, 'options');
	}

	public function removeSendElementValidation($ddm_group, $element, $option) {
		return $this->removeElementValue($ddm_group, 'send', $element, $option, 'validation');
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function setStorageValues($ddm_group, $type, $elements) {
		$this->ddm[$ddm_group]['storage'][$type]=$elements;

		return true;
	}

	public function setListStorageValues($ddm_group, $elements) {
		return $this->setStorageValues($ddm_group, 'list', $elements);
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function getStorageValue($ddm_group, $type, $element) {
		if (isset($this->ddm[$ddm_group]['storage'][$type][$element])) {
			return $this->ddm[$ddm_group]['storage'][$type][$element];
		}

		return '';
	}

	public function getListStorageValue($ddm_group, $element) {
		return $this->getStorageValue($ddm_group, 'list', $element);
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function setElementStorage($ddm_group, $element, $value, $option='default') {
		if (!isset($this->ddm[$ddm_group]['storage']['data'])) {
			$this->ddm[$ddm_group]['storage']['data']=[];
		}
		if (!isset($this->ddm[$ddm_group]['storage']['data'][$option])) {
			$this->ddm[$ddm_group]['storage']['data'][$option]=[];
		}
		$this->ddm[$ddm_group]['storage']['data'][$option][$element]=$value;
	}

	public function setSearchElementStorage($ddm_group, $element, $value) {
		return $this->setElementStorage($ddm_group, $element, $value, 'search');
	}

	public function setDataBaseElementStorage($ddm_group, $element, $value) {
		return $this->setElementStorage($ddm_group, $element, $value, 'database');
	}

	public function setAddElementStorage($ddm_group, $element, $value) {
		return $this->setElementStorage($ddm_group, $element, $value, 'add');
	}

	public function setDoAddElementStorage($ddm_group, $element, $value) {
		return $this->setElementStorage($ddm_group, $element, $value, 'doadd');
	}

	public function setEditElementStorage($ddm_group, $element, $value) {
		return $this->setElementStorage($ddm_group, $element, $value, 'edit');
	}

	public function setDoEditElementStorage($ddm_group, $element, $value) {
		return $this->setElementStorage($ddm_group, $element, $value, 'doedit');
	}

	public function setDeleteElementStorage($ddm_group, $element, $value) {
		return $this->setElementStorage($ddm_group, $element, $value, 'delete');
	}

	public function setDoDeleteElementStorage($ddm_group, $element, $value) {
		return $this->setElementStorage($ddm_group, $element, $value, 'dodelete');
	}

	public function setSendElementStorage($ddm_group, $element, $value) {
		return $this->setElementStorage($ddm_group, $element, $value, 'send');
	}

	public function setDoSendElementStorage($ddm_group, $element, $value) {
		return $this->setElementStorage($ddm_group, $element, $value, 'dosend');
	}

	public function setFilterElementStorage($ddm_group, $element, $value) {
		return $this->setElementStorage($ddm_group, $element, $value, 'filter');
	}

	public function setFilterErrorElementStorage($ddm_group, $element, $value) {
		return $this->setElementStorage($ddm_group, $element, $value, 'filtererror');
	}

	public function setIndexElementStorage($ddm_group, $value) {
		return $this->setElementStorage($ddm_group, 'index', $value, 'index');
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function getElementStorage($ddm_group, $element, $option='default') {
		if (isset($this->ddm[$ddm_group]['storage']['data'][$option][$element])) {
			return $this->ddm[$ddm_group]['storage']['data'][$option][$element];
		}

		return '';
	}

	public function getSearchElementStorage($ddm_group, $element) {
		return $this->getElementStorage($ddm_group, $element, 'search');
	}

	public function getAddElementStorage($ddm_group, $element) {
		return $this->getElementStorage($ddm_group, $element, 'add');
	}

	public function getDoAddElementStorage($ddm_group, $element) {
		return $this->getElementStorage($ddm_group, $element, 'doadd');
	}

	public function getEditElementStorage($ddm_group, $element) {
		return $this->getElementStorage($ddm_group, $element, 'edit');
	}

	public function getDoEditElementStorage($ddm_group, $element) {
		return $this->getElementStorage($ddm_group, $element, 'doedit');
	}

	public function getDeleteElementStorage($ddm_group, $element) {
		return $this->getElementStorage($ddm_group, $element, 'delete');
	}

	public function getDoDeleteElementStorage($ddm_group, $element) {
		return $this->getElementStorage($ddm_group, $element, 'dodelete');
	}

	public function getSendElementStorage($ddm_group, $element) {
		return $this->getElementStorage($ddm_group, $element, 'send');
	}

	public function getDoSendElementStorage($ddm_group, $element) {
		return $this->getElementStorage($ddm_group, $element, 'dosend');
	}

	public function getDataBaseElementStorage($ddm_group, $element) {
		return $this->getElementStorage($ddm_group, $element, 'database');
	}

	public function getFilterElementStorage($ddm_group, $element) {
		return $this->getElementStorage($ddm_group, $element, 'filter');
	}

	public function getFilterErrorElementStorage($ddm_group, $element) {
		return $this->getElementStorage($ddm_group, $element, 'filtererror');
	}

	public function getIndexElementStorage($ddm_group) {
		return $this->getElementStorage($ddm_group, 'index', 'index');
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function getSearchElementsStorage($ddm_group) {
		return $this->getElementsStorage($ddm_group, 'search');
	}

	public function getDataBaseElementsStorage($ddm_group) {
		return $this->getElementsStorage($ddm_group, 'database');
	}

	public function getElementsStorage($ddm_group, $option='default') {
		if (isset($this->ddm[$ddm_group]['storage']['data'][$option])) {
			return $this->ddm[$ddm_group]['storage']['data'][$option];
		}

		return [];
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function clearSearchElementStorage($ddm_group, $element) {
		return $this->clearElementStorage($ddm_group, $element, 'search');
	}

	public function clearElementStorage($ddm_group, $element, $option='default') {
		if (isset($this->ddm[$ddm_group]['storage']['data'][$option][$element])) {
			unset($this->ddm[$ddm_group]['storage']['data'][$option][$element]);
		}

		return true;
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function getDirectModule($ddm_group) {
		if (''!=$this->getGroupOption($ddm_group, 'module', 'direct')) {
			return $this->getGroupOption($ddm_group, 'module', 'direct');
		}

		return 'current';
	}

	public function getDirectParameters($ddm_group) {
		$_paramters=[];
		if ((''!=$this->getGroupOption($ddm_group, 'parameters', 'direct'))&&(is_array($this->getGroupOption($ddm_group, 'parameters', 'direct')))&&(count($this->getGroupOption($ddm_group, 'parameters', 'direct'))>0)) {
			foreach ($this->getGroupOption($ddm_group, 'parameters', 'direct') as $element=>$value) {
				$_paramters[]=$element.'='.$value;
			}
		}
		$_paramters[]='ddm_cache='.$this->storeParameters($ddm_group);

		return implode('&', $_paramters);
	}

	public function direct($ddm_group, $module='current', $parameter='') {
		$this->storeParameters($ddm_group);
		h()->_direct(osW_Template::getInstance()->buildhrefLink($module, $parameter));
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function setParameter($ddm_group, $name, $value) {
		return $this->addParameter($ddm_group, $name, $value);
	}

	public function addParameter($ddm_group, $name, $value) {
		if (!isset($this->ddm[$ddm_group]['parameters'])) {
			$this->ddm[$ddm_group]['parameters']=[];
		}
		$this->ddm[$ddm_group]['parameters'][$name]=$value;
	}

	public function getParameter($ddm_group, $name) {
		if (isset($this->ddm[$ddm_group]['parameters'][$name])) {
			return $this->ddm[$ddm_group]['parameters'][$name];
		}

		return '';
	}

	public function removeParameter($ddm_group, $name) {
		if (!isset($this->ddm[$ddm_group]['parameters'])) {
			$this->ddm[$ddm_group]['parameters']=[];
		}
		if (isset($this->ddm[$ddm_group]['parameters'][$name])) {
			unset($this->ddm[$ddm_group]['parameters'][$name]);

			return true;
		}

		return false;
	}

	public function storeParameters($ddm_group) {
		if (!isset($this->ddm[$ddm_group]['parameters'])) {
			$this->ddm[$ddm_group]['parameters']=[];
		}
		ksort($this->ddm[$ddm_group]['parameters']);
		$cache_data=serialize($this->ddm[$ddm_group]['parameters']);
		$cache_id=md5($cache_data);

		$QstoreData=osW_Database::getInstance()->query('SELECT cache_id FROM :table: WHERE cache_id=:cache_id:');
		$QstoreData->bindTable(':table:', 'ddm3_cache');
		$QstoreData->bindValue(':cache_id:', $cache_id);
		$QstoreData->execute();
		if ($QstoreData->query_handler===false) {
			$this->__initDB();
			$QstoreData->execute();
		}
		if ($QstoreData->numberOfRows()===1) {
			$QupdateData=osW_Database::getInstance()->query('UPDATE :table: SET cache_lastuse=:cache_lastuse: WHERE cache_id=:cache_id:');
			$QupdateData->bindTable(':table:', 'ddm3_cache');
			$QupdateData->bindInt(':cache_lastuse:', time());
			$QupdateData->bindValue(':cache_id:', $cache_id);
			$QupdateData->execute();

			$QstoreData->next();

			return $QstoreData->Value('cache_id');
		}

		$QstoreData=osW_Database::getInstance()->query('INSERT INTO :table: (cache_id, cache_lastuse, cache_data) VALUES (:cache_id:, :cache_lastuse:, :cache_data:)');
		$QstoreData->bindTable(':table:', 'ddm3_cache');
		$QstoreData->bindValue(':cache_id:', $cache_id);
		$QstoreData->bindInt(':cache_lastuse:', time());
		$QstoreData->bindValue(':cache_data:', $cache_data);
		$QstoreData->execute();

		return $cache_id;
	}

	public function readParameters($ddm_group) {
		$cache_id=$this->getGroupOption($ddm_group, 'cache', 'general');
		$QreadData=osW_Database::getInstance()->query('SELECT cache_data FROM :table: WHERE cache_id=:cache_id:');
		$QreadData->bindTable(':table:', 'ddm3_cache');
		$QreadData->bindValue(':cache_id:', $cache_id);
		$QreadData->execute();
		if ($QreadData->query_handler===false) {
			$this->__initDB();
			$QreadData->execute();
		}
		if ($QreadData->numberOfRows()===1) {
			$QupdateData=osW_Database::getInstance()->query('UPDATE :table: SET cache_lastuse=:cache_lastuse: WHERE cache_id=:cache_id:');
			$QupdateData->bindTable(':table:', 'ddm3_cache');
			$QupdateData->bindInt(':cache_lastuse:', time());
			$QupdateData->bindValue(':cache_id:', $cache_id);
			$QupdateData->execute();

			$QreadData->next();
			$this->ddm[$ddm_group]['parameters']=unserialize($QreadData->Value('cache_data'));

			return true;
		}

		return false;
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function parseElementPHP($ddm_group, $type, $element, $values) {
		return $this->parseElement($ddm_group, $element, $values, $type, 'content', 'php');
	}

	public function parseViewElementPHP($ddm_group, $element, $values) {
		return $this->parseElementPHP($ddm_group, 'view', $element, $values);
	}

	public function parseListElementPHP($ddm_group, $element, $values) {
		return $this->parseElementPHP($ddm_group, 'list', $element, $values);
	}

	public function parseFormSearchElementPHP($ddm_group, $element, $values) {
		return $this->parseElementPHP($ddm_group, 'formsearch', $element, $values);
	}

	public function parseParserSearchElementPHP($ddm_group, $element, $values) {
		return $this->parseElementPHP($ddm_group, 'parsersearch', $element, $values);
	}

	public function parseFormAddElementPHP($ddm_group, $element, $values) {
		return $this->parseElementPHP($ddm_group, 'formadd', $element, $values);
	}

	public function parseParserAddElementPHP($ddm_group, $element, $values) {
		return $this->parseElementPHP($ddm_group, 'parseradd', $element, $values);
	}

	public function parseFilterAddElementPHP($ddm_group, $element, $values) {
		return $this->parseElementPHP($ddm_group, 'filteradd', $element, $values);
	}

	public function parseFinishAddElementPHP($ddm_group, $element, $values) {
		return $this->parseElementPHP($ddm_group, 'finishadd', $element, $values);
	}

	public function parseFormEditElementPHP($ddm_group, $element, $values) {
		return $this->parseElementPHP($ddm_group, 'formedit', $element, $values);
	}

	public function parseParserEditElementPHP($ddm_group, $element, $values) {
		return $this->parseElementPHP($ddm_group, 'parseredit', $element, $values);
	}

	public function parseFilterEditElementPHP($ddm_group, $element, $values) {
		return $this->parseElementPHP($ddm_group, 'filteredit', $element, $values);
	}

	public function parseFinishEditElementPHP($ddm_group, $element, $values) {
		return $this->parseElementPHP($ddm_group, 'finishedit', $element, $values);
	}

	public function parseFormDeleteElementPHP($ddm_group, $element, $values) {
		return $this->parseElementPHP($ddm_group, 'formdelete', $element, $values);
	}

	public function parseParserDeleteElementPHP($ddm_group, $element, $values) {
		return $this->parseElementPHP($ddm_group, 'parserdelete', $element, $values);
	}

	public function parseFinishDeleteElementPHP($ddm_group, $element, $values) {
		return $this->parseElementPHP($ddm_group, 'finishdelete', $element, $values);
	}

	public function parseFinishSearchElementPHP($ddm_group, $element, $values) {
		return $this->parseElementPHP($ddm_group, 'finishsearch', $element, $values);
	}

	public function parseFormSendElementPHP($ddm_group, $element, $values) {
		return $this->parseElementPHP($ddm_group, 'formsend', $element, $values);
	}

	public function parseParserSendElementPHP($ddm_group, $element, $values) {
		return $this->parseElementPHP($ddm_group, 'parsersend', $element, $values);
	}

	public function parseFilterSendElementPHP($ddm_group, $element, $values) {
		return $this->parseElementPHP($ddm_group, 'filtersend', $element, $values);
	}

	public function parseFinishSendElementPHP($ddm_group, $element, $values) {
		return $this->parseElementPHP($ddm_group, 'finishsend', $element, $values);
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function parseElementTPL($ddm_group, $type, $position, $element, $values) {
		return $this->parseElement($ddm_group, $element, $values, $type, $position, 'tpl');
	}

	public function parseViewElementTPL($ddm_group, $element, $values) {
		return $this->parseElementTPL($ddm_group, 'view', 'content', $element, $values);
	}

	public function parseListElementTPL($ddm_group, $element, $values) {
		return $this->parseElementTPL($ddm_group, 'list', 'content', $element, $values);
	}

	public function parseListHeaderElementTPL($ddm_group, $element, $values) {
		return $this->parseElementTPL($ddm_group, 'list', 'header', $element, $values);
	}

	public function parseFormSearchElementTPL($ddm_group, $element, $values) {
		return $this->parseElementTPL($ddm_group, 'formsearch', 'content', $element, $values);
	}

	public function parseFormAddElementTPL($ddm_group, $element, $values) {
		return $this->parseElementTPL($ddm_group, 'formadd', 'content', $element, $values);
	}

	public function parseFormEditElementTPL($ddm_group, $element, $values) {
		return $this->parseElementTPL($ddm_group, 'formedit', 'content', $element, $values);
	}

	public function parseFormDeleteElementTPL($ddm_group, $element, $values) {
		return $this->parseElementTPL($ddm_group, 'formdelete', 'content', $element, $values);
	}

	public function parseFormSendElementTPL($ddm_group, $element, $values) {
		return $this->parseElementTPL($ddm_group, 'formsend', 'content', $element, $values);
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function parseElement($ddm_group, $element, $values, $type='', $file='content', $script='php') {
		if (!isset($values['module'])) {
			return false;
		}

		if ($script==='tpl') {
			$path=$type.'/'.$values['module'].'/tpl/';
			$file=$file.'.tpl.php';

			return $this->runTPLScript($path, $file, $ddm_group, $type, $element, $values);
		} else {
			$path=$type.'/'.$values['module'].'/php/';
			$file=$file.'.inc.php';

			return $this->runPHPScript($path, $file, $ddm_group, $type, $element, $values);
		}
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function runDDMPHP($ddm_group) {
		$engine=$this->getGroupOption($ddm_group, 'engine');

		$this->runDefaultScript('loader/run/php/', $ddm_group.'.inc.php', $ddm_group);

		return $this->runPHPScript('engine/'.$engine.'/php/', 'content.inc.php', $ddm_group);
	}

	public function runPHPScript($path, $file, $ddm_group, $type='', $element='', $values=[]) {
		return $this->runScript($path, $file, $ddm_group, $type, $element, $values, false);
	}

	public function runDDMTPL($ddm_group) {
		$engine=$this->getGroupOption($ddm_group, 'engine');

		return $this->runTPLScript('engine/'.$engine.'/tpl/', 'content.tpl.php', $ddm_group);
	}

	public function runTPLScript($path, $file, $ddm_group, $type='', $element='', $values=[]) {
		return $this->runScript($path, $file, $ddm_group, $type, $element, $values, true);
	}

	public function runScript($path, $file, $ddm_group, $type='', $element='', $values=[], $ob_get_contents=false) {
		if ($ob_get_contents===true) {
			ob_start();
		}

		$file_exists=false;
		if (file_exists(settings_abspath.'modules/'.vOut('frame_current_module').'/autoloader/ddm3.inc.php')) {
			include(settings_abspath.'modules/'.vOut('frame_current_module').'/autoloader/ddm3.inc.php');
		} elseif (file_exists(settings_abspath.'modules/'.vOut('project_default_module').'/autoloader/ddm3.inc.php')) {
			include(settings_abspath.'modules/'.vOut('project_default_module').'/autoloader/ddm3.inc.php');
		} elseif (file_exists(settings_abspath.'frame/autoloader/ddm3.inc.php')) {
			include(settings_abspath.'frame/autoloader/ddm3.inc.php');
		}

		if ($ob_get_contents===true) {
			$contents=ob_get_contents();
			ob_end_clean();
			if ($file_exists===true) {
				return $contents;
			} else {
				if (!isset($this->ddm[$ddm_group]['modules_error'])) {
					$this->ddm[$ddm_group]['modules_error']=[];
				}

				if (!isset($this->ddm[$ddm_group]['modules_error'][$values['module']])) {
					$this->ddm[$ddm_group]['modules_error'][$values['module']]=true;
					$values['path']=$path;
					osW_MessageStack::getInstance()->add('form', 'error', ['msg'=>h()->_setText($this->getGroupMessage($ddm_group, 'module_not_found'), $values)]);
				}

				return false;
			}
		} else {
			if ($file_exists===true) {
				return true;
			} else {
				if (!isset($this->ddm[$ddm_group]['modules_error'])) {
					$this->ddm[$ddm_group]['modules_error']=[];
				}

				if (!isset($this->ddm[$ddm_group]['modules_error'][$values['module']])) {
					$this->ddm[$ddm_group]['modules_error'][$values['module']]=true;
					$values['path']=$path;
					osW_MessageStack::getInstance()->add('form', 'error', ['msg'=>h()->_setText($this->getGroupMessage($ddm_group, 'module_not_found'), $values)]);
				}

				return false;
			}
		}
	}

	public function runDefaultScript($path, $file, $ddm_group) {
		$default_options=[];

		if (file_exists(settings_abspath.'modules/'.vOut('frame_current_module').'/autoloader/ddm3_default.inc.php')) {
			include(settings_abspath.'modules/'.vOut('frame_current_module').'/autoloader/ddm3_default.inc.php');
		} elseif (file_exists(settings_abspath.'modules/'.vOut('project_default_module').'/autoloader/ddm3_default.inc.php')) {
			include(settings_abspath.'modules/'.vOut('project_default_module').'/autoloader/ddm3_default.inc.php');
		} elseif (file_exists(settings_abspath.'frame/autoloader/ddm3_default.inc.php')) {
			include(settings_abspath.'frame/autoloader/ddm3_default.inc.php');
		}

		return $default_options;
	}

	public function setLock($ddm_group, $value, $tool_id=0, $key='', $user_id=0) {
		if ($tool_id==0) {
			$tool_id=osW_VIS::getInstance()->getToolID();
		}
		if ($key=='') {
			$key=$this->getGroupOption($ddm_group, 'index', 'database');
		}
		if ($user_id==0) {
			$user_id=osW_VIS_User::getInstance()->getid();
		}
		$this->clearLock();
		$Qgetlock=osW_Database::getInstance()->query('SELECT * FROM :table_ddm3_lock: WHERE lock_toolid=:lock_toolid: AND lock_group=:lock_group: AND lock_key=:lock_key: AND lock_value=:lock_value:');
		$Qgetlock->bindTable(':table_ddm3_lock:', 'ddm3_lock');
		$Qgetlock->bindInt(':lock_toolid:', $tool_id);
		$Qgetlock->bindValue(':lock_group:', $ddm_group);
		$Qgetlock->bindValue(':lock_key:', $key);
		$Qgetlock->bindValue(':lock_value:', $value);
		$Qgetlock->execute();
		if ($Qgetlock->numberOfRows()==1) {
			$Qgetlock=osW_Database::getInstance()->query('SELECT * FROM :table_ddm3_lock: WHERE lock_toolid=:lock_toolid: AND lock_group=:lock_group: AND lock_key=:lock_key: AND lock_value=:lock_value: AND user_id=:user_id:');
			$Qgetlock->bindTable(':table_ddm3_lock:', 'ddm3_lock');
			$Qgetlock->bindInt(':lock_toolid:', $tool_id);
			$Qgetlock->bindValue(':lock_group:', $ddm_group);
			$Qgetlock->bindValue(':lock_key:', $key);
			$Qgetlock->bindValue(':lock_value:', $value);
			$Qgetlock->bindInt(':user_id:', $user_id);
			$Qgetlock->execute();
			if ($Qgetlock->numberOfRows()==1) {
				$Qlock=osW_Database::getInstance()->query('UPDATE :table_ddm3_lock: SET lock_time=:lock_time: WHERE lock_toolid=:lock_toolid: AND lock_group=:lock_group: AND lock_key=:lock_key: AND lock_value=:lock_value: AND user_id=:user_id:');
				$Qlock->bindTable(':table_ddm3_lock:', 'ddm3_lock');
				$Qlock->bindInt(':lock_toolid:', $tool_id);
				$Qlock->bindValue(':lock_group:', $ddm_group);
				$Qlock->bindValue(':lock_key:', $key);
				$Qlock->bindValue(':lock_value:', $value);
				$Qlock->bindInt(':user_id:', $user_id);
				$Qlock->bindInt(':lock_time:', time());
				$Qlock->execute();
			} else {
				return false;
			}
		} else {
			$Qlock=osW_Database::getInstance()->query('INSERT INTO :table_ddm3_lock: (lock_toolid, lock_group, lock_key, lock_value, user_id, lock_time) VALUES (:lock_toolid:, :lock_group:, :lock_key:, :lock_value:, :user_id:, :lock_time:)');
			$Qlock->bindTable(':table_ddm3_lock:', 'ddm3_lock');
			$Qlock->bindInt(':lock_toolid:', $tool_id);
			$Qlock->bindValue(':lock_group:', $ddm_group);
			$Qlock->bindValue(':lock_key:', $key);
			$Qlock->bindValue(':lock_value:', $value);
			$Qlock->bindInt(':user_id:', $user_id);
			$Qlock->bindInt(':lock_time:', time());
			$Qlock->execute();
		}

		return true;
	}

	public function checkLock($ddm_group, $value, $tool_id=0, $key='', $user_id=0) {
		if ($tool_id==0) {
			$tool_id=osW_VIS::getInstance()->getToolID();
		}
		if ($key=='') {
			$key=$this->getGroupOption($ddm_group, 'index', 'database');
		}
		if ($user_id==0) {
			$user_id=osW_VIS_User::getInstance()->getid();
		}
		$this->setLock($ddm_group, $value);
		$Qgetlock=osW_Database::getInstance()->query('SELECT * FROM :table_ddm3_lock: WHERE lock_toolid=:lock_toolid: AND lock_group=:lock_group: AND lock_key=:lock_key: AND lock_value=:lock_value: AND user_id=:user_id:');
		$Qgetlock->bindTable(':table_ddm3_lock:', 'ddm3_lock');
		$Qgetlock->bindInt(':lock_toolid:', $tool_id);
		$Qgetlock->bindValue(':lock_group:', $ddm_group);
		$Qgetlock->bindValue(':lock_key:', $key);
		$Qgetlock->bindValue(':lock_value:', $value);
		$Qgetlock->bindInt(':user_id:', $user_id);
		$Qgetlock->execute();
		if ($Qgetlock->numberOfRows()==1) {
			$Qlock=osW_Database::getInstance()->query('UPDATE :table_ddm3_lock: SET lock_time=:lock_time: WHERE lock_toolid=:lock_toolid: AND lock_group=:lock_group: AND lock_key=:lock_key: AND lock_value=:lock_value: AND user_id=:user_id:');
			$Qlock->bindTable(':table_ddm3_lock:', 'ddm3_lock');
			$Qlock->bindInt(':lock_toolid:', $tool_id);
			$Qlock->bindValue(':lock_group:', $ddm_group);
			$Qlock->bindValue(':lock_key:', $key);
			$Qlock->bindValue(':lock_value:', $value);
			$Qlock->bindInt(':user_id:', $user_id);
			$Qlock->bindInt(':lock_time:', time());
			$Qlock->execute();
		} else {
			$Qlock=osW_Database::getInstance()->query('INSERT INTO :table_ddm3_lock: (lock_toolid, lock_group, lock_key, lock_value, user_id, lock_time) VALUES (:lock_toolid:, :lock_group:, :lock_key:, :lock_value:, :user_id:, :lock_time:)');
			$Qlock->bindTable(':table_ddm3_lock:', 'ddm3_lock');
			$Qlock->bindInt(':lock_toolid:', $tool_id);
			$Qlock->bindValue(':lock_group:', $ddm_group);
			$Qlock->bindValue(':lock_key:', $key);
			$Qlock->bindValue(':lock_value:', $value);
			$Qlock->bindInt(':user_id:', $user_id);
			$Qlock->bindInt(':lock_time:', time());
			$Qlock->execute();
		}

		return true;
	}

	public function getLockUser($ddm_group, $value, $tool_id=0, $key='', $user_id=0) {
		if ($tool_id==0) {
			$tool_id=osW_VIS::getInstance()->getToolID();
		}
		if ($key=='') {
			$key=$this->getGroupOption($ddm_group, 'index', 'database');
		}
		if ($user_id==0) {
			$user_id=osW_VIS_User::getInstance()->getid();
		}
		$this->setLock($ddm_group, $value);
		$Qgetlock=osW_Database::getInstance()->query('SELECT * FROM :table_ddm3_lock: WHERE lock_toolid=:lock_toolid: AND lock_group=:lock_group: AND lock_key=:lock_key: AND lock_value=:lock_value:');
		$Qgetlock->bindTable(':table_ddm3_lock:', 'ddm3_lock');
		$Qgetlock->bindInt(':lock_toolid:', $tool_id);
		$Qgetlock->bindValue(':lock_group:', $ddm_group);
		$Qgetlock->bindValue(':lock_key:', $key);
		$Qgetlock->bindValue(':lock_value:', $value);
		$Qgetlock->execute();
		if ($Qgetlock->numberOfRows()==1) {
			$Qgetlock->next();

			return osW_VIS_Manager::getInstance()->getUsers()[$Qgetlock->result['user_id']];
		}

		return 'Benutzer';
	}

	public function clearLock() {
		$Qclearlock=osW_Database::getInstance()->query('DELETE FROM :table_ddm3_lock: WHERE lock_time<:lock_time:');
		$Qclearlock->bindTable(':table_ddm3_lock:', 'ddm3_lock');
		$Qclearlock->bindInt(':lock_time:', (time()-10));
		$Qclearlock->execute();

		return true;
	}

	/**
	 *
	 * @return osW_DDM3
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>