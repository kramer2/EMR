<div id="advanced_search_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{$Captions->GetMessageString('AdvancedSearch')}</h4>
      </div>
      <div class="modal-body">
        <form method="POST" {if $AdvancedSearchControl->GetTarget() != ''}  action="{$AdvancedSearchControl->GetTarget()}"{/if} id="AdvancedSearchForm" name="AdvancedSearchForm" >

          <input type="hidden" name="operation" value="asearch" >
          <input type="hidden" id="AdvancedSearch" name="AdvancedSearch" value="1">
          <input type="hidden" id="ResetFilter" name="ResetFilter" value="0">

          <div class="form-group">
            <label>{$Captions->GetMessageString('SearchFor')}:</label><br>
            <div class="radio-inline">
              <label>
                <input type="radio" name="SearchType" value="and" {if $AdvancedSearchControl->GetIsApplyAndOperator()} checked{/if}>
                {$Captions->GetMessageString('AllConditions')}
              </label>
            </div>
            <div class="radio-inline">
              <label>
                <input type="radio" name="SearchType" value="pr" {if not $AdvancedSearchControl->GetIsApplyAndOperator()} checked{/if}>
                {$Captions->GetMessageString('AnyCondition')}
              </label>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table">
              <tr class="adv_filter_head">
                <td class="adv_filter_field_head">&nbsp;</td>
                <td class="adv_filter_not_head bg-warning">{$Captions->GetMessageString('Not')}</td>
                <td colspan="3" class="adv_filter_editors_head">&nbsp;</td>
              </tr>
              {foreach item=Column from=$AdvancedSearchControl->GetSearchColumns() name=ColumnsIterator}
              <tr class="adv_filter_row">
                <td class="adv_filter_field_name_cell">{$Column->GetCaption()}</td>
                <td class="adv_filter_not_cell bg-warning">
                {smart_strip}
                  <input type="checkbox" name="{$Column->GetNotMarkInputName()}" value="{$FilterTypeIndex}" {if $Column->IsApplyNotOperator()} checked="checked"{/if}>
                {/smart_strip}
                </td>
                <td class="adv_filter_operator_cell">
                  <select class="form-control sm_comboBox adv_filter_type" style="width: 120px;" id="{$Column->GetFiterTypeInputName()}" name="{$Column->GetFiterTypeInputName()}" onchange="if (document.getElementById('{$Column->GetFiterTypeInputName()}').value == 'between') document.getElementById('{$Column->GetFieldName()}_second').style.display = ''; else document.getElementById('{$Column->GetFieldName()}_second').style.display = 'none';     if (document.getElementById('{$Column->GetFiterTypeInputName()}').value == 'IS NULL') document.getElementById('{$Column->GetFieldName()}_value').style.display = 'none'; else document.getElementById('{$Column->GetFieldName()}_value').style.display = '';">
                  {foreach key=FilterTypeName item=FilterTypeCaption from=$Column->GetAvailableFilterTypes()}
                    {smart_strip}
                    <option value="{$FilterTypeName}" {if $Column->GetActiveFilterIndex() eq $FilterTypeName} selected{/if}>
                      {$FilterTypeCaption}
                    </option>
                    {/smart_strip}
                  {/foreach}
                  </select>
                </td>
                <td class="adv_filter_editor1_cell">
                  {$Renderer->Render($Column->GetEditorControl())}
                </td>
                <td class="adv_filter_editor2_cell">
                  <span id="{$Column->GetFieldName()}_second">
                    {$Renderer->Render($Column->GetSecondEditorControl())}
                  </span>
                </td>
              </tr>
              {/foreach}
            </table>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button id="advsearch_submit" class="btn btn-primary" data-dismiss="modal" type="submit" >
            {$Captions->GetMessageString('ApplyAdvancedFilter')}
        </button>
        <button class="btn btn-default" type="submit" onclick="javascript: document.forms.AdvancedSearchForm.ResetFilter.value = '1'; document.forms.AdvancedSearchForm.submit();">
            {$Captions->GetMessageString('ResetAdvancedFilter')}
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script language="javascript">
  {foreach item=Column from=$AdvancedSearchControl->GetSearchColumns() name=ColumnsIterator}
    if (document.getElementById('{$Column->GetFiterTypeInputName()}').value == 'between')
        document.getElementById('{$Column->GetFieldName()}_second').style.display = '';
    else
        document.getElementById('{$Column->GetFieldName()}_second').style.display = 'none';

    if (document.getElementById('{$Column->GetFiterTypeInputName()}').value == 'IS NULL')
        document.getElementById('{$Column->GetFieldName()}_value').style.display = 'none';
    else
        document.getElementById('{$Column->GetFieldName()}_value').style.display = '';
  {/foreach}

  {if $AdvancedSearchControl->IsActive()}
    $(document).ready(function(){ldelim}
      {foreach from=$AdvancedSearchControl->GetHighlightedFields() item=HighlightFieldName name=HighlightFields}
        HighlightTextInGrid('.grid', '{$HighlightFieldName}', '{$TextsForHighlight[$smarty.foreach.HighlightFields.index]}', '{$HighlightOptions[$smarty.foreach.HighlightFields.index]}');
      {/foreach}
    {rdelim});    
  {/if}

  $(function() {ldelim}
	$('#advsearch_submit').click(function() {ldelim}
	  var hasNotEmpty = false;
	  $('table.table').find('td.adv_filter_editor1_cell').find('input').each(function() {ldelim}
		if ($(this).closest('tr').find('.adv_filter_operator_cell').find('select').val() == 'IS NULL')
		  hasNotEmpty = true;	
		if ($(this).val() != '')
		  hasNotEmpty = true;	
	  {rdelim});
	  if (!hasNotEmpty) {ldelim}
	    ShowOkDialog('{$Captions->GetMessageString('EmptyFilter_MessageTitle')}', '{$Captions->GetMessageString('EmptyFilter_Message')}');
      {rdelim} else {ldelim}
        $('#AdvancedSearchForm').submit();
      {rdelim}
	  return true;
	{rdelim});
  {rdelim});
</script>

