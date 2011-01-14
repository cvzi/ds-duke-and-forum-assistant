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
<h1>{$record.time|date_format:"%d.%m.%y - %T"} von {$record.name|escape} @version {$record.version}</h1>

<h2><a onclick="return confirm('Wirklich?');" href="?admin&amp;do=setcurrentversion&amp;id={$record.id}">Auf diese Version zurücksetzen</a></h2>
<br />

<a href="?q=view">Zurück</a>
<br />
<br />
<fieldset>
    <legend>JSON Daten</legend>
Wenn du diese Daten in das Userscript einfügen willst, dann kannst du sie über die Leiste unten im Forum und den Menüpunkt <span class="i">Extras</span> -&gt; <span class="i">Export/Import</span> eingeben.
<br />
Dort gibst du den Code in das  <span class="i">Import:</span> Feld ein und klickst dann auf Importieren.
<br />
Vorher solltest du die Synchronisierung der Daten ausschalten, da durch die automatische Synchronisierung die Daten sonst wieder überschrieben werden.
<br />
<br />
<textarea readonly="readonly" id="recordjson" cols="100" rows="30">{$recordjson}</textarea>
<br />
<span class="jslink" id="recordjson_copy">In Zwischenable kopieren</span>

</fieldset>