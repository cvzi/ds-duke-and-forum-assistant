<?php

/**
 * page.index.php
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
if (!$index)
    exit();

if (!$_SESSION['loggedin'] && !$_SESSION['view']) {
    $smarty->assign('moduleTpl', 'login.tpl');
    return;
} else if ($_SESSION['view']) {
    require 'page.view.php';
    return;
}

$smarty->assign('moduleTpl', 'admin.tpl');

if ('resetSyncCode' == $_GET['do']) {
    // Get uniquee keys
    $key = hash('sha512', '_' . time() . '_' . rand());
    $joinkey = hash('sha512', '_' . rand() . '_' . time());
    for ($result = true; $result; $key = hash('sha512', '_' . time() . '_' . rand()), $joinkey = hash('sha512', '_' . rand() . '_' . time())) {
        $sql = sprintf('
            SELECT 1
            FROM `group`
            WHERE `key` = "%s"
            OR `joinkey` = "%s"
            LIMIT 1',
                        $key,
                        $joinkey);

        $result = $mysql->select($sql);
    }

    $sql = sprintf('UPDATE `group` SET `key` = "%s",`joinkey` = "%s" WHERE `group`.`id` = %u', $key, $joinkey, $_SESSION['group_id']);
    $result = $mysql->execute($sql);
    if ($result) {
        $_SESSION['group_key'] = $key;
        $_SESSION['join_key'] = $joinkey;
        $smarty->assign('hint', 'Der Synchronisierungscode und der Aktivierungslink wurden geändert!');
        $smarty->assign('redirect', '?q=admin');
    } else {
        $errors[] = 'Es trat ein Fehler auf. Versuche es später erneut.';
        $smarty->assign('redirect', '?q=admin');
    }
} elseif ('deleteuser' == $_GET['do'] && $_GET['id']) {
    $id = (integer) $_GET['id']; // This is not the user id but the id of `usergroup_map` entry
    $sql = sprintf('DELETE FROM `usergroup_map`
                        WHERE `usergroup_map`.`id` = %u
                        AND `usergroup_map`.`gid` = %u
                        AND `usergroup_map`.`uid` != %u', $id, $_SESSION['group_id'], $_SESSION['user_id']);
    $result = $mysql->execute($sql);
    if ($result) {
        $smarty->assign('hint', 'Das Mitglied wurde gelöscht');
        $smarty->assign('redirect', '?q=admin');
    }
    /*  DELETE is always true, need to check affected rows
      else {
      $errors[] = 'Es trat ein Fehler auf. Versuche es später erneut.';
      $smarty->assign('redirect', '?q=admin');
      } */
} elseif ('setcurrentversion' == $_GET['do'] && $_GET['id']) {
    $id = (integer) $_GET['id']; // This is the record id
    // Duplicate record entry
    $sql = sprintf('INSERT INTO `record`
SELECT NULL , `group` , `hash` , (

SELECT MAX( `version` ) +1
FROM `record` AS `re`
WHERE `re`.`group` = %u
) AS `version` , `data` , UNIX_TIMESTAMP() , `downloads` , `author`
FROM `record` AS `r`
WHERE `r`.`id` = %u  AND `r`.`group` = %u', $_SESSION['group_id'], $id, $_SESSION['group_id']);

    $result = $mysql->execute($sql);
    if ($result) {
        $smarty->assign('hint', 'Die Version wurde zurückgesetzt');
        $smarty->assign('redirect', '?q=view');
    } else {
        $errors[] = 'Es trat ein Fehler auf. Versuche es später erneut.';
        $smarty->assign('redirect', '?q=record&amp;id=' . $id);
    }
}


// Group members
$sql = sprintf('SELECT `usergroup_map`.`id` AS `mapid`,`user`.`id` AS `uid`,`user`.`name`
                FROM `usergroup_map`
                LEFT JOIN `user` ON `user`.`id` = `usergroup_map`.`uid`
                WHERE  `usergroup_map`.`gid` = %u', $_SESSION['group_id']);
$members = $mysql->select($sql, 'assocList');
$smarty->assign('members', $members);



// Own Sync Code
// synchronizingKey;synchronizingURL;synchronizingUserId;synchronizingGroupId;synchronizingPassword
$ownSyncCode = sprintf('%s;%ssync.php;%u;%u;%s',
                $_SESSION['group_key'],
                $url,
                $_SESSION['user_id'],
                $_SESSION['group_id'],
                $_SESSION['user_password']);

$smarty->assign('ownSyncCode', $ownSyncCode);


// Link to add new users
$link = $url . 'index.php?q=join&amp;key=' . $_SESSION['join_key'] . '&amp;id=' . $_SESSION['group_id'];
$smarty->assign('userLink', $link);

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


var clip1 = new ZeroClipboard.Client();

clip1.setText("");

clip1.addEventListener("mouseDown", function(){
 var textarea = document.getElementById("userLink");
 clip1.setText(textarea.value);
 $("userLink_copy").highlight();
});

clip1.glue("userLink_copy");

});
';
?>
