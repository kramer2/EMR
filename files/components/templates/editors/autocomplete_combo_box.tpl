{if !$ComboBox->GetReadOnly()}
{if $RenderText}
<div id="{$ComboBox->GetName()}_container" class="dropdown_container" style="width: {$ComboBox->GetSize()};">
    <table class="dropdown_button_container" cellpadding="0" cellspacing="0">
        <tr>
            <td class="dropdown_input_container" style="background-color: #fff;">
                <input type="text" id="{$ComboBox->GetName()}_selector" class="dropdown_input" value="{$ComboBox->GetDisplayValue()}" />
                <input type="hidden" id="{$ComboBox->GetName()}" name="{$ComboBox->GetName()}" value="{$ComboBox->GetValue()}" />
            </td>
            <td class="dropdown_button_column" style="width:15px;">  </td>
        </tr>
    </table>
</div>
{/if}
{if $RenderScripts}
{if $RenderText}
<script type="text/javascript">
    $(document).ready(function(){ldelim}
{/if}
        SetupAutocomplete('{$ComboBox->GetName()}', '{$ComboBox->GetHandlerName()}');
{if $RenderText}
    {rdelim});
</script>
{/if}
{/if}
{else}
{$ComboBox->GetDisplayValue()}
{/if}