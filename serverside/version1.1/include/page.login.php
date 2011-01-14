<?php

/**
 * page.login.php
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

$smarty->assign('moduleTpl', 'login.tpl');



if ($_POST['groupid'] && $_SESSION['groups_array']) {
    foreach ($_SESSION['groups_array'] as &$value) {
        if ($_POST['groupid'] == $value['groupid']) {
            $_SESSION['group_id'] = $value['groupid'];
            $_SESSION['group_key'] = $value['key'];
            $_SESSION['group_name'] = $value['name'];
            $_SESSION['view'] = true;
            $smarty->assign('hint', 'Erfolgreich eingeloggt und Gruppe ausgewählt');
            $smarty->assign('redirect', '?');
            break;
        }
    }
    $_SESSION['groups_array'] = false;

    if (!$_SESSION['group_id']) {
        // Logout
        require $include_path.'logout.inc.php';
        $errors[] = 'Gruppe existiert nicht';
        return;
    }
} else if ($_POST['loginname'] && $_POST['loginpasswort']) {

    // Logout
    require $include_path.'logout.inc.php';

    $loginname = $mysql->escape($_POST['loginname']);
    $loginpassword = hash('sha512', $_POST['loginpasswort']);

    $sql = sprintf('
    SELECT      `user`.`id` AS `userid`,
                `user`.`password`,
                `group`.`id` AS `groupid`,
                `group`.`key` AS `key`,
                `group`.`joinkey` AS `joinkey`
    FROM `user`
    LEFT JOIN `group` ON `group`.`leader_id` = `user`.`id`
    WHERE `user`.`name` = "%s"
    AND `user`.`password` = "%s"
    LIMIT 1', $loginname, $loginpassword);


    $result = $mysql->select($sql, 'assoc');

    if (!$result) {
        $errors[] = 'Der Benutzername oder das Passwort waren falsch';
    } else {
        if ($result['key']) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $result['userid'];
            $_SESSION['user_password'] = $result['password'];
            $_SESSION['group_id'] = $result['groupid'];
            $_SESSION['group_key'] = $result['key'];
            $_SESSION['join_key'] = $result['joinkey'];

            $sql = sprintf('
                SELECT     `group`.`name` AS `name` ,
                           `group`.`key` AS `key`
                FROM `group`
                WHERE `group`.`id` = %u
                LIMIT 1', $_SESSION['group_id']);

            $result = $mysql->select($sql, 'assoc');

            $_SESSION['group_key'] = $result['key'];
            $_SESSION['group_name'] = $result['name'];

            $smarty->assign('hint', 'Erfolgreich eingeloggt als Admin');
            $smarty->assign('redirect', '?');
        } else {
            $_SESSION['user_id'] = $result['userid'];

            $sql = sprintf('
                SELECT     `group`.`name` AS `name` ,
                           `group`.`id` AS `groupid` ,
                           `group`.`key` AS `key`
                FROM `usergroup_map`
                LEFT JOIN `group` ON `group`.`id` = `usergroup_map`.`gid`
                WHERE `usergroup_map`.`uid` = %u', $_SESSION['user_id']);

            $result = $mysql->select($sql, 'assocList');

            $groups = count($result);

            if (1 == $groups && $result[0]['groupid']) {
                $_SESSION['group_id'] = $result[0]['groupid'];
                $_SESSION['group_key'] = $result[0]['key'];
                $_SESSION['group_name'] = $result[0]['name'];
                $_SESSION['view'] = true;
                $smarty->assign('hint', 'Erfolgreich eingeloggt');
                $smarty->assign('redirect', '?');
            } else if (1 < $groups) {
                $smarty->assign('hint', 'Erfolgreich eingeloggt');
                $smarty->assign('chooseGroup', true);
                $smarty->assign('groups_array', $result);
                $_SESSION['groups_array'] = $result;
            } else {
                $errors[] = 'Keine passende Gruppe gefunden';
            }
        }
    }
}
?>