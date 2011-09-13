<?php /* Smarty version 2.6.26, created on 2011-09-12 21:20:20
         compiled from join.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'join.tpl', 56, false),)), $this); ?>

<?php if (! $this->_tpl_vars['loggedin'] && ! $this->_tpl_vars['view']): ?>
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
            <input type="text" name="registername" id="registername" value="<?php echo ((is_array($_tmp=$_POST['registername'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
            <br /><br />
            <input type="password" name="registerpassword0" id="registerpassword0" />
            <br /><br />
            <input type="password" name="registerpassword1" id="registerpassword1" />
            <br /><br />
            <input type="text" name="registeremail" value="<?php echo ((is_array($_tmp=$_POST['registeremail'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
            <br /><br />
            <input type="text" disabled="disabled" name="registerjoinkey" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['joinkey'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
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
            <input type="text" name="registername" id="registername" value="<?php echo ((is_array($_tmp=$_POST['registername'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
            <br /><br />
            <input type="password" name="registerpassword0" id="registerpassword0" />
            <br /><br />
            <input type="text" disabled="disabled" name="registerjoinkey" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['joinkey'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        </div>
        <br class="cb"/>
        <br />
        <input type="submit" name="do" value="Anmelden" />
    </fieldset>
</form>
<?php endif; ?>