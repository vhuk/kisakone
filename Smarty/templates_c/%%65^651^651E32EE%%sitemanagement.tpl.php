<?php /* Smarty version 2.6.26, created on 2010-02-17 19:17:02
         compiled from sitemanagement.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'translate', 'sitemanagement.tpl', 22, false),array('function', 'submenulinks', 'sitemanagement.tpl', 26, false),)), $this); ?>
<?php $this->_cache_serials['./Smarty/templates_c/%%65^651^651E32EE%%sitemanagement.tpl.inc'] = '755e429c01a0045da2e1d189b8167cc0'; ?><?php if ($this->caching && !$this->_cache_including): echo '{nocache:755e429c01a0045da2e1d189b8167cc0#0}'; endif;echo translate_smarty(array('assign' => 'title','id' => 'sitemanagement_title'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:755e429c01a0045da2e1d189b8167cc0#0}'; endif;?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->caching && !$this->_cache_including): echo '{nocache:755e429c01a0045da2e1d189b8167cc0#1}'; endif;echo translate_smarty(array('id' => 'admin_main_text'), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:755e429c01a0045da2e1d189b8167cc0#1}'; endif;?>

<?php echo submenulinks_smarty(array(), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>