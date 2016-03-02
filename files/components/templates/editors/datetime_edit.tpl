{if !$DateTimeEdit->GetReadOnly()}
{if $RenderText}
<div class="input-group">
  <input type="text" class="form-control" name="{$DateTimeEdit->GetName()}" id="{$DateTimeEdit->GetName()}" value="{$DateTimeEdit->GetValue()}">
  <span class="input-group-btn">
    <button type="button" id="{$DateTimeEdit->GetName()}_trigger" class="btn btn-default">...</button>
  </span>
</div>

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