<!-- <Pages> -->
<div class="">
  {if $PageNavigator->GetPageCount() > 1}
    
    <ul class="pagination">
      <li>
        <span id="">
          {assign var="current_page" value=$PageNavigator->CurrentPageNumber()}
          {assign var="page_count" value=$PageNavigator->GetPageCount()}
          {assign var="current_page_info_template" value=$Captions->GetMessageString('PageNumbetOfCount')}
          {eval var=$current_page_info_template}
        </span>
      </li>
      {foreach item=PageNavigatorPage from=$PageNavigatorPages}
        {if $PageNavigatorPage->IsCurrent()}
          <li class="active"><span title="{$PageNavigatorPage->GetHint()}">{$PageNavigatorPage->GetPageCaption()}</span></li>
        {else}
          <li><a href="{$PageNavigatorPage->GetPageLink()}" title="{$PageNavigatorPage->GetHint()}">{$PageNavigatorPage->GetPageCaption()}</a></li>
        {/if}
      {/foreach}
    </ul>
  {/if}
</div>

<script>
  {if $PageNavigator->HasPreviosPage()}
    BindPageDecrementShortCut('{$PageNavigator->PreviosPageLink()}');
  {/if}
  {if $PageNavigator->HasNextPage()}
    BindPageIncrementShortCut('{$PageNavigator->NextPageLink()}');
  {/if}
		
	$(function() {ldelim}
		$('#pgui-dialog-cusomize-page-nav-size_{$PageNavId}').dialog({ldelim}
			autoOpen: false,
			resizable: false,
			modal: true,
			width : 400,
			buttons: {ldelim}
				Cancel: function() {ldelim}
					$(this).dialog('close');
				{rdelim},
				OK: function() {ldelim}
					ApplyPageSize($('#pgui-dialog-cusomize-page-nav-size_{$PageNavId}'));
					$(this).dialog('close');
				{rdelim}
			{rdelim}
		{rdelim});

    $('#page_size_apply_changes').click(function(){ldelim}
      ApplyPageSize($('#page_size_modal_body_{$PageNavId}'));
    {rdelim});

		$('#pgui-customize-page-nav-size_{$PageNavId}').click(function() {ldelim}
			$('#pgui-dialog-cusomize-page-nav-size_{$PageNavId}').dialog('open');
			return false;
		{rdelim});
	{rdelim});
</script>

{if ($PageNavigator->GetPageCount() > 1) | ( ($PageNavigator->GetPageCount() <= 1) & ($PageNavId == 1) )}
  {assign var="rec_count_per_page" value=$PageNavigator->GetRowsPerPage()}
  {if $PageNavigator->GetRowsPerPage() == 0}
	 {$rec_count_per_page =$PageNavigator->GetRowCount()}
  {/if}
  <!--<a href="#" id="pgui-customize-page-nav-size_{$PageNavId}" class="pgui-customize-page-nav-size">-->
  <a href="#" data-toggle="modal" data-target="#page_size_modal" class="pgui-customize-page-nav-size">
    {eval var=$Captions->GetMessageString('CustomizePageSize')}
  </a>

  <div id="page_size_modal" class="modal fade" role="dialog">
    <div class="modal-dialog" title="{eval var=$Captions->GetMessageString('ChangePageSizeTitle')}">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          {assign var="row_count" value=$PageNavigator->GetRowCount()}
          <h4 class="modal-title">{eval var=$Captions->GetMessageString('ChangePageSizeText')}</h4>
        </div>
        <div class="modal-body" id="page_size_modal_body_{$PageNavId}">
          <table cellspacing="0" cellpadding="0" class="table table-hover table-striped">
            <tr>
              <th>{$Captions->GetMessageString('RecordsPerPage')}</th>
              <th>{$Captions->GetMessageString('TotalPages')}</th>
            </tr>
            {foreach from=$PageNavigator->GetRecordsPerPageValues() key=name item=value}
            <tr>
              <td>
                <div class="radio">
                  <label><input type="radio" value="{$name}" name="recperpage_{$PageNavId}">{$value}</label>
                </div>
              </td>
              <td>{$PageNavigator->GetPageCountForPageSize($name)}</td>
            </tr>
            {/foreach}
            <tr>
              <td>
                <div class="radio">
                  <label>
                    <input type="radio" value="custom" name="recperpage_{$PageNavId}" checked="checked" />
                    {$Captions->GetMessageString('UseCustomPageSize')}
                  </label>
                </div>
                <input onkeyup="$('#custom_page_size_page_count_{$PageNavId}').html( GetPageCountForPageSize(this.value, {$PageNavigator->GetRowCount()}) )" name="recperpage_custom" value="{$PageNavigator->GetRowsPerPage()}" class="control-form"/>
              </td>
              <td><span id="custom_page_size_page_count_{$PageNavId}">{$PageNavigator->GetPageCount()}</span></td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button id="page_size_apply_changes" class="btn btn-default" data-dismiss="modal" type="submit" >
            {$Captions->GetMessageString('ApplyAdvancedFilter')}
          </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
{/if}

