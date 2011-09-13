{**
 * templates/admin.tpl
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
<h1>Admin</h1>

{if !$redirect}
<fieldset>
    <legend>Aktivierungslink und Synchronisierungscode.</legend>
    Wenn jemand dem du Zugriff auf die Daten gegeben hast, nicht länger Zugriff haben soll, dann kannst du ihn hier löschen:
    <br />
    {if $members}  
    <table>
        <tr>
            <th>Name</th>
            <td> </td>
        </tr>
        {**

// @todo deleting yourself via URL is still possible, and should be fixed

*}
    {foreach item=member from=$members}
        <tr>
            <td>{$member.name|escape}</td>
            <td><a href="?q=admin&amp;do=deleteuser&amp;id={$member.mapid}" onclick="return confirm('Wirklich löschen?');">Löschen</a></td>
        </tr>
    {/foreach}
    </table>
    {else}
    Keine registrierten Mitglieder
    {/if}

    <br />
    <br />
    Alternativ kannst du auch den Aktivierungslink und den Synchronisierungscode ändern. Das ist auch notwendig wenn du den Aktivierungslink an eine falsche Person geschickt hast.
    <br />
    Der Nachteil ist, dass dann <u>alle</u> User sich den neuen Synchronisierungscode holen müssen.
    <br /><br />
    <a href="?q=admin&amp;do=resetSyncCode" onclick="return confirm('Wirklich neu generieren?');">Synchronisierungscodes und Aktivierungslinks neu generieren  </a>

</fieldset>


<br />
<br />


<fieldset>
    <legend>Aktivierungslink für neue Spieler</legend>

    Bitte schick Stammesführern, die Zugriff auf die Daten erhalten sollen, diesen Link, damit sie sich anmelden können:
    <br />
    <br />
    <textarea id="userLink" cols="70" rows="3">{$userLink}</textarea>
    <br />
    <span class="jslink" id="userLink_copy">In Zwischenable kopieren</span>


</fieldset>


<br />
<br />

<fieldset>
    <legend>Dein Synchronisierungscode</legend>
    Dieser Synchronisierungscode ist nicht zur Weitergabe an Stammesmitglieder, sondern nur für dich persönlich.
    <br />
    Du kannst ihn im Userscript über die Leiste unten im Forum und den Menüpunkt <span class="i">Extras</span> -&gt; <span class="i">Synchronisierung einrichten</span> eingeben.
    <br />
    <br />
    <textarea id="ownSyncCode" cols="70" rows="3">{$ownSyncCode}</textarea>
    <br />
    <span class="jslink" id="ownSyncCode_copy">In Zwischenable kopieren</span>

</fieldset>

<br />
<br />

<fieldset>
    <legend>Daten einsehen</legend>
    <a href="?q=view">Daten ansehen</a>

</fieldset>

{/if}