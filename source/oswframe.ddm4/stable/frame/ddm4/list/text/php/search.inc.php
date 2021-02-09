<?php

$ddm_search_case_array[]=$this->getGroupOption($ddm_group, 'alias', 'database').'.'.$key.' LIKE \'%'.osW_Database::getInstance()->escape_string($search['value']).'%\'';

?>