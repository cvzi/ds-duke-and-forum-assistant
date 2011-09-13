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

{if not $loggedin and not $view}
<form action="?q=join" method="post" id="joinform">
    <fieldset>
        <legend>Registrieren</legend>

        <p>
            Gib deinen Ingame Namen ein, damit dich deine Stammeskollegen erkennen und damit du dich später einloggen kannst, wenn du z.B. an einem anderen PC das Userscript einrichten willst.
            <br />Das Passwort sollte aus Sicherheitsgründen nicht dein Ingamepasswort sein.
            <br />Die Emailadresse dient dazu dein Passwort zurückzusetzen, falls du es einmal vergisst. Du musst keine Emailadresse angeben.
        </p>

        <div class="fl" style="line-height:20px">
            Ingame Name:
            <br /><br />
            Passwort:
            <br /><br />
            Passwort wiederholen:
            <br /><br />
            Emailadresse:
            <br /><br />
            Key

        </div>
        <div class="fl" style="margin-left:5px">
            <input type="text" name="registername" id="registername" value="{$smarty.post.registername|escape}" />
            <br /><br />
            <input type="password" name="registerpassword0" id="registerpassword0" />
            <br /><br />
            <input type="password" name="registerpassword1" id="registerpassword1" />
            <br /><br />
            <input type="text" name="registeremail" value="{$smarty.post.registeremail|escape}" />
            <br /><br />
            <input type="text" disabled="disabled" name="registerjoinkey" value="{$joinkey|escape}" />
        </div>
        <br class="cb"/>
        <br />
        <input type="submit" name="do" value="Registrieren" />
    </fieldset>
</form>

<form action="?q=join&amp;login=1" method="post" id="loginform">
    <fieldset>
        <legend>Anmelden</legend>

        <p>
            Wenn du dich schon einmal auf dieser Seite registriert hast, kannst du dich direkt mit deinem Passwort anmelden.
        </p>

        <div class="fl" style="line-height:20px">
            Name:
            <br /><br />
            Passwort:
            <br /><br />
            Key

        </div>
        <div class="fl" style="margin-left:5px">
            <input type="text" name="registername" id="registername" value="{$smarty.post.registername|escape}" />
            <br /><br />
            <input type="password" name="registerpassword0" id="registerpassword0" />
            <br /><br />
            <input type="text" disabled="disabled" name="registerjoinkey" value="{$joinkey|escape}" />
        </div>
        <br class="cb"/>
        <br />
        <input type="submit" name="do" value="Anmelden" />
    </fieldset>
</form>
{/if}
