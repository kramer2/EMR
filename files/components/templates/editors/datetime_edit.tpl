{if !$DateTimeEdit->GetReadOnly()}
{if $RenderText}
<input type="text" name="{$DateTimeEdit->GetName()}" id="{$DateTimeEdit->GetName()}" value="{$DateTimeEdit->GetValue()}">
<button type="button" id="{$DateTimeEdit->GetName()}_trigger">...</button>
{/if}
{if $RenderScripts}
{if $RenderText}
<script type="text/javascript">
{/if}
    Calendar.setup({ldelim}
        inputField     :    "{$DateTimeEdit->GetName()}",
        dateFormat     :    "{$DateTimeEdit->GetFormat()}",
        showTime       :    {if $DateTimeEdit->GetShowsTime()}true{else}false{/if},
        trigger        :    "{$DateTimeEdit->GetName()}_trigger",
        minuteStep     :    1,
        onSelect       :    function() {ldelim} this.hide() {rdelim},
        fdow           :    {$DateTimeEdit->GetFirstDayOfWeek()}
    {rdelim});
{if $RenderText}
</script>
{/if}
{/if}
{else}
{if $RenderText}
{$DateTimeEdit->GetValue()}
{/if}
{/if}