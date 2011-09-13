<?php /* Smarty version 2.6.26, created on 2011-09-12 21:15:33
         compiled from index.tpl */ ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="UTF-8"<?php echo '?>'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="de" >
    <head>
        <title>DS Duke &amp; Forum Assistant</title>

        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="Content-Script-Type" content="text/javascript" />
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
        <meta http-equiv="Content-Language" content="de" />

        <?php if ($this->_tpl_vars['redirect']): ?>
        <meta http-equiv="refresh" content="3; URL=<?php echo $this->_tpl_vars['redirect']; ?>
" />
        <?php endif; ?>

        <link rel="stylesheet" type="text/css" href="main.css" />

        <script type="text/javascript" src="mootools-core-1.3-full-compat-yc.js"></script>
        <script type="text/javascript" src="main.js"></script>
        <script type="text/javascript" src="ZeroClipboard.js"></script>
        <?php if ($this->_tpl_vars['js']): ?>
         <script type="text/javascript"><?php echo $this->_tpl_vars['js']; ?>
</script>
        <?php endif; ?>

    </head>
    <body>

        <h1>DS Duke &amp; Forum Assistant</h1>

        <?php if ($this->_tpl_vars['hint']): ?>
        <br />
        <div class="hint"><?php echo $this->_tpl_vars['hint']; ?>
</div>
        <br />
        <?php endif; ?>

        <?php if ($this->_tpl_vars['errors']): ?>
        <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['errors']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
        <?php echo '<br /><div class="error">'; ?><?php echo $this->_tpl_vars['errors'][$this->_sections['i']['index']]; ?><?php echo '</div><br />'; ?>

        <?php endfor; endif; ?>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['redirect']): ?>
            <br />
        <h2><img src="images/loader.gif" alt="Bitte warten" /> <a href="<?php echo $this->_tpl_vars['redirect']; ?>
"> Weiterleitung . . . . </a></h2>
            <br />
        <?php endif; ?>

        <div id="maincontent">
            <?php if ($this->_tpl_vars['moduleTpl']): ?>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['moduleTpl'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
        </div>

        <?php if ($this->_tpl_vars['outputbuffer']): ?>
        <div class="buffer"><span style="position:relative; color:FireBrick; top:-12px;">PHP Output:</span>
<?php echo $this->_tpl_vars['outputbuffer']; ?>

        </div>
        <?php endif; ?>



        <div id="navi">
            <br />
            <br />
            <?php if ($this->_tpl_vars['loggedin'] || $this->_tpl_vars['view']): ?><a href="?">Home</a><?php endif; ?>
            <?php if ($this->_tpl_vars['loggedin']): ?><a href="?q=view">Daten</a><?php endif; ?>

            <?php if ($this->_tpl_vars['loggedin'] || $this->_tpl_vars['view']): ?><a class="fr" href="?q=logout">Logout</a><?php endif; ?>
            <?php if (! $this->_tpl_vars['loggedin'] && ! $this->_tpl_vars['view']): ?><a class="fr" href="?q=login">Login</a><?php endif; ?>
            <br class="cr"/>

        </div>


        <div id="othernavi">
            <a class="fr" href="?q=about">Impressum</a>
            <br class="cr"/>
        </div>

            <div id="infobar">
            ds-duke-and-forum-assistant - 1.1
            </div>



    </body>

</html>