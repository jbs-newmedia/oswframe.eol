<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

class osW_DDM4 extends osW_Object {

	// PROPERTIES

	public $ddm=array();

	// METHODS CORE

	public function __construct() {
		parent::__construct(1, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	public function addGroup($ddm_group, $options) {
		if (isset($this->ddm[$ddm_group]['options'])) {
			return false;
		}
		if (!isset($options['messages'])) {
			$options['messages']=array();
		}
		$options['messages']=$this->loadDefaultMessages($options['messages']);
		$this->ddm[$ddm_group]['options']=$options;

		if ((!isset($this->ddm[$ddm_group]['options']['layout_loaded']))||($this->ddm[$ddm_group]['options']['layout_loaded']!==true)) {
			if (!isset($this->ddm[$ddm_group]['options']['layout'])) {
				$this->ddm[$ddm_group]['options']['layout']='default';
			}
			$this->ddm[$ddm_group]['options']['layout_loaded']=true;

			foreach (glob(vOut('settings_abspath').'frame/ddm4/layout/'.$this->ddm[$ddm_group]['options']['layout'].'/*.css') as $filename) {
				$filename=str_replace(vOut('settings_abspath'), '', $filename);
				osW_Template::getInstance()->addCSSFileHead($filename);
			}
		}

		$file=vOut('settings_abspath').'frame/ddm4/loader/group/'.$ddm_group.'.inc.php';
		if (file_exists($file)) {
			include $file;
		}

		return true;
	}

	public function loadDefaultMessages($messages) {
		$default_messages=array(
			'data_options'=>'Optionen',
			'form_submit'=>'Absenden',
			'form_search'=>'Suchen',
			'form_add'=>'Erstellen',
			'form_edit'=>'Bearbeiten',
			'form_delete'=>'Löschen',
			'form_reset'=>'Zurücksetzen',
			'form_close'=>'Schließen',
			'form_cancel'=>'Abbrechen',
			'form_delete'=>'Löschen',
			'form_send'=>'Absenden',
			'data_search'=>'Suchen',
			'data_add'=>'Erstellen',
			'data_edit'=>'Bearbeiten',
			'data_delete'=>'Löschen',
			'data_log'=>'Log',
			'form_title_required_icon'=>'*',
			'form_title_pages'=>'Seiten',
			'form_title_pages_single'=>'Seite',
			'form_title_pages_multi'=>'Seiten',
			'form_title_counter'=>'Datensätze $elements_from$ - $elements_to$ ($elements_all$ insgesamt)',
			'form_title_counter_single'=>'Datensatz $elements_from$ - $elements_to$ ($elements_all$ insgesamt)',
			'form_title_counter_multi'=>'Datensätze $elements_from$ - $elements_to$ ($elements_all$ insgesamt)',
			'form_title_asc'=>'Aufsteigend sortieren',
			'form_title_desc'=>'Absteigend sortieren',
			'form_title_sortorder_delete'=>'Sortierung entfernen',
			'form_title_closer'=>':',
			'form_required_notice'=>'* Pflichtfeld',
			'form_required_notice_multi'=>'* Pflichtfelder',
			'form_error'=>'Eingabefehler',
			'data_noresults'=>'Keine Elemente vorhanden',
			'text_char'=>'Zeichen',
			'text_chars'=>'Zeichen',
			'text_all'=>'Alle',
			'text_yes'=>'Ja',
			'text_no'=>'Nein',
			'text_action'=>'Aktion',
			'text_file_view'=>'Datei anzeigen',
			'text_file_delete'=>'Datei löschen',
			'text_image_view'=>'Bild anzeigen',
			'text_image_delete'=>'Bild löschen',
			'text_clock'=>'Uhr',
			'text_search'=>'Suche',
			'text_filter'=>'Filter',
			'text_selected'=>'Ausgewählte',
			'text_notselected'=>'Nicht Ausgewählte',
			'text_selectall'=>'Alle auswählen',
			'text_deselectall'=>'Keins auswählen',
			'text_invertselection'=>'Auswahl umkehren',
			'text_all'=>'Alle',
			'create_time'=>'Erstellt am',
			'create_user'=>'Erstellt von',
			'update_time'=>'Geändert am',
			'update_user'=>'Geändert von',
			'search_title'=>'Erweiterte Suche',
			'edit_search_title'=>'Erweiterte Suche bearbeiten',
			'back_title'=>'Zurück zur Übersicht',
			'sortorder_title'=>'Sortierung',
			'createupdate_title'=>'Datensatzinformationen',
			'log_title'=>'Datensatzhistorie',
			'send_title'=>'Datensatz übermitteln',
			'send_success_title'=>'Datensatz wurde erfolgreich übermittelt',
			'add_title'=>'Neuen Datensatz erstellen',
			'add_success_title'=>'Datensatz wurde erfolgreich erstellt',
			'add_error_title'=>'Datensatz konnte nicht erstellt werden',
			'edit_title'=>'Datensatz bearbeiten',
			'edit_load_error_title'=>'Datensatz wurde nicht gefunden',
			'edit_success_title'=>'Datensatz wurde erfolgreich bearbeitet',
			'edit_error_title'=>'Datensatz konnte nicht bearbeitet werden',
			'delete_title'=>'Datensatz löschen',
			'delete_load_error_title'=>'Datensatz wurde nicht gefunden',
			'delete_success_title'=>'Datensatz wurde erfolgreich gelöscht',
			'delete_error_title'=>'Datensatz konnte nicht gelöscht werden',
			'validation_element_error'=>'Fehler bei $element_title$.',
			'validation_element_filtererror'=>'Filter "$filter$" bei "$element_title$" wurde nicht gefunden.',
			'validation_element_incorrect'=>'Ihre Eingabe bei "$element_title$" ist nicht korrekt.',
			'validation_element_toshort'=>'Bitte korrekt angeben (Mindestens $length_min$ Zeichen)',
			'validation_element_tolong'=>'Bitte korrekt angeben (Maximal $length_max$ Zeichen)',
			'validation_element_empty'=>'Bitte angeben',
			'validation_element_tosmall'=>'Ihre Eingabe bei "$element_title$" ist zu klein.',
			'validation_element_tobig'=>'Ihre Eingabe bei "$element_title$" ist zu groß.',
			'validation_element_regerror'=>'Ihre Eingabe bei "$element_title$" ist nicht korrekt.',
			'validation_element_double'=>'Ihre Eingaben bei "$element_title$" stimmen nicht überein.',
			'validation_element_unique'=>'Ihre Eingabe bei "$element_title$" ist bereits vorhanden.',
			'validation_element_miss'=>'Ihre Eingabe bei "$element_title$" fehlt.',
			'validation_file_uploaderror'=>'Die Datei bei "$element_title$" konnte nicht hochgeladen werden.',
			'validation_file_typeerror'=>'Die Datei bei "$element_title$" ist vom falschen Typ.',
			'validation_file_extensionerror'=>'Die Datei bei "$element_title$" hat die falsche Endung.',
			'validation_file_tosmall'=>'Die Datei bei "$element_title$" ist zu klein.',
			'validation_file_tobig'=>'Die Datei bei "$element_title$" ist zu groß.',
			'validation_file_miss'=>'Keine Datei bei "$element_title$" hochgeladen.',
			'validation_image_uploaderror'=>'Die Datei bei "$element_title$" konnte nicht hochgeladen werden.',
			'validation_image_fileerror'=>'Die Datei bei "$element_title$" ist kein Bild.',
			'validation_image_typeerror'=>'Die Datei bei "$element_title$" ist vom falschen Typ.',
			'validation_image_extensionerror'=>'Die Datei bei "$element_title$" hat die falsche Endung.',
			'validation_image_tosmall'=>'Die Datei bei "$element_title$" ist zu klein.',
			'validation_image_tobig'=>'Die Datei bei "$element_title$" ist zu groß.',
			'validation_imagewidth_tosmall'=>'Die Breite bei "$element_title$" ist zu klein.',
			'validation_imagewidth_tobig'=>'Die Breite bei "$element_title$" ist zu groß.',
			'validation_imageheight_tosmall'=>'Die Höhe bei "$element_title$" ist zu klein.',
			'validation_imageheight_tobig'=>'Die Höhe bei "$element_title$" ist zu groß.',
			'validation_image_miss'=>'Keine Datei bei "$element_title$" hochgeladen.',
			'module_not_found'=>'Modul "$module$" in "$path$" nicht gefunden',
		);
		if ($messages!=array()) {
			foreach ($messages as $key => $value) {
				$default_messages[$key]=$value;
			}
		}
		return $default_messages;
	}

	/**
	 *
	 * Setzt den Wert einer Group-Option
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
				$this->ddm[$ddm_group]['counts']=array();
			}

			if ($type=='data') {
				$_data=array('list', 'search', 'add', 'edit', 'delete');

				$default_options=array();
				$file=vOut('settings_abspath').'frame/ddm4/defaultdata/'.$options['module'].'/php/content.inc.php';
				if (file_exists($file)) {
					include $file;
				}
				$options=array_replace_recursive($default_options, $options);

				$_tmp=array();
				foreach ($_data as $_type) {
					$_tmp[$_type]=array();
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

						if ((isset($this->ddm[$ddm_group]['elements'][$_type][$element]['options']['check_required']))&&($this->ddm[$ddm_group]['elements'][$_type][$element]['options']['check_required']===true)) {
							if (isset($this->ddm[$ddm_group]['elements'][$_type][$element]['validation'])) {
								if ((isset($this->ddm[$ddm_group]['elements'][$_type][$element]['validation']['length_min']))&&($this->ddm[$ddm_group]['elements'][$_type][$element]['validation']['length_min']>0)) {
									$this->ddm[$ddm_group]['elements'][$_type][$element]['options']['required']=true;
								}
							}
						}
					}
				}
			} else {
				$default_options=array();
				$file=vOut('settings_abspath').'frame/ddm4/defaultdata/'.$options['module'].'/php/content.inc.php';
				if (file_exists($file)) {
					include $file;
				}
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
			return array();
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
			return array();
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

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////



	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function getElementsValue($ddm_group, $type, $key, $group='') {
		$ar_tmp=array();
		foreach ($this->getElements($ddm_group, $type) as $id => $options) {
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

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////



	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function getElementsName($ddm_group, $type, $group='') {
		$ar_tmp=array();
		$key='name';
		foreach ($this->getElements($ddm_group, $type) as $id => $options) {
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
			$this->ddm[$ddm_group]['storage']['data']=array();
		}
		if (!isset($this->ddm[$ddm_group]['storage']['data'][$option])) {
			$this->ddm[$ddm_group]['storage']['data'][$option]=array();
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
		return array();
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
		$_paramters=array();
		if ((''!=$this->getGroupOption($ddm_group, 'parameters', 'direct'))&&(is_array($this->getGroupOption($ddm_group, 'parameters', 'direct')))&&(count($this->getGroupOption($ddm_group, 'parameters', 'direct'))>0)) {
			foreach($this->getGroupOption($ddm_group, 'parameters', 'direct') as $element => $value) {
				$_paramters[]=$element.'='.$value;
			}
		}
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
			$this->ddm[$ddm_group]['parameters']=array();
		}
		$this->ddm[$ddm_group]['parameters'][$name]=$value;
	}

	public function getParameter($ddm_group, $name) {
		if (isset($this->ddm[$ddm_group]['parameters'][$name])) {
			return $this->ddm[$ddm_group]['parameters'][$name];
		}
		if ($name=='ddm_search_data') {
			return array();
		}
		return '';
	}

	public function removeParameter($ddm_group, $name) {
		if (!isset($this->ddm[$ddm_group]['parameters'])) {
			$this->ddm[$ddm_group]['parameters']=array();
		}
		if (isset($this->ddm[$ddm_group]['parameters'][$name])) {
			unset($this->ddm[$ddm_group]['parameters'][$name]);
			return true;
		}
		return false;
	}

	public function storeParameters($ddm_group) {
		osW_Session::getInstance()->set('ddm4_'.$ddm_group.'_parameters', $this->ddm[$ddm_group]['parameters']);
	}

	public function readParameters($ddm_group) {
		$this->ddm[$ddm_group]['parameters']=osW_Session::getInstance()->value('ddm4_'.$ddm_group.'_parameters');
		if ($this->ddm[$ddm_group]['parameters']===false) {
			$this->ddm[$ddm_group]['parameters']=array();
		}
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
			ob_start();
			$file=vOut('settings_abspath').'frame/ddm4/'.$type.'/'.$values['module'].'/tpl/content.tpl.php';
			if (file_exists($file)) {
				include $file;
			}
			$contents=ob_get_contents();
			ob_end_clean();
			return $contents;
		} else {
			$file=vOut('settings_abspath').'frame/ddm4/'.$type.'/'.$values['module'].'/php/content.inc.php';
			if (file_exists($file)) {
				include $file;
			}
			return true;
		}
	}

	//////////////////////////////////////////////
	//////////////////////////////////////////////
	//////////////////////////////////////////////

	public function runDDMPHP($ddm_group) {
		$engine=$this->getGroupOption($ddm_group, 'engine');

		$file=vOut('settings_abspath').'frame/ddm4/loader/run/'.$ddm_group.'.inc.php';
		if (file_exists($file)) {
			include $file;
		}

		$file=vOut('settings_abspath').'frame/ddm4/engine/'.$engine.'/php/content.inc.php';
		if (file_exists($file)) {
			include $file;
		}
		return true;
	}

	public function runDDMTPL($ddm_group) {
		$engine=$this->getGroupOption($ddm_group, 'engine');

		ob_start();
		$file=vOut('settings_abspath').'frame/ddm4/engine/'.$engine.'/tpl/content.tpl.php';
		if (file_exists($file)) {
			include $file;
		}
		$contents=ob_get_contents();
		ob_end_clean();
		return $contents;
	}

	/**
	 *
	 * @return osW_DDM4
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}
}

?>