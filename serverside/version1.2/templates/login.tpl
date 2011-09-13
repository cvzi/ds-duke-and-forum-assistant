{**
 * templates/login.tpl
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

{if $chooseGroup}

<form action="?q=login" method="post" id="groupform">
    <fieldset>
        <legend>Gruppe auswählen</legend>
        <p>Es wurden mehrere Gruppen gefunden. Wähle aus bei welcher du dich anmelden möchtest.
            <br />
            <br />
            Gruppen:
            <select name="groupid">

            {section name=i loop=$groups_array}
            {strip}
                <option value="{$groups_array[i].groupid}">{$groups_array[i].name|escape}</option>
            {/strip}
            {/section}

            </select>
        </p>

        <input type="submit" name="do" value="Einloggen" />
    </fieldset>
</form>

{else}


{if not $loggedin and not $view}
{if not $registerFormOnly}
<form action="?q=login" method="post" id="loginform">
    <fieldset>
        <legend>Login</legend>
        <div class="fl">
            Username:
            <br /><br />
            Passwort:
        </div>
        <div class="fl" style="margin-left:5px">
            <input type="text" name="loginname" value="{$smarty.post.loginname|escape}" />
            <br /><br />
            <input type="password" name="loginpasswort" />
        </div>
        <br class="cb"/>
        <br />
        <input type="submit" name="do" value="Einloggen" />
    </fieldset>
</form>

<br />
<br />
<span style="text-decoration:underline; color:Blue" onclick="this.parentNode.removeChild(this);$('registerform').setStyle('height','auto'); $('registerform').fade('in')">Registrieren</span>
<br />
<br />

{/if}

<form action="?q=register" method="post" {if not $registerFormOnly}style="height: 0px; overflow: hidden; opacity:0.0" id="registerform"{/if}>
    <fieldset>
        <div>
            Diese Registrierung ist nur zum Anmelden neuer Stämme. Wenn dein Stammesführer deinen Stamm schon registriert hat, solltest du deinen Stammesführer nach einem Aktivierungslink fragen.
        </div>

        <p>
            <br />Der Gruppenname sollte eindeutig mit deinem Stamm in Beziehung stehen, damit neue Stammesführer die Gruppe sofort erkennen können.
            <br />Gib deinen Ingame Namen ein, damit dich deine Stammeskollegen erkennen und damit du dich später einloggen kannst, wenn du z.B. an einem anderen PC das Userscript einrichten willst.
            <br />Das Passwort sollte aus Sicherheitsgründen nicht dein Ingamepasswort sein.
            <br />Die Emailadresse dient dazu dein Passwort zurückzusetzen, falls du es einmal vergisst. Du musst keine Emailadresse angeben es wird aber empfohlen.
        </p>

        <legend>Neue Gruppe/Stamm Registrieren</legend>
        <div class="fl">
            Gruppenname (z.B. W33 - Stammesname):
            <br /><br />
            Ingame Name:
            <br /><br />
            Passwort:
            <br /><br />
            Passwort wiederholen:
            <br /><br />
            Emailadresse:
            <br /><br />
        </div>
        <div class="fl" style="margin-left:5px">
            <input type="text" name="registergroupname" id="registergroupname" value="{$smarty.post.registergroupname|escape}" /> (mind. 4 Zeichen lang)
            <br /><br />
            <input type="text" name="registerusername" id="registerusername" value="{$smarty.post.registerusername|escape}" /> (mind. 4 Zeichen lang)
            <br /><br />
            <input type="password" name="registerpassword0" id="registerpassword0" value="" />
            <br /><br />
            <input type="password" name="registerpassword1" id="registerpassword1" value="" />
            <br /><br />
            <input type="text" name="registeremail" value="{$smarty.post.registeremail|escape}" />
            <br /><br />
        </div>
        <br class="cb"/>
        <br />
        <input type="submit" name="do" value="Registrieren" />
    </fieldset>
</form>

{/if}

{/if}