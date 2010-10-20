<?php

/**
 * page.view.php
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

if (!$_SESSION['loggedin'] && !$_SESSION['view']) {
    $smarty->assign('moduleTpl', 'login.tpl');
    return;
}

$smarty->assign('moduleTpl', 'view.tpl');


$smarty->assign('groupName', htmlspecialchars($_SESSION['group_name']));

// Own Sync Code
// synchronizingKey;synchronizingURL;synchronizingUserId;synchronizingGroupId;synchronizingPassword
$ownSyncCode = sprintf('%s;%ssync.php;%u;%u;%s',
                $_SESSION['group_key'],
                $url,
                $_SESSION['user_id'],
                $_SESSION['group_id'],
                $_SESSION['user_password']);

$smarty->assign('ownSyncCode', $ownSyncCode);


$js .= '
window.addEvent("domready", function() {

ZeroClipboard.setMoviePath("ZeroClipboard.swf");
var clip0 = new ZeroClipboard.Client();

clip0.setText("");

clip0.addEventListener("mouseDown", function(){
 var textarea = document.getElementById("ownSyncCode");
 clip0.setText(textarea.value);
 $("ownSyncCode_copy").highlight();
});

clip0.glue("ownSyncCode_copy");

});
';

// Data

$sql = sprintf('
        SELECT      `record`.`id`,
                    `record`.`version`,
                    `record`.`author`,
                    `user`.`name`,
                    `record`.`time`
        FROM `record`
        LEFT JOIN `user` ON `user`.`id` = `record`.`author`
        WHERE `record`.`group` = %u
        ORDER BY `record`.`time` DESC', (integer) $_SESSION['group_id']);

$result = $mysql->select($sql, 'assocList');

$len = count($result);

$smarty->assign('groupdata', $result);
$smarty->assign('groupdata_length', $len);
$smarty->assign('groupdata_ownid', $_SESSION['user_id']);

?>
