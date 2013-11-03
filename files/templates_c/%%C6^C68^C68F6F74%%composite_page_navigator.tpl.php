<?php /* Smarty version 2.6.26, created on 2011-03-16 21:33:31
         compiled from list/composite_page_navigator.tpl */ ?>
<!-- <Pages> -->
<div class="page_navigator">
<?php $_from = $this->_tpl_vars['PageNavigator']->GetPageNavigators(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['SubPageNavigator']):
?>
<div class="page_navigator">
<?php echo $this->_tpl_vars['Renderer']->Render($this->_tpl_vars['SubPageNavigator']); ?>

</div>
<?php endforeach; endif; unset($_from); ?>
</div>
<!-- </Pages> -->