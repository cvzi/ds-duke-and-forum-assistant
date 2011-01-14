<?php

/**
 * page.join.php
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

if ($_GET['key']) {

    $smarty->assign('moduleTpl', 'join.tpl');
    $smarty->assign('joinkey', htmlspecialchars($_GET['key']) . ';' . (integer) $_GET['id']);

    // Logout
    require $include_path.'logout.inc.php';

    $joinkey = $mysql->escape(trim($_GET['key']));
    $group_id = (integer) trim($_GET['id']);

    // Check joinkey
    $sql = sprintf('
            SELECT 1
            FROM `group`
            WHERE `group`.`id` = %u
            AND `group`.`joinkey` = "%s"
            LIMIT 1',
                    $group_id, $joinkey);

    $result = $mysql->select($sql);
    if (!$result) {
        $errors[] = 'Der Link ist nicht mehr gültig!';
        $smarty->assign('moduleTpl', 'join.tpl');
        return;
    }

    $_SESSION['joinkey'] = trim($_GET['key']);
    $_SESSION['group_id'] = (integer) $_GET['id'];

} else if ($_POST['registername'] && $_SESSION['joinkey']) {

    $smarty->assign('moduleTpl', 'join.tpl');

    $registername = $mysql->escape($_POST['registername']);
    $registerpassword = hash('sha512', $_POST['registerpassword0']);
    $registeremail = $mysql->escape(trim($_POST['registeremail']));

    if ('1' == $_GET['login']) {
        // Do not register new user but login to existent user

        $sql = sprintf('
            SELECT `user`.`id`
            FROM `user`
            WHERE `user`.`name` = "%s"
            AND `user`.`password` = "%s"
            LIMIT 1',
                        $registername, $registerpassword);

        $result = $mysql->select($sql, 'assoc');
        if (!$result) {
            $errors[] = 'Das Passwort oder der Name waren falsch.';
            $smarty->assign('moduleTpl', 'join.tpl');
            return;
        }
        $_SESSION['user_id'] = (integer) $result['id'];
    } else {

        $sql = sprintf('
            SELECT 1
            FROM `user`
            WHERE `user`.`name` = "%s"
            LIMIT 1',
                        $registername);

        $result = $mysql->select($sql);
        if ($result) {
            $errors[] = 'Der Ingame Name existiert bereits. Benutze das Formular zum Anmelden, wenn du schon einen Account besitzt oder hänge an deinen Ingamenamen ein Erkennungszeichen an z.B. deine Welt oder dein Stammesname.';
            $smarty->assign('moduleTpl', 'join.tpl');
            $smarty->assign('registerFormOnly', true);
            return;
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
                        $registername,
                        $registerpassword,
                        time(),
                        $registeremail);

        $result = $mysql->execute($sql);
        if ($result) {
            $_SESSION['user_id'] = $mysql->id();
            $_SESSION['user_password'] = $registerpassword;
        }
    }

    if ($result) {

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

            $sql = sprintf('
                SELECT     `group`.`name` AS `name` ,
                           `group`.`key` AS `key`
                FROM `group`
                WHERE `group`.`id` = %u
                LIMIT 1', $_SESSION['group_id']);

            $result = $mysql->select($sql, 'assoc');

            $_SESSION['joinkey'] = '';
            $_SESSION['group_key'] = $result['key'];
            $_SESSION['group_name'] = $result['name'];
            $_SESSION['view'] = true;
            $smarty->assign('hint', 'Erfolgreich registriert');
            $smarty->assign('redirect', '?q=view');
        } else {
            $errors[] = 'Es trat ein Fehler auf. Versuche es später erneut.';
        }
    } else {
        $errors[] = 'Es trat ein Fehler auf. Versuche es später erneut.';
    }
}
?>