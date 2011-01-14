<?php

/**
 * page.record.php
 *
 *       ds-duke-and-forum-assistant
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
 * @copyright 2011 cuzi
 * @author cuzi <cuzi@openmail.cc>
 * @package ds-duke-and-forum-assistant
 * @version 1.1
 * @license http://gnu.org/copyleft/gpl.html GNU GPL
 */

if(!$index)
    exit();

if (!$_SESSION['loggedin'] && !$_SESSION['view']) {
    $smarty->assign('moduleTpl', 'login.tpl');
    return;
}

$smarty->assign('moduleTpl', 'record.tpl');


// Fetch record

$rid = (integer) $_GET['id'];

$sql = sprintf('
        SELECT      `record`.`id`,
                    `record`.`version`,
                    `record`.`author`,
                    `user`.`name`,
                    `record`.`time`,
                    `record`.`data`
        FROM `record`
        LEFT JOIN `user` ON `user`.`id` = `record`.`author`
        WHERE `record`.`id` = %u AND `record`.`group` = %u
        LIMIT 1', $rid, (integer) $_SESSION['group_id']);

$result = $mysql->select($sql, 'assoc');

$smarty->assign('record', $result);

$smarty->assign('recordjson', utf8_encode(htmlspecialchars($result['data'])));

$js .= '
window.addEvent("domready", function() {

ZeroClipboard.setMoviePath("ZeroClipboard.swf");
var clip0 = new ZeroClipboard.Client();

clip0.setText("");

clip0.addEventListener("mouseDown", function(){
 var textarea = document.getElementById("recordjson");
 clip0.setText(textarea.value);
 $("recordjson_copy").highlight();
});

clip0.glue("recordjson_copy");

});
';

?>