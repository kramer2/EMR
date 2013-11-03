{if $RenderText}
{if !$CheckBox->GetReadOnly()}
<input type="checkbox" name="{$CheckBox->GetName()}" id="{$CheckBox->GetName()}" value="on" {if $CheckBox->Checked()} checked="checked"{/if}>
{else}
{if $CheckBox->Checked()}
<img src="images/checked.png" />
{/if}
{/if}
{/if}