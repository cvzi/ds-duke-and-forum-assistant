{**
 * templates/view.tpl
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
 * @version 1.1
 * @license http://gnu.org/copyleft/gpl.html GNU GPL
 *}
<h1>Gruppe: {$groupName|escape}</h1>

<br />

{if not $loggedin}

<fieldset>
    <legend>Dein Synchronisierungscode</legend>
    Dieser Synchronisierungscode ist nicht zur Weitergabe an Stammesmitglieder, sondern nur für dich persönlich.
    <br />
    Du kannst ihn im Userscript über die Leiste unten im Forum und den Menüpunkt <span class="i">Extras</span> -&gt; <span class="i">Synchronisierung einrichten</span> eingeben.
    <br />
    <br />
    Wenn du die neuste Version des Userscripts noch nicht installiert hast, kannst du das jetzt tun:
    <br />
    <a href="http://userscripts.org/scripts/source/40049.user.js">Userscript installieren/updaten</a>
    <br />
    <br />
    <textarea id="ownSyncCode" cols="70" rows="3">{$ownSyncCode}</textarea>
    <br />
    <span class="jslink" id="ownSyncCode_copy">In Zwischenable kopieren</span>

</fieldset>

<br />
<br />

{/if}

<form action="?" method="get">
    <fieldset>
        <legend>Daten einsehen</legend>
        Hier kannst du die gesamten gespeicherten Daten anschauen.
        <br />
        <br />
        {if $groupdata}
        <input type="hidden" name="q" value="record" />
        <select name="id">

        {section name=i loop=$groupdata}
        {strip}
            <option {if $groupdata[i].author == $groupdata_ownid}style="background:Silver" {/if}value="{$groupdata[i].id}">{$groupdata[i].time|date_format:"%d.%m.%y - %T"} von {$groupdata[i].name|escape} @ver{$groupdata[i].version}</option>
        {/strip}
        {/section}
        </select>
        <input type="submit" name="submit" value="Zeigen" />

        <br />
        Deine eigenen Uploads sind grau hinterlegt.
        <br />
        Insgesamt sind {$groupdata_length} Einträge gespeichert.

        {else}
        Es sind noch keine Daten vorhanden
        {/if}


    </fieldset>
</form>