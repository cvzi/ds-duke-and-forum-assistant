{**
 * templates/index.tpl
 *
 *       ###packageName###
 *
 *  UTF-8 encoded
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
 * @copyright Copyright (c) 2011, cuzi
 * @author cuzi;cuzi@openmail.cc
 * @package ###packageName###
 * @version 1.0
 * @license http://gnu.org/copyleft/gpl.html GNU GPL
 *}
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="de" >
    <head>
        <title>DS Duke &amp; Forum Assistant</title>

        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="Content-Script-Type" content="text/javascript" />
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
        <meta http-equiv="Content-Language" content="de" />

        {if $redirect}
        <meta http-equiv="refresh" content="3; URL={$redirect}" />
        {/if}

        <link rel="stylesheet" type="text/css" href="main.css" />

        <script type="text/javascript" src="mootools-core-1.3-full-compat-yc.js"></script>
        <script type="text/javascript" src="main.js"></script>
        <script type="text/javascript" src="ZeroClipboard.js"></script>
        {if $js}
         <script type="text/javascript">{$js}</script>
        {/if}

    </head>
    <body>

        <h1>DS Duke &amp; Forum Assistant</h1>

        {if $hint}
        <br />
        <div class="hint">{$hint}</div>
        <br />
        {/if}

        {if $errors}
        {section name=i loop=$errors}
        {strip}
        <br />
        <div class="error">{$errors[i]}</div>
        <br />
        {/strip}
        {/section}
        {/if}

        {if $redirect}
            <br />
        <h2><img src="images/loader.gif" alt="Bitte warten" /> <a href="{$redirect}"> Weiterleitung . . . . </a></h2>
            <br />
        {/if}

        <div id="maincontent">
            {if $moduleTpl}
            {include file=$moduleTpl}
            {/if}
        </div>

        {if $outputbuffer}
        <div class="buffer"><span style="position:relative; color:FireBrick; top:-12px;">PHP Output:</span>
{$outputbuffer}
        </div>
        {/if}



        <div id="navi">
            <br />
            <br />
            {if $loggedin or $view}<a href="?">Home</a>{/if}
            {if $loggedin}<a href="?q=view">Daten</a>{/if}

            {if $loggedin or $view}<a class="fr" href="?q=logout">Logout</a>{/if}
            {if not $loggedin and not $view}<a class="fr" href="?q=login">Login</a>{/if}
            <br class="cr"/>

        </div>


        <div>
            <a class="fr" href="?q=about">Impressum</a>
            <br class="cr"/>
        </div>



    </body>

</html>
