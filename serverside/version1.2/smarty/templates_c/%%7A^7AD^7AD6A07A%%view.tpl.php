<?php /* Smarty version 2.6.26, created on 2011-09-12 21:21:10
         compiled from view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'view.tpl', 31, false),array('modifier', 'date_format', 'view.tpl', 72, false),)), $this); ?>
<h1>Gruppe: <?php echo ((is_array($_tmp=$this->_tpl_vars['groupName'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h1>

<br />

<?php if (! $this->_tpl_vars['loggedin']): ?>

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
    <textarea id="ownSyncCode" cols="70" rows="3"><?php echo $this->_tpl_vars['ownSyncCode']; ?>
</textarea>
    <br />
    <span class="jslink" id="ownSyncCode_copy">In Zwischenable kopieren</span>

</fieldset>

<br />
<br />

<?php endif; ?>

<form action="?" method="get">
    <fieldset>
        <legend>Daten einsehen</legend>
        Hier kannst du die gesamten gespeicherten Daten anschauen.
        <br />
        <br />
        <?php if ($this->_tpl_vars['groupdata']): ?>
        <input type="hidden" name="q" value="record" />
        <select name="id">

        <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['groupdata']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
        <?php echo '<option '; ?><?php if ($this->_tpl_vars['groupdata'][$this->_sections['i']['index']]['author'] == $this->_tpl_vars['groupdata_ownid']): ?><?php echo 'style="background:Silver" '; ?><?php endif; ?><?php echo 'value="'; ?><?php echo $this->_tpl_vars['groupdata'][$this->_sections['i']['index']]['id']; ?><?php echo '">'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['groupdata'][$this->_sections['i']['index']]['time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%y - %T") : smarty_modifier_date_format($_tmp, "%d.%m.%y - %T")); ?><?php echo ' von '; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['groupdata'][$this->_sections['i']['index']]['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?><?php echo ' @ver'; ?><?php echo $this->_tpl_vars['groupdata'][$this->_sections['i']['index']]['version']; ?><?php echo '</option>'; ?>

        <?php endfor; endif; ?>
        </select>
        <input type="submit" name="submit" value="Zeigen" />

        <br />
        Deine eigenen Uploads sind grau hinterlegt.
        <br />
        Insgesamt sind <?php echo $this->_tpl_vars['groupdata_length']; ?>
 Einträge gespeichert.

        <?php else: ?>
        Es sind noch keine Daten vorhanden
        <?php endif; ?>


    </fieldset>
</form>