<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/**
 * Lädt Klassen automatisch, so bald sie benötigt werden
 *
 * @access public
 * @param string Name der Klasse
 */
function autoloader($class_name) {
	$class_name_org=$class_name;
	$class_name=strtolower($class_name);
	$frame_class=false;
	if ((($class_name=='osw_object')||($class_name=='osw_settings'))||(in_array(substr($class_name, 0, strpos($class_name, '_')), osW_Settings::getInstance()->getFrameClassPrefixArray()))) {
		$frame_class=true;
	}

	if (($class_name=='osw_object')||($class_name=='osw_settings')) {
		include(settings_abspath.'frame/classes/'.$class_name.'.php');
	} elseif ((strlen(vOut('frame_default_module'))>0)&&(file_exists(settings_abspath.'modules/'.vOut('frame_current_module').'/autoloader/classes.inc.php'))) {
		include(settings_abspath.'modules/'.vOut('frame_current_module').'/autoloader/classes.inc.php');
	} elseif (file_exists(settings_abspath.'modules/'.vOut('project_default_module').'/autoloader/classes.inc.php')) {
		include(settings_abspath.'modules/'.vOut('project_default_module').'/autoloader/classes.inc.php');
	} else {
		include(settings_abspath.'frame/autoloader/classes.inc.php');
	}
}

spl_autoload_register('autoloader');

/**
 * Referenz auf die Klasse osW_Helper
 *
 * @access public
 * @return object Objekt der Klasse osW_Helper
 */
function h() {
	return osW_Helper::getInstance();
}

/**
 * Gibt eine Konfigurationsvariable aus
 *
 * @access public
 * @param string Name der Konfigurationsvariable
 * @return mixed Wert der Konfigurationsvariable
 */
function vOut($varName) {
	return osW_Settings::getInstance()->__get($varName);
}

/**
 * Gibt eine Sprachvariable aus
 *
 * @access public
 * @param string Name der Sprachvariable
 * @param string Prefix der Sprachvariable
 * @param boolean Text zur HTML-Ausgabe konvertieren
 * @return string Ausgabe der Sprachvariable
 */
function tOut($varName, $prefix='', $convert=true) {
	if ($convert===true) {
		return h()->_outputString(osW_Language::getInstance()->getLanguageVar($varName, $prefix));
	} else {
		return osW_Language::getInstance()->getLanguageVar($varName, $prefix);
	}
}

/**
 * Gibt eine Sprachvariable mit Zählerstand aus (z.B: Seite 9 von 23)
 *
 * @access public
 * @param string Aktuelle Zähler
 * @param string Maximale Zähler
 * @param string Name der Sprachvariable
 * @param string Prefix der Sprachvariable
 * @param boolean Text zur HTML-Ausgabe konvertieren
 * @return string Ausgabe der Sprachvariable
 */
function tOutMulti($count, $countmax, $varName, $prefix='', $convert=true) {
	$multi=[];
	$multi['count']=$count;
	$multi['countmax']=$countmax;

	if ($count!=1) {
		$varName.='_multi';
	}

	if ($convert===true) {
		return h()->_outputString(h()->_setText(osW_Language::getInstance()->getLanguageVar($varName, $prefix), $multi));
	} else {
		return h()->_setText(osW_Language::getInstance()->getLanguageVar($varName, $prefix), $multi);
	}
}

/**
 * Alias für die Methode tOut ohne Konvertierung der HTML-Ausgabe
 *
 * @access public
 * @param string Name der Sprachvariable
 * @param string Prefix der Sprachvariable
 * @return string Ausgabe der Sprachvariable
 */
function tnOut($varName, $prefix='') {
	return tOut($varName, $prefix, false);
}

/**
 * Alias für die Methode tOutMulti ohne Konvertierung der HTML-Ausgabe
 *
 * @access public
 * @param string Aktuelle Zähler
 * @param string Maximale Zähler
 * @param string Name der Sprachvariable
 * @param string Prefix der Sprachvariable
 * @return string Ausgabe der Sprachvariable
 */
function tnOutMulti($count, $constant, $default='') {
	return tOutMulti($count, $countmax, $varName, $prefix='', false);
}

/**
 * print to file
 *
 * @access public
 * @param string Daten
 * @param string Datei
 * @param boolean Daten an die Datei anhängen
 * @return boolean true wenn erfolgreich
 */
function print_f($data, $file='default.log', $append=true) {
	$dir=vOut('settings_abspath').vOut('debug_path').'/php/';
	h()->_mkdir($dir);
	$file=$dir.$file;
	if (is_array($data)===true) {
		if ($append===true) {
			file_put_contents($file, print_r($data, true)."\n", FILE_APPEND);
		} else {
			file_put_contents($file, print_r($data, true)."\n");
		}
	} else {
		if ($append===true) {
			file_put_contents($file, $data."\n", FILE_APPEND);
		} else {
			file_put_contents('test.log', $data."\n");
		}
	}

	return true;
}

?>