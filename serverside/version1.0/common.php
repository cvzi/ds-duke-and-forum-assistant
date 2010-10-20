<?php
/**
 * common.inc.php
 *
 *       ###packageName###
 *
 *  ###packageName### is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  ###packageName### is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with ###packageName###; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 *  For questions contact
 *  cuzi@openmail.cc
 *
 * @copyright 2011 cuzi
 * @author cuzi <cuzi@openmail.cc>
 * @package ###packageName###
 * @version 1.0
 * @license http://gnu.org/copyleft/gpl.html GNU GPL
 */

if(!$index)
    exit();

if (!$common_is_included_123456789) {
    $common_is_included_123456789 = true;

    require 'config.php';

    // autoload Funktion zum Nachladen der Klassendateien zur Laufzeit
    function __autoload($class_name) {
        global $include_path;
        require_once $include_path.$class_name.'.class.php';
    }

    // vermeidet Warnungen bei nicht definierten Variablen
    function check(&$var) {
        $var = isset($var) ? $var : null;
    }

    // Session
    session_start();

    // Weitere Ausgaben bzw. PHP Fehler abfangen
    ob_start();

    $errors = array(); // Array instead of Error Object
    $mysql = new mysql($errors, $MySQLHost, $MySQLName, $MySQLPassword, $MySQLDBName, false, false);
    unset($MySQLName);
    unset($MySQLPassword);

} else {
    
    // Buffer
    $buffer = ob_get_contents();
    if ($buffer) {
        $errors[] = "Unexpected PHP Output:\n$buffer";
    }

    ob_end_clean();
}

?>