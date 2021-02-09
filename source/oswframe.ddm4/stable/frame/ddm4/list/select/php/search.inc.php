<?php

$data=$this->getListElementOption($ddm_group, $key, 'data');

if (count(array_filter(array_keys($data), 'is_string'))>0) {
	$ddm_search_case_array[]=$this->getGroupOption($ddm_group, 'alias', 'database').'.'.$key.' LIKE \'%'.osW_Database::getInstance()->escape_string($search['value']).'%\'';
} else {
	$ids=array();
	if (($data!=array())&&($data!='')) {
		foreach ($data as $_key => $_value) {
			if (intval($_key)==$_key) {
				if (stristr($_value, $search['value'])!==false) {
					$ids[]=$_key;
				}
			}
		}
	}

	if ($ids!=array()) {
		$ddm_search_case_array[]=$this->getGroupOption($ddm_group, 'alias', 'database').'.'.$key.' IN ('.implode(',', $ids).')';
	}
}

?>