<?php /* Smarty version 2.6.26, created on 2011-09-12 21:26:31
         compiled from record.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'record.tpl', 31, false),array('modifier', 'escape', 'record.tpl', 31, false),)), $this); ?>
<h1><?php echo ((is_array($_tmp=$this->_tpl_vars['record']['time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%y - %T") : smarty_modifier_date_format($_tmp, "%d.%m.%y - %T")); ?>
 von <?php echo ((is_array($_tmp=$this->_tpl_vars['record']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 @version <?php echo $this->_tpl_vars['record']['version']; ?>
</h1>

<h2><a onclick="return confirm('Wirklich?');" href="?admin&amp;do=setcurrentversion&amp;id=<?php echo $this->_tpl_vars['record']['id']; ?>
">Auf diese Version zurücksetzen</a></h2>
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
<textarea readonly="readonly" id="recordjson" cols="100" rows="30"><?php echo $this->_tpl_vars['recordjson']; ?>
</textarea>
<br />
<span class="jslink" id="recordjson_copy">In Zwischenable kopieren</span>

</fieldset>