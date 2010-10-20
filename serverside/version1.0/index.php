<?php
/**
 * index.php
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


require($include_smarty.'libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->caching = false;
$smarty->template_dir = $include_templates;
$smarty->config_dir = $include_smarty.'config/';
$smarty->cache_dir = $include_smarty.'cache/';
$smarty->compile_dir = $include_smarty.'templates_c/';
$js = '';


switch($_GET['q']) {
    case 'about':
        require $include_pages.'page.about.php';
        break;
    case 'login':
        require $include_pages.'page.login.php';
        break;
    case 'register':
        require $include_pages.'page.register.php';
        break;

    case 'logout':
        require $include_pages.'page.logout.php';
        break;

    case 'join':
        require $include_pages.'page.join.php';
        break;
    case 'view':
        require $include_pages.'page.view.php';
        break;
    case 'record':
        require $include_pages.'page.record.php';
        break;

    default:
        require $include_pages.'page.admin.php';
        break;
    
}

$smarty->assign('loggedin', $_SESSION['loggedin']);
$smarty->assign('view', $_SESSION['view']);

$smarty->assign('js', $js);



require 'common.php';


header('Content-Type: text/html; charset=utf-8');

$smarty->assign('errors', $errors);
$smarty->display('index.tpl');

?>