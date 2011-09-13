<?php

/**
 * mysql.class.php
 *
 *       ds-duke-and-forum-assistant
 *
 *  UTF-8 encoded
 *
 *  ds-duke-and-forum-assistant is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  ds-duke-and-forum-assistant is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with ds-duke-and-forum-assistant; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 *  For questions contact
 *  cuzi@openmail.cc
 *
 * @copyright Copyright (c) 2011, cuzi
 * @author cuzi <cuzi@openmail.cc>
 * @package ds-duke-and-forum-assistant
 * @version 1.2
 * @license http://gnu.org/copyleft/gpl.html GNU GPL
 *
 */

/**
 * Description of mysql
 *
 * @author cuzi <cuzi@openmail.cc>
 */
class mysql extends mysqli {

    public $conn = false;
    public $sqlcounter = 0;
    public $sql_query;
    private $showerror;
    private $quitonerror;
    public $htmlerror = false;
    public $errors;


    function __construct(&$errors, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb=false, $showerror=true, $quitonerror=false) {
        $this->errors = &$errors;

        if ($mysqldb)
            @parent::__construct($mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb);
        else
            @parent::__construct($mysqlhost, $mysqluser, $mysqlpasswd);

        if (mysqli_connect_errno ()) {
            $this->error('OPEN');
            $this->conn = false;
        }
        else {
            $this->conn = true;
        }

        $this->showerror = $showerror ? true : false;
        $this->quitonerror = $quitonerror ? true : false;
    }

    function prepare($sql) {
        $sql = trim($sql);
        if(substr($sql, -1, 1) == ';') {
            $sql = substr($sql,0,-1);
        }
        $this->sql_query = $sql;
    }
    function select($sql, $resultType='assocList', $cache=false) {
        if(!$this->conn) {
            $this->error('NO.CONN');
            return;
        }
        $this->prepare($sql);
        $this->sqlcounter++;
        $this->htmlerror = false;
        $result = $this->query($this->sql_query);
        if ($result && is_object($result)) {
            if ($result->num_rows) {
                return $this->processResult($result, $resultType);
            } else {
                return false;
            }
        } else {
            $this->error('QUERY FAILED');
            return false;
        }
    }

    function processResult(MySQLi_Result $result, $resultType) {
        switch ($resultType) {
            case 'assoc':
                $re = $result->fetch_assoc();
                return $re;
            case 'assocList':
                $re = array();
                while ($row = $result->fetch_assoc())
                    $re[] = $row;
                return $re;
            case 'array':
                $re = $result->fetch_array(MYSQLI_NUM);
                return $re;
            case 'arrayList':
                $re = array();
                while ($row = $result->fetch_array(MYSQLI_NUM))
                    $re[] = $row;
                return $re;
            case 'valueArray':
                $re = array();
                while ($row = $result->fetch_array(MYSQLI_NUM))
                    $re = array_merge($re, $row);
                return $re;
                $re = array();
                while ($row = $result->fetch_array(MYSQLI_NUM))
                    $re = array_merge($re, $row);
                return $re;
            case 'field':
                $re = $result->fetch_array(MYSQLI_NUM);
                return $re[0];
            case 'table':
                $re = $this->table($result);
                return $re;
            default:
                if (strtolower(substr($resultType, 0, 7)) == 'column:') {
                    $column = substr($resultType, 7);
                    $re = array();
                    while ($row = $result->fetch_assoc())
                        $re[] = $row[$column];
                    return $re;
                } else {
                    var_dump($resultType);
                    $this->error('WRONG RESULT TYPE');
                    return NULL;
                }
        }
    }

    function execute($sql) {
        if(!$this->conn) {
            $this->error('NO.CONN');
            return;
        }
        $this->prepare($sql);
        $this->htmlerror = false;
        $result = $this->real_query($this->sql_query);
        if ($result)
            return true;
        else {
            $this->error('QUERY FAILED');
            return false;
        }
    }

    function table(MySQLi_Result $result) {
        $re = array();
        $fields = $result->fetch_fields();
        $head = $body = '';
        $i = 0;



        while ($field = $result->fetch_field()) {
            $head .= sprintf('<th>`%s`.`%s`</th>', htmlspecialchars(utf8_encode($field->orgtable),ENT_QUOTES,'UTF-8'),htmlspecialchars(utf8_encode($field->name),ENT_QUOTES,'UTF-8'));
        }

        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $body .= '<tr>';
            foreach ($row as &$value) {
                $body .= sprintf('<td %s>%s</td>', $i % 2 == 1 ? 'style="background:GainsBoro;"' : '', htmlspecialchars(utf8_encode($value),ENT_QUOTES,'UTF-8'));
            }
            $body .= '</tr>';
            $i++;
        }

        return sprintf('<div style="font-family:sans-serif; padding:10px; margin-top:5px; color:Black; ">Query:<br /><pre>%s</pre>Ergebnis:<br /><br /><table border="1"><tr>%s</tr>%s</table><br />%d Datensätze</div>', htmlspecialchars(utf8_encode($this->sql_query)), $head, $body, $i);
    }

    function id() {
        return $this->insert_id;
    }

    function escape($txt) {
        return $this->escape_string($txt);
    }

    function likeSelect($sql) {
        $sql = strtoupper(trim($sql));
        $part = substr($sql,0,10);
        if(     strpos($part,'INSERT') !== false ||
                strpos($part,'UPDATE') !== false ||
                strpos($part,'ALTER') !== false ||
                strpos($part,'DROP') !== false ||
                strpos($part,'DELETE') !== false ||
                strpos($part,'CREATE') !== false ||
                strpos($part,'TRUNCATE') !== false)
            return false;
        return true;
    }

    function error($error_type) {
        if (!$this->showerror && $this->quitonerror) {
            exit();
        }
        switch ($error_type) {
            case 'OPEN':
                $text = 'MySQL Error: Beim Öffnen der Verbindung zur Datenbank ist ein Fehler aufgetreten';
                break;

            case 'QUERY FAILED':
                $text = sprintf('MySQL Error: Folgender Query war fehlerhaft:<br /><pre>%s</pre><b>Error %d:</b><br />%s<br />', htmlspecialchars(utf8_encode($this->sql_query),ENT_QUOTES,'UTF-8'), $this->errno, htmlspecialchars(utf8_encode($this->error),ENT_QUOTES,'UTF-8'));
                break;

            case 'WRONG RESULT TYPE':
                $text = 'MySQL Error: Der Rückgabetyp ist unbekannt';
                break;

            case 'NO.CONN':
                $text = 'MySQL Error: Es besteht keine Verbindung zu einer Datenbank';
                break;

            default:
                $text = sprintf('MySQL Error: Es ist folgender, unbekannter Fehler aufgetreten: <b>%s</b>', htmlspecialchars(utf8_encode($error_type),ENT_QUOTES,'UTF-8'));
                break;
        }
        $this->errors[] = $text;
        $this->htmlerror = sprintf('<div style="font-family:sans-serif; padding:10px; margin-top:5px; color:White; background:LightCoral; border:5px Crimson solid;">%s</div>', $text);
        if ($this->showerror) {
            echo $this->htmlerror;
        }


        if ($this->quitonerror) {
            exit();
        }
    }

}

?>