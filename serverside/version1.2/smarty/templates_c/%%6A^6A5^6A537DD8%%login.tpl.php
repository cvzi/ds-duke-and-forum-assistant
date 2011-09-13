<?php /* Smarty version 2.6.26, created on 2011-09-12 21:15:33
         compiled from login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'login.tpl', 45, false),)), $this); ?>

<?php if ($this->_tpl_vars['chooseGroup']): ?>

<form action="?q=login" method="post" id="groupform">
    <fieldset>
        <legend>Gruppe auswählen</legend>
        <p>Es wurden mehrere Gruppen gefunden. Wähle aus bei welcher du dich anmelden möchtest.
            <br />
            <br />
            Gruppen:
            <select name="groupid">

            <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['groups_array']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
            <?php echo '<option value="'; ?><?php echo $this->_tpl_vars['groups_array'][$this->_sections['i']['index']]['groupid']; ?><?php echo '">'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['groups_array'][$this->_sections['i']['index']]['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?><?php echo '</option>'; ?>

            <?php endfor; endif; ?>

            </select>
        </p>

        <input type="submit" name="do" value="Einloggen" />
    </fieldset>
</form>

<?php else: ?>


<?php if (! $this->_tpl_vars['loggedin'] && ! $this->_tpl_vars['view']): ?>
<?php if (! $this->_tpl_vars['registerFormOnly']): ?>
<form action="?q=login" method="post" id="loginform">
    <fieldset>
        <legend>Login</legend>
        <div class="fl">
            Username:
            <br /><br />
            Passwort:
        </div>
        <div class="fl" style="margin-left:5px">
            <input type="text" name="loginname" value="<?php echo ((is_array($_tmp=$_POST['loginname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
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

<?php endif; ?>

<form action="?q=register" method="post" <?php if (! $this->_tpl_vars['registerFormOnly']): ?>style="height: 0px; overflow: hidden; opacity:0.0" id="registerform"<?php endif; ?>>
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
            <input type="text" name="registergroupname" id="registergroupname" value="<?php echo ((is_array($_tmp=$_POST['registergroupname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" /> (mind. 4 Zeichen lang)
            <br /><br />
            <input type="text" name="registerusername" id="registerusername" value="<?php echo ((is_array($_tmp=$_POST['registerusername'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" /> (mind. 4 Zeichen lang)
            <br /><br />
            <input type="password" name="registerpassword0" id="registerpassword0" value="" />
            <br /><br />
            <input type="password" name="registerpassword1" id="registerpassword1" value="" />
            <br /><br />
            <input type="text" name="registeremail" value="<?php echo ((is_array($_tmp=$_POST['registeremail'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
            <br /><br />
        </div>
        <br class="cb"/>
        <br />
        <input type="submit" name="do" value="Registrieren" />
    </fieldset>
</form>

<?php endif; ?>

<?php endif; ?>