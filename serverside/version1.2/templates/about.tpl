{**
 * templates/about.tpl
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
 * @author cuzi;cuzi@openmail.cc
 * @package ds-duke-and-forum-assistant
 * @version 1.2
 * @license http://gnu.org/copyleft/gpl.html GNU GPL
 *}
{strip}
<table>
    <tr>
        <th colspan="2">Kontakt</th>
    </tr>
    {if $about_data[0]}
    <tr>
        <td colspan="2">{$about_data[0]}</td>
    </tr>
    {/if}
    {if $about_data[1]}
    <tr>
        <td>E-Mail:</td>
        <td>{$about_data[1]}</td>
    </tr>
    {/if}
    {if $about_data[2]}
    <tr>
        <td colspan="2">{$about_data[2]}</td>
    </tr>
    {/if}
    {if $about_data[3]}
    <tr>
        <td colspan="2">{$about_data[3]}</td>
    </tr>
    {/if}
     {if $about_data[4]}
    <tr>
        <td colspan="2">{$about_data[4]}</td>
    </tr>
    {/if}

    <tr>
        <th colspan="2">Software</th>
    </tr>
    <tr>
        <td colspan="2">Projekt auf Google Code: <a href="http://code.google.com/p/ds-duke-and-forum-assistant/">http://code.google.com/p/ds-duke-and-forum-assistant/</a></td>
    </tr>
    <tr>
        <td colspan="2">Greasmonkeyscript auf userscripts.org: <a href="http://userscripts.org/scripts/show/40049">http://userscripts.org/scripts/show/40049</a></td>
    </tr>
     <tr>
        <td colspan="2">Thread im Die Stämme Forum: <a href="http://forum.die-staemme.de/showthread.php?t=95452">http://forum.die-staemme.de/showthread.php?t=95452</a></td>
    </tr>

</table>
{/strip}