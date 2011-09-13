<?php /* Smarty version 2.6.26, created on 2011-09-12 21:17:50
         compiled from admin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'admin.tpl', 51, false),)), $this); ?>
<h1>Admin</h1>

<?php if (! $this->_tpl_vars['redirect']): ?>
<fieldset>
    <legend>Aktivierungslink und Synchronisierungscode.</legend>
    Wenn jemand dem du Zugriff auf die Daten gegeben hast, nicht länger Zugriff haben soll, dann kannst du ihn hier löschen:
    <br />
    <?php if ($this->_tpl_vars['members']): ?>  
    <table>
        <tr>
            <th>Name</th>
            <td> </td>
        </tr>
            <?php $_from = $this->_tpl_vars['members']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['member']):
?>
        <tr>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['member']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <td><a href="?q=admin&amp;do=deleteuser&amp;id=<?php echo $this->_tpl_vars['member']['mapid']; ?>
" onclick="return confirm('Wirklich löschen?');">Löschen</a></td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
    </table>
    <?php else: ?>
    Keine registrierten Mitglieder
    <?php endif; ?>

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
    <textarea id="userLink" cols="70" rows="3"><?php echo $this->_tpl_vars['userLink']; ?>
</textarea>
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
    <textarea id="ownSyncCode" cols="70" rows="3"><?php echo $this->_tpl_vars['ownSyncCode']; ?>
</textarea>
    <br />
    <span class="jslink" id="ownSyncCode_copy">In Zwischenable kopieren</span>

</fieldset>

<br />
<br />

<fieldset>
    <legend>Daten einsehen</legend>
    <a href="?q=view">Daten ansehen</a>

</fieldset>

<?php endif; ?>