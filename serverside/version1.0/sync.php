<?php
/**
 * sync.php
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

$index = true;

require 'common.php';

$post_gid = (integer) $_POST['groupid'];
$post_uid = (integer) $_POST['userid'];
$post_key = $mysql->escape(trim($_POST['key']));
$post_password = $mysql->escape(trim($_POST['password']));
$post_ver = (integer) $_POST['dataversion'];
$post_rawdata = trim($_POST['datajson']);
$post_data = $mysql->escape($post_rawdata);

$sync_status = 'ServerError';


// Check whether user is authorized
$authorized = false;

$sql = sprintf('
    SELECT *
    FROM `usergroup_map`
    LEFT JOIN `group` ON `usergroup_map`.`gid` = `group`.`id`
    LEFT JOIN `user` ON `usergroup_map`.`uid` = %u
    WHERE `usergroup_map`.`gid` = %u AND `usergroup_map`.`uid` = %u
    LIMIT 1', $post_uid, $post_gid, $post_uid);

$result = $mysql->select($sql, 'assoc');

if (!$result) {
    $errors[] = 'User not found in group';
} else {
    if ($post_key == $result['key'] && $post_password == $result['password']) {
        $authorized = true;
    } else {
        $errors[] = 'Key or password is wrong or out of date';
    }
}

if ($authorized) {

    // Look for new data
    $sql = sprintf('
        SELECT * FROM `record` 
        WHERE `record`.`group` = %u
        ORDER BY `record`.`time` DESC
        LIMIT 1', $post_gid);

    $result = $mysql->select($sql, 'assoc');

    $post_hash = hash('sha512', $post_data);
    if ($post_hash == $result['hash']) {
        $sync_status = 'NothingToDo';
        $new_version = $result['version'];
    } else if ($post_ver == $result['version'] || !$result) { // Add the new data to the server
        $sql = sprintf('
            INSERT INTO `record` (
                `group`     ,
                `hash`      ,
                `version`   ,
                `data`      ,
                `time`      ,
                `downloads` ,
                `author`
            )
            VALUES (
                 %u  ,
                "%s" ,
                 %u  ,
                "%s" ,
                 %u  ,
                 0   ,
                 %u
            )',
                        $post_gid,
                        $post_hash,
                        $post_ver + 1,
                        $post_data,
                        time(),
                        $post_uid);

        $result = $mysql->execute($sql);
        if ($result) {
            $sync_status = 'ServerUpdated';
            $new_version = $post_ver + 1;
        } else {
            $sync_status = 'ServerError';
            $errors[] = 'MySQL Error: Tried to update server';
        }
    } else { // Compare data and send back to user
        $sync_status = 'DataUpdated';
        $new_version = $result['version'];

        $post_arr = json_decode(utf8_encode($post_rawdata), true);
        if (JSON_ERROR_NONE != json_last_error() && null != $post_arr) {
            $sync_status = 'ServerError';
            $errors[] = 'JSON Error in sent data';
        }
        $data = json_decode(utf8_encode($result['data']), true);
        if (JSON_ERROR_NONE != json_last_error() && null != $data) {
            $sync_status = 'ServerError';
            $errors[] = 'JSON Error in archived data';
        }
        if ('DataUpdated' == $sync_status) {

            $changed = array();
            foreach ($data as $key => &$value) {
                if ($post_arr[$key] != $value) {
                    $changed[] = $key;
                }
            }
            $sql = sprintf('
            UPDATE `record`
            SET `record`.`downloads` = `record`.`downloads` + 1
            WHERE `record`.`id` = %u LIMIT 1',
                            $result['id']);

            $result = $mysql->execute($sql);
        }
    }
} else {
    $sync_status = 'Unauthorized';
}


$output = array(
    'errors' => array(),
    'syncstatus' => $sync_status);
if ('ServerError' != $sync_status) {
    $output['newversion'] = $new_version;
}
if ('DataUpdated' == $sync_status) {
    $output['data'] = $data;
    $output['changed'] = $changed;
}



require 'common.php';
// Headers schreiben
header('Content-Type: text/plain; charset=utf-8');


$output['errors'] = $errors;


echo json_encode($output);
?>