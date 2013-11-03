<?php /* Smarty version 2.6.26, created on 2011-03-16 21:33:31
         compiled from hinted_text_box.tpl */ ?>
<span class="hinted_header"><span <?php if ($this->_tpl_vars['TextBox']->GetHint() != ''): ?>style="border-bottom: 1px dotted;"<?php endif; ?>><?php echo $this->_tpl_vars['TextBox']->GetInnerText(); ?>
</span>
<div class="box_hidden_header" style="display: none;"><?php echo $this->_tpl_vars['TextBox']->GetHint(); ?>
</div>
</span><?php echo $this->_tpl_vars['TextBox']->GetAfterLinkText(); ?>
