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

$this->readParameters($ddm_group);

switch (osW_Settings::getInstance()->getAction()) {
	case 'add':
		if ($this->getCounter($ddm_group, 'add_elements')>0) {
			osW_Settings::getInstance()->setAction('add');
		} else {
			osW_Settings::getInstance()->setAction('');
		}
		break;
	case 'doadd':
		if ($this->getCounter($ddm_group, 'add_elements')>0) {
			osW_Settings::getInstance()->setAction('doadd');
		} else {
			osW_Settings::getInstance()->setAction('');
		}
		break;
	case 'edit':
		if ($this->getCounter($ddm_group, 'edit_elements')>0) {
			osW_Settings::getInstance()->setAction('edit');
		} else {
			osW_Settings::getInstance()->setAction('');
		}
		break;
	case 'doedit':
		if ($this->setLock($ddm_group, h()->_catch($this->getGroupOption($ddm_group, 'index', 'database')))!==true) {
			osW_Settings::getInstance()->setAction('');
		}

		if ($this->getCounter($ddm_group, 'edit_elements')>0) {
			osW_Settings::getInstance()->setAction('doedit');
		} else {
			osW_Settings::getInstance()->setAction('');
		}
		break;
	case 'delete':
		if ($this->getCounter($ddm_group, 'delete_elements')>0) {
			osW_Settings::getInstance()->setAction('delete');
		} else {
			osW_Settings::getInstance()->setAction('');
		}
		break;
	case 'dodelete':
		if ($this->setLock($ddm_group, h()->_catch($this->getGroupOption($ddm_group, 'index', 'database')))!==true) {
			osW_Settings::getInstance()->setAction('');
		}

		if ($this->getCounter($ddm_group, 'delete_elements')>0) {
			osW_Settings::getInstance()->setAction('dodelete');
		} else {
			osW_Settings::getInstance()->setAction('');
		}
		break;
	case 'dolock':
		if ($this->setLock($ddm_group, h()->_catch($this->getGroupOption($ddm_group, 'index', 'database')))==true) {
			die(json_encode(['status'=>'Ok']));
		}
		die(json_encode(['status'=>'Error']));
		break;
	case 'log':
		$titles=[];
		foreach ($this->getEditElements($ddm_group) as $element=>$element_details) {
			$titles[$element]=$element_details['title'];
		}

		if (is_array($this->getFinishElementOption($ddm_group, $element, 'titles'))) {
			foreach ($this->getFinishElementOption($ddm_group, $element, 'titles') as $_key=>$_value) {
				$titles[$_key]=$_value;
			}
		}

		if ($this->getFinishElementOption($ddm_group, $element, 'group')!='') {
			$group=$this->getFinishElementOption($ddm_group, $element, 'group');
		} else {
			$group=$this->getGroupOption($ddm_group, 'table', 'database');
		}

		$index_key=$this->getGroupOption($ddm_group, 'index', 'database');
		$index_value=h()->_catch($index_key, '', 'gp');
		$this->removeElements($ddm_group, 'list');

		$this->setParameter($ddm_group, 'ddm_order', []);

		osW_DDM3::getInstance()->setGroupOption($ddm_group, 'table', 'ddm3_log', 'database');
		osW_DDM3::getInstance()->setGroupOption($ddm_group, 'index', 'log_id', 'database');
		osW_DDM3::getInstance()->setGroupOption($ddm_group, 'order', ['log_id'=>'desc'], 'database');
		osW_DDM3::getInstance()->setGroupOption($ddm_group, 'disable_add', true);
		osW_DDM3::getInstance()->setGroupOption($ddm_group, 'disable_edit', true);
		osW_DDM3::getInstance()->setGroupOption($ddm_group, 'disable_delete', true);
		osW_DDM3::getInstance()->setGroupOption($ddm_group, 'filter', [['and'=>[['key'=>'log_group', 'operator'=>'=', 'value'=>'\''.$group.'\''], ['key'=>'name_index', 'operator'=>'=', 'value'=>'\''.$index_key.'\''], ['key'=>'value_index', 'operator'=>'=', 'value'=>osW_Database::getInstance()->escape_string($index_value)]]]], 'database');

		$messages=['data_noresults'=>'Keine Daten vorhanden', 'search_title'=>'Daten durchsuchen'];

		osW_DDM3::getInstance()->setGroupMessages($ddm_group, osW_DDM3::getInstance()->loadDefaultMessages($messages));

		osW_DDM3::getInstance()->addViewElement($ddm_group, 'table_header', ['module'=>'table_header']);

		osW_DDM3::getInstance()->addViewElement($ddm_group, 'table_data', ['module'=>'table_data']);

		osW_DDM3::getInstance()->addViewElement($ddm_group, 'pages', ['module'=>'pages']);

		// DataList

		osW_DDM3::getInstance()->addDataElement($ddm_group, 'header', ['module'=>'header', '_search'=>['title'=>osW_DDM3::getInstance()->getGroupOption($ddm_group, 'search_title', 'messages')], '_add'=>['title'=>osW_DDM3::getInstance()->getGroupOption($ddm_group, 'add_title', 'messages')], '_edit'=>['title'=>osW_DDM3::getInstance()->getGroupOption($ddm_group, 'edit_title', 'messages')], '_delete'=>['title'=>osW_DDM3::getInstance()->getGroupOption($ddm_group, 'delete_title', 'messages')]]);

		osW_DDM3::getInstance()->addDataElement($ddm_group, 'log_id', ['module'=>'index', 'title'=>'ID', 'name'=>'log_id']);

		osW_DDM3::getInstance()->addDataElement($ddm_group, 'log_key', ['module'=>'select', 'title'=>'Feld', 'name'=>'log_key', 'options'=>['data'=>$titles]]);

		osW_DDM3::getInstance()->addDataElement($ddm_group, 'log_value_time_new', ['module'=>'timestamp', 'title'=>'Neu (Datum)', 'name'=>'log_value_time_new']);

		osW_DDM3::getInstance()->addDataElement($ddm_group, 'log_value_time_old', ['module'=>'timestamp', 'title'=>'Alt (Datum)', 'name'=>'log_value_time_old']);

		osW_DDM3::getInstance()->addDataElement($ddm_group, 'log_value_user_id_new', ['module'=>'select', 'title'=>'Neu (Benutzer)', 'name'=>'log_value_user_id_new', 'options'=>['data'=>osW_VIS_Users::getInstance()->getAllUsersSelect()]]);

		osW_DDM3::getInstance()->addDataElement($ddm_group, 'log_value_user_id_old', ['module'=>'select', 'title'=>'Alt (Benutzer)', 'name'=>'log_value_user_id_old', 'options'=>['data'=>osW_VIS_Users::getInstance()->getAllUsersSelect()]]);

		osW_DDM3::getInstance()->addDataElement($ddm_group, 'log_value_new', ['module'=>'text', 'title'=>'Neu (Wert)', 'name'=>'log_value_new']);

		osW_DDM3::getInstance()->addDataElement($ddm_group, 'log_value_old', ['module'=>'text', 'title'=>'Alt (Wert)', 'name'=>'log_value_old']);

		osW_DDM3::getInstance()->addDataElement($ddm_group, 'submit', ['module'=>'submit']);

		osW_Settings::getInstance()->setAction('');
		break;
	default:
		osW_Settings::getInstance()->setAction('');
		break;
}

$ddm_navigation_id=intval(h()->_catch('ddm_navigation_id', $this->getParameter($ddm_group, 'ddm_navigation_id'), 'pg'));

// Add
if ((osW_Settings::getInstance()->getAction()=='add')||(osW_Settings::getInstance()->getAction()=='doadd')) {
	$this->setIndexElementStorage($ddm_group, h()->_catch(0, '', 'pg'));

	foreach ($this->getAddElements($ddm_group) as $element=>$options) {
		$this->parseFormAddElementPHP($ddm_group, $element, $options);
	}

	if (osW_Settings::getInstance()->getAction()=='doadd') {
		if (strlen(h()->_catch('btn_ddm_cancel', '', 'p'))>0) {
			osW_Settings::getInstance()->setAction('');
			$_POST=[];
		}
	}

	if ((osW_Settings::getInstance()->getAction()=='add')||(osW_Settings::getInstance()->getAction()=='doadd')) {
		foreach ($this->getAddElements($ddm_group) as $element=>$element_details) {
			if ((isset($element_details['name']))&&($element_details['name']!='')) {
				$this->setAddElementStorage($ddm_group, $element, $this->getAddElementOption($ddm_group, $element, 'default_value'));
			}
		}

		if (osW_Settings::getInstance()->getAction()=='doadd') {
			foreach ($this->getAddElements($ddm_group) as $element=>$options) {
				$options=$this->getAddElementValue($ddm_group, $element, 'validation');
				if ($options!='') {
					$this->parseParserAddElementPHP($ddm_group, $element, $options);
				}
			}

			if (osW_MessageStack::getInstance()->size('form')) {
				osW_Settings::getInstance()->setAction('add');
			} else {
				foreach ($this->getAddElements($ddm_group) as $element=>$options) {
					$this->parseFinishAddElementPHP($ddm_group, $element, $options);
				}

				foreach ($this->getFinishElements($ddm_group) as $element=>$options) {
					$this->parseFinishAddElementPHP($ddm_group, $element, $options);
				}

				foreach ($this->getAfterFinishElements($ddm_group) as $element=>$options) {
					$this->parseFinishAddElementPHP($ddm_group, $element, $options);
				}
			}
		}
	} else {
		osW_MessageStack::getInstance()->addSession('session', 'error', ['msg'=>$this->getGroupMessage($ddm_group, 'add_load_error_title')]);
		$this->direct($ddm_group, $this->getDirectModule($ddm_group), $this->getDirectParameters($ddm_group));
	}
}

// Edit
if ((osW_Settings::getInstance()->getAction()=='edit')||(osW_Settings::getInstance()->getAction()=='doedit')) {
	$this->setIndexElementStorage($ddm_group, h()->_catch($this->getGroupOption($ddm_group, 'index', 'database'), '', 'pg'));

	$database_where_string='';
	$ddm_filter_array=$this->getGroupOption($ddm_group, 'filter', 'database');
	if (($ddm_filter_array!='')&&($ddm_filter_array!=[])) {
		$ddm_filter=[];
		foreach ($ddm_filter_array as $filter) {
			$ar_values=[];
			foreach ($filter as $logic=>$elements) {
				foreach ($elements as $element) {
					$ar_values[]=$this->getGroupOption($ddm_group, 'alias', 'database').'.'.$element['key'].$element['operator'].$element['value'];
				}
			}
			$ddm_filter[]='('.implode(' '.strtoupper($logic).' ', $ar_values).')';
		}
		$database_where_string.=' AND ('.implode(' OR ', $ddm_filter).')';
	}

	$QloadData=osW_Database::getInstance()->query('SELECT :vars: FROM :table: AS :alias: WHERE :name_index:=:value_index: :where:');
	$QloadData->bindTable(':table:', $this->getGroupOption($ddm_group, 'table', 'database'));
	$QloadData->bindRaw(':alias:', $this->getGroupOption($ddm_group, 'alias', 'database'));
	$QloadData->bindRaw(':vars:', $this->getGroupOption($ddm_group, 'alias', 'database').'.'.implode(', '.$this->getGroupOption($ddm_group, 'alias', 'database').'.', $this->getEditElementsName($ddm_group)));
	$QloadData->bindRaw(':name_index:', $this->getGroupOption($ddm_group, 'alias', 'database').'.'.$this->getGroupOption($ddm_group, 'index', 'database'));
	if ($this->getGroupOption($ddm_group, 'db_index_type', 'database')=='string') {
		$QloadData->bindValue(':value_index:', $this->getIndexElementStorage($ddm_group));
	} else {
		$QloadData->bindInt(':value_index:', $this->getIndexElementStorage($ddm_group));
	}
	$QloadData->bindRaw(':where:', $database_where_string);
	$QloadData->execute();
	if ($QloadData->query_handler===false) {
		print_a($QloadData);
	}

	if ($QloadData->numberOfRows()===1) {
		$QloadData->next();
		foreach ($this->getEditElements($ddm_group) as $element=>$element_details) {
			if ((isset($element_details['name']))&&($element_details['name']!='')) {
				$this->setEditElementStorage($ddm_group, $element, $QloadData->Value($element_details['name']));
			}
			if ((isset($element_details['name_array']))&&($element_details['name_array']!=[])) {
				foreach ($element_details['name_array'] as $_name) {
					if ($element_details['options']['prefix']!='') {
						$this->setEditElementStorage($ddm_group, $element_details['options']['prefix'].$_name, $QloadData->Value($element_details['options']['prefix'].$_name));
					} else {
						$this->setEditElementStorage($ddm_group, $element.'_'.$_name, $QloadData->Value($_name));
					}
				}
			}
		}
	} else {
		osW_MessageStack::getInstance()->addSession('session', 'error', ['msg'=>$this->getGroupMessage($ddm_group, 'edit_load_error_title')]);
		$this->direct($ddm_group, $this->getDirectModule($ddm_group), $this->getDirectParameters($ddm_group));
	}

	foreach ($this->getEditElements($ddm_group) as $element=>$options) {
		$this->parseFormEditElementPHP($ddm_group, $element, $options);
	}

	if (osW_Settings::getInstance()->getAction()=='doedit') {
		if (strlen(h()->_catch('btn_ddm_cancel', '', 'p'))>0) {
			osW_Settings::getInstance()->setAction('');
			$_POST=[];
		}
	}

	if (osW_Settings::getInstance()->getAction()=='doedit') {
		foreach ($this->getEditElements($ddm_group) as $element=>$options) {
			$options=$this->getEditElementValue($ddm_group, $element, 'validation');
			if ($options!='') {
				$this->parseParserEditElementPHP($ddm_group, $element, $options);
			}
		}

		if (osW_MessageStack::getInstance()->size('form')) {
			osW_Settings::getInstance()->setAction('edit');
		} else {
			foreach ($this->getEditElements($ddm_group) as $element=>$options) {
				$this->parseFinishEditElementPHP($ddm_group, $element, $options);
			}

			foreach ($this->getFinishElements($ddm_group) as $element=>$options) {
				$this->parseFinishEditElementPHP($ddm_group, $element, $options);
			}

			foreach ($this->getAfterFinishElements($ddm_group) as $element=>$options) {
				$this->parseFinishEditElementPHP($ddm_group, $element, $options);
			}
		}
	}
}

// Delete
if ((osW_Settings::getInstance()->getAction()=='delete')||(osW_Settings::getInstance()->getAction()=='dodelete')) {
	$this->setIndexElementStorage($ddm_group, h()->_catch($this->getGroupOption($ddm_group, 'index', 'database'), '', 'pg'));

	$database_where_string='';
	if (($ddm_filter_array!='')&&($ddm_filter_array!=[])) {
		$ddm_filter=[];
		foreach ($ddm_filter_array as $filter) {
			$ar_values=[];
			foreach ($filter as $logic=>$elements) {
				foreach ($elements as $element) {
					$ar_values[]=$this->getGroupOption($ddm_group, 'alias', 'database').'.'.$element['key'].$element['operator'].$element['value'];
				}
			}
			$ddm_filter[]='('.implode(' '.strtoupper($logic).' ', $ar_values).')';
		}
		$database_where_string.=' AND ('.implode(' OR ', $ddm_filter).')';
	}

	$QloadData=osW_Database::getInstance()->query('SELECT :vars: FROM :table: AS :alias: WHERE :name_index:=:value_index: :where:');
	$QloadData->bindTable(':table:', $this->getGroupOption($ddm_group, 'table', 'database'));
	$QloadData->bindRaw(':alias:', $this->getGroupOption($ddm_group, 'alias', 'database'));
	$QloadData->bindRaw(':vars:', $this->getGroupOption($ddm_group, 'alias', 'database').'.'.implode(', '.$this->getGroupOption($ddm_group, 'alias', 'database').'.', $this->getDeleteElementsName($ddm_group)));
	$QloadData->bindRaw(':name_index:', $this->getGroupOption($ddm_group, 'alias', 'database').'.'.$this->getGroupOption($ddm_group, 'index', 'database'));
	if ($this->getGroupOption($ddm_group, 'db_index_type', 'database')=='string') {
		$QloadData->bindValue(':value_index:', $this->getIndexElementStorage($ddm_group));
	} else {
		$QloadData->bindInt(':value_index:', $this->getIndexElementStorage($ddm_group));
	}
	$QloadData->bindRaw(':where:', $database_where_string);
	$QloadData->execute();
	if ($QloadData->query_handler===false) {
		print_a($QloadData);
	}

	if ($QloadData->numberOfRows()===1) {
		$QloadData->next();
		foreach ($this->getDeleteElements($ddm_group) as $element=>$element_details) {
			if ((isset($element_details['name']))&&($element_details['name']!='')) {
				$this->setDeleteElementStorage($ddm_group, $element, $QloadData->Value($element_details['name']));
			}
			if ((isset($element_details['name_array']))&&($element_details['name_array']!=[])) {
				foreach ($element_details['name_array'] as $_name) {
					if ($element_details['options']['prefix']!='') {
						$this->setDeleteElementStorage($ddm_group, $element.'_'.$element_details['options']['prefix'].$_name, $QloadData->Value($element_details['options']['prefix'].$_name));
					} else {
						$this->setDeleteElementStorage($ddm_group, $element.'_'.$_name, $QloadData->Value($_name));
					}
				}
			}
		}
	} else {
		osW_MessageStack::getInstance()->addSession('session', 'error', ['msg'=>$this->getGroupMessage($ddm_group, 'delete_load_error_title')]);
		$this->direct($ddm_group, $this->getDirectModule($ddm_group), $this->getDirectParameters($ddm_group));
	}

	foreach ($this->getDeleteElements($ddm_group) as $element=>$options) {
		$this->parseFormDeleteElementPHP($ddm_group, $element, $options);
	}

	if (osW_Settings::getInstance()->getAction()=='dodelete') {
		if (strlen(h()->_catch('btn_ddm_cancel', '', 'p'))>0) {
			osW_Settings::getInstance()->setAction('');
			$_POST=[];
		}
	}

	if (osW_Settings::getInstance()->getAction()=='dodelete') {
		if (osW_MessageStack::getInstance()->size('form')) {
			osW_Settings::getInstance()->setAction('delete');
		} else {
			foreach ($this->getDeleteElements($ddm_group) as $element=>$options) {
				$this->parseFinishDeleteElementPHP($ddm_group, $element, $options);
			}

			foreach ($this->getFinishElements($ddm_group) as $element=>$options) {
				$this->parseFinishDeleteElementPHP($ddm_group, $element, $options);
			}

			foreach ($this->getAfterFinishElements($ddm_group) as $element=>$options) {
				$this->parseFinishDeleteElementPHP($ddm_group, $element, $options);
			}
		}
	}
}

// List
if (osW_Settings::getInstance()->getAction()=='') {
	if ($this->getCounter($ddm_group, 'search_elements')>0) {
		$ddm_search=h()->_catch('ddm_search', 0, 'gp');
		if (intval($ddm_search)==1) {
			$this->addParameter($ddm_group, 'ddm_search', 1);
		}
		if (strlen(h()->_catch('btn_ddm_cancel_search', '', 'p'))>0) {
			$this->removeParameter($ddm_group, 'ddm_search');
		}

		if ($this->getParameter($ddm_group, 'ddm_search')===1) {
			foreach ($this->getSearchElements($ddm_group) as $element=>$options) {
				$this->parseFormSearchElementPHP($ddm_group, $element, $options);
				$this->setSearchElementStorage($ddm_group, $element, $this->getSearchElementOption($ddm_group, $element, 'default_value'));
			}
		}
	}

	foreach ($this->getViewElements($ddm_group) as $element=>$options) {
		$this->parseViewElementPHP($ddm_group, $element, $options);
	}

	if ($this->getParameter($ddm_group, 'ddm_search')==1) {
		$data=[];
		$ddm_search=h()->_catch('ddm_search', 0, 'gp');
		if ($ddm_search==1) {
			foreach ($this->getSearchElementsValue($ddm_group, 'name') as $element) {
				$form_data=h()->_catch($element, '', 'pg');
				if (strlen($form_data)>0) {
					$data[$element]=$form_data;
				}
			}
			$this->setParameter($ddm_group, 'ddm_search_data', $data);
		}

		$ddm_search_data=$this->getParameter($ddm_group, 'ddm_search_data');
		foreach ($this->getSearchElementsValue($ddm_group, 'name') as $element) {
			if (isset($ddm_search_data[$element])) {
				$this->setSearchElementStorage($ddm_group, $element, $ddm_search_data[$element]);
			}
		}
	}

	// set order
	$_order=[];
	foreach ($this->getListElements($ddm_group) as $element=>$element_details) {
		if ((isset($element_details['options']))&&(isset($element_details['options']['order']))&&($element_details['options']['order']==true)) {
			if (isset($element_details['name'])) {
				$_order[$element_details['name']]=$element_details['name'];
			}
		}

		if (isset($element_details['name_array'])) {
			foreach ($element_details['name_array'] as $name) {
				if ($element_details['options']['prefix']!='') {
					$_order[$element_details['options']['prefix'].$name]=$element_details['options']['prefix'].$name;
				} else {
					$_order[$name]=$name;
				}
			}
		}
	}

	$ddm_order=h()->_catch('ddm_order', '', 'gp');
	if (strlen($ddm_order)>0) {
		$ddm_order_array=$this->getParameter($ddm_group, 'ddm_order');
		if (($ddm_order_array!='')&&($ddm_order_array!=[])) {
			$ddm_order_array=array_reverse($ddm_order_array);
		}
		preg_match('/(.*)\.(.*)__(.*)/', $ddm_order, $result);
		if (count($result)==4) {
			if (isset($_order[$result[2]])===true) {
				if (isset($ddm_order_array[$result[1].'.'.$result[2]])) {
					unset($ddm_order_array[$result[1].'.'.$result[2]]);
				}
				$result[3]=strtoupper($result[3]);
				if (($result[3]=='ASC')||($result[3]=='DESC')) {
					$this->setParameter($ddm_group, 'ddm_order_last', $ddm_order);
					$ddm_order_array[$result[1].'.'.$result[2]]=$result[3];
				}
			}
		}
		if (($ddm_order_array=='')||($ddm_order_array==[])) {
			foreach (array_reverse($this->getGroupOption($ddm_group, 'order', 'database')) as $key=>$order) {
				$ddm_order_array[$this->getGroupOption($ddm_group, 'alias', 'database').'.'.$key]=strtoupper($order);
				$this->setParameter($ddm_group, 'ddm_order_last', $this->getGroupOption($ddm_group, 'alias', 'database').'.'.$key.'__'.$order);
			}
			$this->setParameter($ddm_group, 'ddm_order', array_reverse($ddm_order_array));
		}
		$this->setParameter($ddm_group, 'ddm_order', array_reverse($ddm_order_array));
	} else {
		$ddm_order_array=$this->getParameter($ddm_group, 'ddm_order');
		if ($ddm_order_array=='') {
			$ddm_order_array=[];
		}
		if ($ddm_order_array!=[]) {
			$ddm_order_array=array_reverse($ddm_order_array);
		}
		if ($ddm_order_array==[]) {
			foreach (array_reverse($this->getGroupOption($ddm_group, 'order', 'database')) as $key=>$order) {
				$ddm_order_array[$this->getGroupOption($ddm_group, 'alias', 'database').'.'.$key]=strtoupper($order);
				$this->setParameter($ddm_group, 'ddm_order_last', $this->getGroupOption($ddm_group, 'alias', 'database').'.'.$key.'__'.$order);
			}
			if (count($ddm_order_array)>0) {
				$this->setParameter($ddm_group, 'ddm_order', array_reverse($ddm_order_array));
			} else {
				$this->setParameter($ddm_group, 'ddm_order', $ddm_order_array);
			}
		}
	}

	// set page
	$ddm_page=h()->_catch('ddm_page', '', 'gp');
	if ((strlen($ddm_page)>0)&&(intval($ddm_page)>0)) {
		$this->addParameter($ddm_group, 'ddm_page', $ddm_page);
	}
	$_GET['ddm_page']=$this->getParameter($ddm_group, 'ddm_page');

	// get search and filter
	if ($this->getCounter($ddm_group, 'search_elements')>0) {
		if ($this->getParameter($ddm_group, 'ddm_search')==1) {
			foreach ($this->getSearchElementsValue($ddm_group, 'name') as $element) {
				$options=$this->getSearchElementValue($ddm_group, $element, 'validation');
				if ($options!='') {
					$this->parseParserSearchElementPHP($ddm_group, $element, $options);
				}
			}
		}
	}

	if ($this->getDataBaseElementsStorage($ddm_group)==[]) {
		$database_where_string='1';
	} else {
		$database_where_string=implode(' AND ', $this->getDataBaseElementsStorage($ddm_group));
	}

	$ddm_filter_array=$this->getGroupOption($ddm_group, 'filter', 'database');

	if (($ddm_filter_array!='')&&($ddm_filter_array!=[])) {
		$ddm_filter=[];
		foreach ($ddm_filter_array as $filter) {
			$ar_values=[];
			foreach ($filter as $logic=>$elements) {
				foreach ($elements as $element) {
					$ar_values[]=$this->getGroupOption($ddm_group, 'alias', 'database').'.'.$element['key'].$element['operator'].$element['value'];
				}
			}
			$ddm_filter[]='('.implode(' '.strtoupper($logic).' ', $ar_values).')';
		}
		$ddm_filter_logic=$this->getGroupOption($ddm_group, 'filter_logic', 'database');
		switch (strtoupper($ddm_filter_logic)) {
			case 'AND':
				break;
			default:
				$ddm_filter_logic='OR';
				break;
		}
		$database_where_string.=' AND ('.implode(' '.$ddm_filter_logic.' ', $ddm_filter).')';
	}

	// get order
	$ddm_order_array=$this->getParameter($ddm_group, 'ddm_order');
	$ddm_order_case_array=$this->getGroupOption($ddm_group, 'order_case', 'database');
	$ddm_order_case_array_new=[];
	if ((is_array($ddm_order_case_array))&&($ddm_order_case_array!=[])) {
		foreach ($ddm_order_case_array as $key=>$value) {
			$ddm_order_case_array_new[$this->getGroupOption($ddm_group, 'alias', 'database').'.'.$key]=$value;
		}
		$ddm_order_case_array=$ddm_order_case_array_new;
	} else {
		$ddm_order_case_array=[];
	}
	$database_order_string='';
	$database_order_array=[];
	if (($ddm_order_array!='')&&($ddm_order_array!=[])) {
		foreach ($ddm_order_array as $key=>$order) {
			if (isset($ddm_order_case_array[$key])) {
				$sql='';
				$sql.='CASE '.$key.' ';
				$i=0;
				foreach ($ddm_order_case_array[$key] as $k=>$v) {
					$i++;
					$sql.='WHEN '.h()->_escapeString($k).' THEN '.$i.' ';
				}
				$sql.='END';
				$database_order_array[]=$sql;
			} else {
				$database_order_array[]=$key.' '.$order;
			}
		}
	}

	if (($database_order_array!='')&&($database_order_array!=[])) {
		$database_order_string=' ORDER BY '.implode(', ', $database_order_array);
	}

	$vars=[];
	foreach ($this->getListElements($ddm_group) as $element=>$element_details) {
		if ((isset($element_details['name']))&&($element_details['name']!='')) {
			$vars[]=$element_details['name'];
		}

		if (isset($element_details['name_array'])) {
			foreach ($element_details['name_array'] as $name) {
				if ($element_details['options']['prefix']!='') {
					$vars[]=$element_details['options']['prefix'].$name;
				} else {
					$vars[]=$name;
				}
			}
		}
	}

	// Daten fue die Liste laden
	$QgetData=osW_Database::getInstance()->query('SELECT :vars: FROM :table: AS :alias: WHERE :where: :order:');
	$QgetData->bindRaw(':vars:', $this->getGroupOption($ddm_group, 'alias', 'database').'.'.implode(', '.$this->getGroupOption($ddm_group, 'alias', 'database').'.', $vars));
	$QgetData->bindTable(':table:', $this->getGroupOption($ddm_group, 'table', 'database'));
	$QgetData->bindRaw(':alias:', $this->getGroupOption($ddm_group, 'alias', 'database'));
	$QgetData->bindRaw(':where:', $database_where_string);
	$QgetData->bindRaw(':order:', $database_order_string);
	$QgetData->setPrimaryKey($this->getGroupOption($ddm_group, 'alias', 'database').'.'.$this->getGroupOption($ddm_group, 'index', 'database'));
	$QgetData->bindLimit($this->getGroupOption($ddm_group, 'elements_per_page', 'general'), 0, 5, 'ddm_page');
	$QgetData->execute();
	if ($QgetData->query_handler===false) {
		print_a($QgetData);
	}

	if ($QgetData->numberOfRows()>0) {
		$this->ddm[$ddm_group]['storage']['view']=[];
		$this->ddm[$ddm_group]['storage']['view']['data']=[];
		while ($QgetData->next()) {
			$this->incCounter($ddm_group, 'storage_view_elements');
			$this->ddm[$ddm_group]['storage']['view']['data'][]=$QgetData->result;
		}
		$this->addParameter($ddm_group, 'ddm_page', $QgetData->limitrows['current_page_number']);
		$this->ddm[$ddm_group]['storage']['view']['limitrows']=$QgetData->limitrows;
	} else {
		$this->ddm[$ddm_group]['storage']['view']['data']=[];
		$this->ddm[$ddm_group]['storage']['view']['limitrows']=[];
	}
}

$this->storeParameters($ddm_group);

?>