<?php
/**
 * logout.inc.php
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

$_SESSION['loggedin'] = false;
$_SESSION['user_id'] = 0;
$_SESSION['group_id'] = 0;
$_SESSION['group_key'] = '';
$_SESSION['group_name'] = '';
$_SESSION['join_key'] = '';
$_SESSION['joinkey'] = '';
$_SESSION['view'] = false;
$_SESSION['groups_array'] = false;
?>