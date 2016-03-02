<!--SEARCH CONTROL-->
<div class="panel panel-default text-center">
  <div class="panel-body">
    <form method="GET" name="SearchForm" class="form-inline" role="form">
      {foreach key=Name item=Value from=$SearchControl->GetHiddenValues()}
        <input type="hidden" name="{$Name}" value="{$Value}" />
      {/foreach}
      <input type="hidden" name="operation" value="ssearch" />
      <input type="hidden" name="ResetFilter" value="0" />
      <div class="form-group">
        <label class="filter-col" style="margin-right:0;" for="pref-perpage">{$Captions->GetMessageString('SearchFor')}:</label>
        <select class="form-control sfilter_comboBox" name="SearchField" id="SearchField">
        {foreach key=FieldName item=FieldCaption from=$SearchControl->GetFieldsToFilter()}
          <option value="{$FieldName}"{if $SearchControl->GetActiveFieldName() == $FieldName} selected{/if}>{$FieldCaption}</option>
        {/foreach}
        </select>
      </div>
      <div class="form-group">
        <select class="form-control sfilter_comboBox" name="FilterType" id="FilterType">
        {foreach key=FilterTypeIndex item=FilterTypeName from=$SearchControl->GetFilterTypes()}
          <option value="{$FilterTypeIndex}"{if $SearchControl->GetActiveFilterTypeName() == $FilterTypeIndex} selected{/if}>{$FilterTypeName}</option>
        {/foreach}
        </select>
      </div>
      <div class="form-group">
        <input class="form-control sfilter_text" type="text" size="20" name="FilterText" id="FilterText" value="{$SearchControl->GetActiveFilterText()}">
      </div>
      <p class="visible-sm"/>
      <div class="form-group">
        <button type="submit" class="btn btn-primary filter-col">
          {$Captions->GetMessageString('ApplySimpleFilter')}
        </button>
        <button type="submit" class="btn btn-default filter-col" onclick="document.forms.SearchForm.ResetFilter.value = '1'; document.forms.SearchForm.submit();">
           {$Captions->GetMessageString('ResetSimpleFilter')}
        </button>
      </div>
    </form>
  </div>
</div>

<script>
    {if $SearchControl->UseTextHighlight() != ''}
    $(document).ready(function(){ldelim}
    {foreach from=$SearchControl->GetHighlightedFields() item=HighlightFieldName}
        HighlightTextInGrid('.grid', '{$HighlightFieldName}', '{$SearchControl->GetTextForHighlight()}', '{$SearchControl->GetHighlightOption()}');
    {/foreach}
    {rdelim});
    {/if}
</script>