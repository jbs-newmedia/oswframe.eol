<?php

/**
 *
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */
class osW_Form extends osW_Object {

	/* PROPERTIES */
	private $hidden_fields=[];

	private $forms=[];

	private $formerrors=[];

	private $count=[];

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */

	// HiddenField
	function drawHiddenField($name, $value, $reinsert=false) {
		$this->hidden_fields[]=['name'=>$name, 'value'=>$value, 'reinsert'=>$reinsert];
	}

	// TextField
	function drawTextField($name, $value='', $options=[]) {
		$options['input_type']='text';

		return $this->createInputField($name, $value, $options);
	}

	// PasswordField
	function drawPasswordField($name, $value='', $options=[]) {
		$options['input_type']='password';

		return $this->createInputField($name, $value, $options);
	}

	// FileField
	function drawFileField($name, $value='', $options=[]) {
		$options['input_type']='file';

		return $this->createInputField($name, $value, $options);
	}

	// TextareaField
	function drawTextareaField($name, $value='', $options=[]) {
		$options['input_type']='textarea';

		return $this->createTextField($name, $value, $options);
	}

	// RadioField
	function drawRadioField($name, $value, $selected='', $options=[]) {
		$options['input_type']='radio';

		return $this->createSelectionField($name, $value, $selected, $options);
	}

	// CheckboxField
	function drawCheckboxField($name, $value, $selected='', $options=[]) {
		$options['input_type']='checkbox';

		return $this->createSelectionField($name, $value, $selected, $options);
	}

	// SelectField
	function drawSelectField($name, $values, $selected='', $options=[]) {
		$options['input_type']='select';

		return $this->createListField($name, $values, $selected, $options);
	}

	// ListField
	function drawListField($name, $values, $selected='', $options=[]) {
		$options['input_type']='list';

		return $this->createListField($name, $values, $selected, $options);
	}

	// MultipleListField
	function drawMultipleListField($name, $values, $selected='', $options=[]) {
		$options['input_type']='multilist';

		return $this->createListField($name, $values, $selected, $options);
	}

	// drawSubmit
	function drawSubmit($name, $value, $options=[]) {
		$options['input_type']='submit';

		return $this->createSubmit($name, $value, $options);
	}

	// drawReset
	function drawReset($name, $value, $options=[]) {
		$options['input_type']='reset';

		return $this->createSubmit($name, $value, $options);
	}

	// drawImageSubmit
	function drawImageSubmit($name, $value, $options=[]) {
		$options['input_type']='image';

		return $this->createSubmit($name, $value, $options);
	}

	private function createInputField($name, $value, $options) {
		$field='';

		if (!isset($options['input_type'])) {
			$options['input_type']='text';
		} else {
			switch ($options['input_type']) {
				case 'password' :
					break;
				case 'file' :
					break;
				case 'text' :
				default :
					$options['input_type']='text';
			}
		}

		if (!isset($options['input_errorclass'])) {
			$options['input_errorclass']='oswerror';
		}

		if (!isset($options['input_addid'])) {
			$options['input_addid']=true;
		}

		if (!isset($options['reinsert_value'])) {
			$options['reinsert_value']=true;
		}

		if (!isset($options['input_error'])) {
			$options['input_error']=true;
		}

		if ((!isset($options['input_id']))&&($options['input_addid']===true)) {
			$options['input_id']=h()->_outputString($name);
		}

		$field.='<input type="'.$options['input_type'].'" name="'.h()->_outputString($name).'"';

		if ($options['input_addid']===true) {
			$field.=' id="'.$options['input_id'].'"';
		}

		if (isset($options['input_class'])) {
			if ($options['input_error']===true) {
				if ($this->getFormError($name)===true) {
					$field.=' class="'.h()->_outputString($options['input_class']).' '.$options['input_errorclass'].'"';
				} else {
					$field.=' class="'.h()->_outputString($options['input_class']).'"';
				}
			} else {
				$field.=' class="'.h()->_outputString($options['input_class']).'"';
			}
		} else {
			if ($this->getFormError($name)===true) {
				$field.=' class="'.$options['input_errorclass'].'"';
			}
		}

		if ($options['reinsert_value']===true) {
			if (isset($_GET[$name])) {
				$value=$_GET[$name];
			} elseif (isset($_POST[$name])) {
				$value=$_POST[$name];
			}
		}

		$value=trim($value);

		if (strlen($value)>0) {
			$field.=' value="'.h()->_outputString($value).'"';
		}

		if (isset($options['input_parameter'])) {
			$field.=' '.$options['input_parameter'];
		}

		$field.='/>';

		return $field;
	}

	private function createTextField($name, $value, $options) {
		$field='';

		osW_Template::getInstance()->setUsedTextAreas(true);

		if (!isset($options['input_type'])) {
			$options['input_type']='textarea';
		} else {
			switch ($options['input_type']) {
				case 'textarea' :
				default :
					$options['input_type']='textarea';
			}
		}

		if (!isset($options['input_errorclass'])) {
			$options['input_errorclass']='oswerror';
		}

		if (!isset($options['input_addid'])) {
			$options['input_addid']=true;
		}

		if (!isset($options['reinsert_value'])) {
			$options['reinsert_value']=true;
		}

		if (!isset($options['input_error'])) {
			$options['input_error']=true;
		}

		if ((!isset($options['input_id']))&&($options['input_addid']===true)) {
			$options['input_id']=h()->_outputString($name);
		}

		$field.='<textarea name="'.h()->_outputString($name).'"';

		if ($options['input_addid']===true) {
			$field.=' id="'.$options['input_id'].'"';
		}
		if (isset($options['input_class'])) {
			if ($options['input_error']===true) {
				if ($this->getFormError($name)===true) {
					$field.=' class="'.h()->_outputString($options['input_class']).' '.$options['input_errorclass'].'"';
				} else {
					$field.=' class="'.h()->_outputString($options['input_class']).'"';
				}
			} else {
				$field.=' class="'.h()->_outputString($options['input_class']).'"';
			}
		} else {
			if ($this->getFormError($name)===true) {
				$field.=' class="'.$options['input_errorclass'].'"';
			}
		}

		if ($options['reinsert_value']===true) {
			if (isset($_GET[$name])) {
				$value=$_GET[$name];
			} elseif (isset($_POST[$name])) {
				$value=$_POST[$name];
			}
		}

		$value=trim($value);

		if (isset($options['input_parameter'])) {
			$field.=' '.$options['input_parameter'];
		}

		$field.='>';

		if (strlen($value)>0) {
			$field.=htmlspecialchars($value);
		}

		$field.='</textarea>';

		return $field;
	}

	private function createSelectionField($name, $value, $selected, $options) {
		$field='';

		if (!isset($options['input_type'])) {
			$options['input_type']='checkbox';
		} else {
			switch ($options['input_type']) {
				case 'radio' :
					break;
				case 'checkbox' :
				default :
					$options['input_type']='checkbox';
			}
		}

		if (!isset($this->count[$name])) {
			$this->count[$name]=0;
		} else {
			$this->count[$name]++;
		}

		if (!isset($options['input_errorclass'])) {
			$options['input_errorclass']='oswerror';
		}

		if (!isset($options['input_addid'])) {
			$options['input_addid']=true;
		}

		if (!isset($options['reinsert_value'])) {
			$options['reinsert_value']=true;
		}

		if (!isset($options['input_error'])) {
			$options['input_error']=true;
		}

		if ((!isset($options['input_id']))&&($options['input_addid']===true)) {
			$options['input_id']=h()->_outputString($name).$this->count[$name];
		}

		$field.='<input type="'.$options['input_type'].'" name="'.h()->_outputString($name).'"';

		if ($options['input_addid']===true) {
			$field.=' id="'.$options['input_id'].'"';
		}

		if (isset($options['input_class'])) {
			if ($options['input_error']===true) {
				if ($this->getFormError($name)===true) {
					$field.=' class="'.h()->_outputString($options['input_class']).' '.$options['input_errorclass'].'"';
				} else {
					$field.=' class="'.h()->_outputString($options['input_class']).'"';
				}
			} else {
				$field.=' class="'.h()->_outputString($options['input_class']).'"';
			}
		} else {
			if ($this->getFormError($name)===true) {
				$field.=' class="'.$options['input_errorclass'].'"';
			}
		}

		if ($options['reinsert_value']===true) {
			if (isset($_GET[$name])) {
				$selected=$_GET[$name];
			} elseif (isset($_POST[$name])) {
				$selected=$_POST[$name];
			}
		} else {
		}

		$value=trim($value);

		if (strlen($value)>0) {
			$field.=' value="'.h()->_outputString($value).'"';
		}

		if (($selected==$value)&&(strlen($selected)==strlen($value))) {
			$field.=' checked="checked"';
		}

		if (isset($options['input_parameter'])) {
			$field.=' '.$options['input_parameter'];
		}

		$field.='/>';

		return $field;
	}

	private function createListField($name, $values, $selected, $options) {
		$field='';

		if (count($values)==0) {
			$values=[];
		}

		if (!isset($options['input_type'])) {
			$options['input_type']='select';
		} else {
			switch ($options['input_type']) {
				case 'list' :
					if (!isset($options['input_listsize'])) {
						$options['input_listsize']=count($values);
						if (!isset($options['input_parameter'])) {
							$options['input_parameter']=' size="'.$options['input_listsize'].'"';
						} else {
							$options['input_parameter'].=' size="'.$options['input_listsize'].'"';
						}
					}
					break;
				case 'multilist' :
					if (!isset($options['input_parameter'])) {
						$options['input_parameter']=' multiple="multiple"';
					} else {
						$options['input_parameter'].=' multiple="multiple"';
					}
					break;
				case 'select' :
				default :
					$options['input_type']='select';
			}
		}

		if (!isset($options['input_errorclass'])) {
			$options['input_errorclass']='oswerror';
		}

		if (!isset($options['input_addid'])) {
			$options['input_addid']=true;
		}

		if (!isset($options['input_option_value'])) {
			$options['input_option_value']='value';
		}

		if (!isset($options['reinsert_value'])) {
			$options['reinsert_value']=true;
		}

		if (!isset($options['input_error'])) {
			$options['input_error']=true;
		}

		if ((!isset($options['input_id']))&&($options['input_addid']===true)) {
			$options['input_id']=h()->_outputString($name);
		}

		switch ($options['input_type']) {
			case 'multilist' :
				$field.='<select name="'.h()->_outputString($name).'[]"';
				break;
			case 'list' :
			case 'select' :
			default :
				$field.='<select name="'.h()->_outputString($name).'"';
		}

		if ($options['input_addid']===true) {
			$field.=' id="'.$options['input_id'].'"';
		}

		if (isset($options['input_parameter'])) {
			$field.=' '.$options['input_parameter'];
		}

		if (isset($options['input_class'])) {
			if ($options['input_error']===true) {
				if ($this->getFormError($name)===true) {
					$field.=' class="'.h()->_outputString($options['input_class']).' '.$options['input_errorclass'].'"';
				} else {
					$field.=' class="'.h()->_outputString($options['input_class']).'"';
				}
			} else {
				$field.=' class="'.h()->_outputString($options['input_class']).'"';
			}
		} else {
			if ($this->getFormError($name)===true) {
				$field.=' class="'.$options['input_errorclass'].'"';
			}
		}

		if ($options['reinsert_value']===true) {
			if (isset($_GET[$name])) {
				$selected=$_GET[$name];
			} elseif (isset($_POST[$name])) {
				$selected=$_POST[$name];
			}
		}

		$field.='>';

		if ($options['input_type']=='multilist') {
			if (is_array($selected)) {
				$selected=array_flip($selected);
				foreach ($values as $key=>$value) {
					if ((is_array($value))&&(isset($value['value']))&&(isset($value['text']))) {
						$key=$value['value'];
						$value=$value['text'];
					}
					$label='';
					if ($value=='') {
						$label=' label="Bitte wählen..."';
					}
					if (isset($selected[$key])) {
						$field.='<option '.$options['input_option_value'].'="'.h()->_outputString($key).'"'.$label.' selected="selected">'.h()->_outputString($value).vOut('form_spacer').'</option>';
					} else {
						$field.='<option '.$options['input_option_value'].'="'.h()->_outputString($key).'"'.$label.'>'.h()->_outputString($value).vOut('form_spacer').'</option>';
					}
				}
			} else {
				foreach ($values as $key=>$value) {
					if ((is_array($value))&&(isset($value['value']))&&(isset($value['text']))) {
						$key=$value['value'];
						$value=$value['text'];
					}
					$label='';
					if ($value=='') {
						$label=' label="Bitte wählen..."';
					}
					if ($selected==$key) {
						$field.='<option '.$options['input_option_value'].'="'.h()->_outputString($key).'"'.$label.' selected="selected">'.h()->_outputString($value).vOut('form_spacer').'</option>';
					} else {
						$field.='<option '.$options['input_option_value'].'="'.h()->_outputString($key).'"'.$label.'>'.h()->_outputString($value).vOut('form_spacer').'</option>';
					}
				}
			}
		} else {
			$_selected=false;
			foreach ($values as $key=>$value) {
				if ((is_array($value))&&(isset($value['value']))&&(isset($value['text']))) {
					$key=$value['value'];
					$value=$value['text'];
				}
				$label='';
				if ($value=='') {
					$label=' label="Bitte wählen..."';
				}
				if (($selected==$key)&&($_selected!==true)) {
					$_selected=true;
					$field.='<option '.$options['input_option_value'].'="'.h()->_outputString($key).'"'.$label.' selected="selected">'.h()->_outputString($value).vOut('form_spacer').'</option>';
				} else {
					$field.='<option '.$options['input_option_value'].'="'.h()->_outputString($key).'"'.$label.'>'.h()->_outputString($value).vOut('form_spacer').'</option>';
				}
			}
		}

		$field.='</select>';

		return $field;
	}

	private function createSubmit($name, $value, $options) {
		$field='';

		if (!isset($options['input_type'])) {
			$options['input_type']='submit';
		} else {
			switch ($options['input_type']) {
				case 'image' :
					if (!isset($options['input_image'])) {
						$options['input_type']='submit';
					} else {
						if (!isset($options['input_parameter'])) {
							$options['input_parameter']=' src="'.osW_Template::getInstance()->getImagePath($options['input_image']).'"';
						} else {
							$options['input_parameter'].=' src="'.osW_Template::getInstance()->getImagePath($options['input_image']).'"';
						}
					}
					break;
				case 'reset' :
					$options['input_type']='reset';
					break;
				case 'submit' :
				default :
					$options['input_type']='submit';
			}
		}

		if (!isset($options['input_errorclass'])) {
			$options['input_errorclass']='oswerror';
		}

		if (!isset($options['input_addid'])) {
			$options['input_addid']=true;
		}

		if (!isset($options['input_error'])) {
			$options['input_error']=true;
		}

		if ((!isset($options['input_id']))&&($options['input_addid']===true)) {
			$options['input_id']=h()->_outputString($name);
		}

		$field.='<input type="'.$options['input_type'].'" name="'.h()->_outputString($name).'"';

		if ($options['input_addid']===true) {
			$field.=' id="'.$options['input_id'].'"';
		}

		if (isset($options['input_class'])) {
			if ($options['input_error']===true) {
				if ($this->getFormError($name)===true) {
					$field.=' class="'.h()->_outputString($options['input_class']).' '.$options['input_errorclass'].'"';
				} else {
					$field.=' class="'.h()->_outputString($options['input_class']).'"';
				}
			} else {
				$field.=' class="'.h()->_outputString($options['input_class']).'"';
			}
		} else {
			if ($this->getFormError($name)===true) {
				$field.=' class="'.$options['input_errorclass'].'"';
			}
		}

		if ($options['input_type']=='image') {
		} else {
			$field.=' title="'.h()->_outputString($value).'" value="'.h()->_outputString($value).'"';
		}

		if (isset($options['input_parameter'])) {
			$field.=' '.$options['input_parameter'];
		}

		$field.='/>';

		return $field;
	}

	function formStart($name, $action='current', $parameters='', $options=[]) {
		if (!isset($options['form_method'])) {
			$options['form_method']='post';
		} else {
			switch ($options['form_method']) {
				case 'get' :
					break;
				case 'post' :
				default :
					$options['form_method']='post';
			}
		}

		if (!isset($options['form_parameter'])) {
			$options['form_parameter']='';
		}

		if (!isset($options['input_addid'])) {
			$options['input_addid']=true;
		}

		if ((!isset($options['input_id']))&&($options['input_addid']===true)) {
			$options['input_id']=h()->_outputString($name);
		}

		$form='<form name="'.h()->_outputString($name).'"';
		if ($options['input_addid']===true) {
			$form.=' id="'.$options['input_id'].'"';
		}
		if (isset($options['form_action'])) {
			$form.=' action="'.$options['form_action'].'"';
		} else {
			$form.=' action="'.osW_Template::getInstance()->buildhrefLink($action, $parameters).'"';
		}
		$form.=' method="'.h()->_outputString($options['form_method']).'"';
		$form.=' '.$options['form_parameter'];
		$form.='>';

		return $form;
	}

	function formEnd() {
		$fieldstring='';

		if (h()->_notNull($this->hidden_fields)) {
			foreach ($this->hidden_fields as $field) {
				if ($field['reinsert']===true) {
					if (isset($_GET[$field['name']])) {
						$field['value']=$_GET[$field['name']];
					} elseif (isset($_POST[$field['name']])) {
						$field['value']=$_POST[$field['name']];
					}
				}
				$fieldstring.='<input type="hidden" name="'.h()->_outputString($field['name']).'"';
				if (isset($field['value'])) {
					$fieldstring.=' value="'.h()->_outputString($field['value'], false).'"';
				}
				if (!empty($field['parameters'])) {
					$fieldstring.=' '.$field['parameters'];
				}
				$fieldstring.='/>';
			}
		}
		$this->hidden_fields=[];

		return $fieldstring.'</form>';
	}

	function hasFormError() {
		if ($this->formerrors!=[]) {
			return true;
		}

		return false;
	}

	function addFormError($formfield, $message='') {
		$this->formerrors[$formfield]=$message;
	}

	function getFormError($formfield) {
		if (isset($this->formerrors[$formfield])) {
			return true;
		}

		return false;
	}

	function getFormErrorMessage($formfield) {
		if (isset($this->formerrors[$formfield])) {
			return $this->formerrors[$formfield];
		}

		return '';
	}

	/**
	 *
	 * @return osW_Form
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>