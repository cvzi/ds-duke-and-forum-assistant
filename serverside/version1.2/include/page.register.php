<?php

/**
 * page.register.php
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
 * @version 1.2
 * @license http://gnu.org/copyleft/gpl.html GNU GPL
 */
if (!$index)
    exit();

$smarty->assign('moduleTpl', 'login.tpl');
$smarty->assign('registerFormOnly', true);

if ($_POST['registergroupname']) {
    // Logout
    require $include_path . 'logout.inc.php';

    // Check form fields
    if (!$_POST['registergroupname'] ||
            !$_POST['registerusername'] ||
            !$_POST['registerpassword0'] ||
            !$_POST['registerpassword1'] ||
            $_POST['registerpassword1'] != $_POST['registerpassword0'] ||
            strlen($_POST['registergroupname']) < 4 ||
            strlen($_POST['registerusername']) < 4
    ) {
        $errors[] = 'Nicht alle Felder korrekt ausgefüllt';
        $smarty->assign('moduleTpl', 'login.tpl');
        $smarty->assign('registerFormOnly', true);
        return;
    }

    $registergroupname = $mysql->escape($_POST['registergroupname']);
    $registerusername = $mysql->escape($_POST['registerusername']);
    $registerpassword = hash('sha512', $_POST['registerpassword1']);
    $registeremail = $mysql->escape(trim($_POST['registeremail']));

    $sql = sprintf('
            SELECT 1
            FROM `group`
            WHERE `group`.`name` = "%s"
            LIMIT 1',
                    $registergroupname);

    $result = $mysql->select($sql);
    if ($result) {
        $errors[] = 'Der Gruppenname existiert bereits.';
        $smarty->assign('moduleTpl', 'login.tpl');
        $smarty->assign('registerFormOnly', true);
        return;
    }

    $sql = sprintf('
            SELECT 1
            FROM `user`
            WHERE `user`.`name` = "%s"
            LIMIT 1',
                    $registerusername);

    $result = $mysql->select($sql);
    if ($result) {
        $errors[] = 'Der Ingame Name existiert bereits. Falls du auf mehreren Welten spielst, schreibe vor deinen Namen die Welt oder den Stammesname, da du jeweils nur einen Stamm/Gruppe für einen Benutzernamen registrieren kannst.';
        $smarty->assign('moduleTpl', 'login.tpl');
        $smarty->assign('registerFormOnly', true);
        return;
    }

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

    $sql = sprintf('
            INSERT INTO `user` (
                `name`        ,
                `password`    ,
                `lastaction`  ,
                `email`
            )
            VALUES (
                 "%s"  ,
                 "%s"  ,
                 %u    ,
                 "%s"
            )',
                    $registerusername,
                    $registerpassword,
                    time(),
                    $registeremail);


    $result = $mysql->execute($sql);
    if ($result) {
        $_SESSION['user_id'] = $mysql->id();
        $_SESSION['user_password'] = $registerpassword;
        $sql = sprintf('
            INSERT INTO `group` (
                `name`       ,
                `lastaction` ,
                `key`        ,
                `joinkey`    ,
                `leader_id`
            )
            VALUES (
                 "%s" ,
                  %u  ,
                 "%s" ,
                 "%s" ,
                  %u
            )',
                        $registergroupname,
                        time(),
                        $key,
                        $joinkey,
                        $_SESSION['user_id']);

        $result = $mysql->execute($sql);
        if ($result) {
            $_SESSION['group_id'] = $mysql->id();

            $sql = sprintf('
            INSERT INTO `usergroup_map` (
                `gid`,
                `uid`
            )
            VALUES (
                 %u,
                 %u
            )',
                            $_SESSION['group_id'],
                            $_SESSION['user_id']);

            $result = $mysql->execute($sql);

            if ($result) {
                $_SESSION['group_key'] = $key;
                $_SESSION['join_key'] = $joinkey;
                $_SESSION['group_name'] = $_POST['registergroupname'];
                $_SESSION['loggedin'] = true;

                $smarty->assign('hint', 'Erfolgreich registriert');
                $smarty->assign('redirect', '?');
            } else {
                //  @todo Delete corrupted data
                $errors[] = 'Es trat ein Fehler auf. Versuche es später erneut.';
            }
        } else {
            //  @todo Delete corrupted data
            $errors[] = 'Es trat ein Fehler auf. Versuche es später erneut.';
        }
    } else {
        //  @todo Delete corrupted data
        $errors[] = 'Es trat ein Fehler auf. Versuche es später erneut.';
    }
}
?>