<?php /* Smarty version 2.6.26, created on 2011-03-16 21:33:31
         compiled from editors/text_edit.tpl */ ?>
<?php if (! $this->_tpl_vars['TextEdit']->GetReadOnly()): ?><input <?php if ($this->_tpl_vars['TextEdit']->GetPasswordMode()): ?>type="password"<?php endif; ?> class="sm_text" id="<?php echo $this->_tpl_vars['TextEdit']->GetName(); ?>
" name="<?php echo $this->_tpl_vars['TextEdit']->GetName(); ?>
" value="<?php echo $this->_tpl_vars['TextEdit']->GetHTMLValue(); ?>
" <?php if ($this->_tpl_vars['TextEdit']->GetSize() != null): ?>size="<?php echo $this->_tpl_vars['TextEdit']->GetSize(); ?>
" style="width: auto;"<?php endif; ?> <?php if ($this->_tpl_vars['TextEdit']->GetMaxLength() != null): ?>maxlength="<?php echo $this->_tpl_vars['TextEdit']->GetMaxLength(); ?>
"<?php endif; ?>><?php else: ?>
<?php if (! $this->_tpl_vars['TextEdit']->GetPasswordMode()): ?><?php echo $this->_tpl_vars['TextEdit']->GetValue(); ?>
<?php else: ?>*************<?php endif; ?><?php endif; ?>