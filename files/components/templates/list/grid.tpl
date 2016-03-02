{if $Grid->GetEnabledInlineEditing()}
<script type="text/javascript">
    $(function()
    {ldelim}
        $('#{$Grid->GetName()}.grid').sm_inline_grid_edit(
        {ldelim}
			cancelButtonHint: '{$Captions->GetMessageString('Cancel')}',
			commitButtonHint: '{$Captions->GetMessageString('Commit')}',
            requestAddress: '{$Grid->GetInlineEditRequestsAddress()}',
            useBlockGUI: true,
			useImagesForActions: {if $Grid->GetUseImagesForActions()}true{else}false{/if},
            editingErrorMessageHeader: '{$Captions->GetMessageString('ErrorsDuringUpdateProcess')}'
        {rdelim});

    {rdelim});
</script>
{/if}

{if $UseFilter}
{strip}
    {$SearchControl}
    <br/>
{/strip}
{/if}

{if $AllowDeleteSelected}
<form name="selectedRecords" method="POST" action="{$Grid->GetDeleteSelectedLink()}">
    <input type="hidden" name="operation" value="delsel">
    <input type="hidden" name="recordCount" value="{$RecordCount}">
{/if}

{if $Grid->GetHighlightRowAtHover()}
<script type="text/javascript"> 
    EnableHighlightRowAtHover('.grid');
</script>
{/if}
<div class="table-responsive">
<table id="{$Grid->GetName()}" class="grid table"{if !$Grid->UseAutoWidth()} style="width: {$Grid->GetWidth()}"{/if}>
    {if $Grid->GetShowAddButton() or $AllowDeleteSelected or $Grid->GetShowUpdateLink()}
    <tr>
        {strip}
        <td colspan="{$ColumnCount}" class="grid_menu">
			
            {counter start=0 assign="grid_menu_links"}

            {if $Grid->GetShowInlineAddButton()}
                {if $grid_menu_links > 0}|{/if}
                <a class="inline_add_button grid_menu_link" href="#">{$Captions->GetMessageString('AddNewRecordInline')}</a>
                {counter assign="grid_menu_links"}
            {/if}
            {if $Grid->GetShowAddButton()}
                {if $grid_menu_links > 0}|{/if}
                <a class="grid_menu_link" href="{$Grid->GetAddRecordLink()}">{$Captions->GetMessageString('AddNewRecord')}</a>
                {counter assign="grid_menu_links"}
            {/if}
            {if $AllowDeleteSelected}
                {if $grid_menu_links > 0}|{/if}
                <a class="grid_menu_link" href="" onclick="ShowYesNoDialog('Confirmation', 'Delete records?', function() {ldelim} document.selectedRecords.submit(); {rdelim}, function () {ldelim} {rdelim}); return false;">
					{$Captions->GetMessageString('DeleteSelected')}
				</a>
                {counter assign="grid_menu_links"}
            {/if}
            {if $Grid->GetShowUpdateLink()}
                {if $grid_menu_links > 0}|{/if}
                <a class="grid_menu_link" href="{$Grid->GetUpdateLink()}">{$Captions->GetMessageString('Refresh')}</a>
                {counter assign="grid_menu_links"}
            {/if}
        </td>
        {/strip}
    </tr>
    {/if}
    {if $Grid->GetErrorMessage() != ''}
    <tr><td class="odd grid_error_row" colspan="{$ColumnCount}" >
        <div class="grid_error_message">
        <strong>{$Captions->GetMessageString('ErrorsDuringDeleteProcess')}</strong><br><br>
        {$Grid->GetErrorMessage()}
        </div>
    </td></tr>
    {/if}

    <!-- <Grid Head> -->
    <tr id="grid_header">
        {if $AllowDeleteSelected}
            <th class="odd">
                <input type="checkbox" name="rec{$smarty.foreach.RowsGrid.index}" onClick="var i; for(i = 0; i < {$RecordCount}; i++) document.getElementById('rec' + i).checked = this.checked">
            </th>
        {/if}
        <!-- <Grid Head Columns> -->
        {foreach item=Band from=$Bands name=BandsHeader}
        {if $Band->GetUseConsolidatedHeader()}
            {if $Band->HasColumns()}
                <th colspan="{$Band->GetColumnCount()}" {if not $smarty.foreach.BandsHeader.last}style="{if $Page->GetPageDirection() eq 'rtl'}border-left{else}border-right{/if}: solid 2px #000000;"{/if} class="{if $smarty.foreach.BandsHeader.index is even}even{else}odd{/if}">
                    {$Band->GetCaption()}
                </th>
            {/if}
        {else}
            {foreach item=Column from=$Band->GetColumns() name=Header}
                {strip}
                <th class="{if $smarty.foreach.Header.index is even}even{else}odd{/if}"{if $HeadColumnsStyles[$smarty.foreach.BandsHeader.index][$smarty.foreach.Header.index] != ''} style="{$HeadColumnsStyles[$smarty.foreach.BandsHeader.index][$smarty.foreach.Header.index]}"{/if}>
                    {$Renderer->Render($Column->GetHeaderControl())}
                </th>
                {/strip}
            {/foreach}
        {/if}
        {/foreach}
        <!-- </Grid Head Columns> -->
    </tr>

    <!-- </Grid Head> -->

	<tr id="grid_empty" class="new-record-row" style="display: none;" data-new-row="false">
    {if $AllowDeleteSelected}
        {strip}
		<td class="odd" data-column-name="sm_multi_delete_column"></td>
		{/strip}
    {/if}
        {foreach item=Band from=$Bands name=BandsHeader}
            {foreach item=Column from=$Band->GetColumns() name=NewRowTemplate}
                {strip}
                <td data-column-name="{$Column->GetName()}" class="{if $smarty.foreach.NewRowTemplate.index is even}even{else}odd{/if}"  {if $smarty.foreach.NewRowTemplate.last & !$smarty.foreach.BandsHeader.last}style="border-right: solid 2px #000000;"{/if}>
                </td>
                {/strip}
            {/foreach}
        {/foreach}
	</tr>
    <tr data-new-row="false" class="new-record-after-row" style="display: none; border: none; height: 0px;">
        <td colspan="{$ColumnCount}" style="border: none; padding: 0px; height: 0px;"></td>
    </tr>


{if count($Rows) > 0}
    {foreach item=Row from=$Rows name=RowsGrid}

    <tr class="{if $smarty.foreach.RowsGrid.index is even}even{else}odd{/if}"{if $RowCssStyles[$smarty.foreach.RowsGrid.index] != ''} style="{$RowCssStyles[$smarty.foreach.RowsGrid.index]}"{/if}>
        {if $AllowDeleteSelected}
        {strip}
        <td class="odd" {if $RowCssStyles[$smarty.foreach.RowsGrid.index] != ''} style="{$RowCssStyles[$smarty.foreach.RowsGrid.index]}"{/if}>
            <input type="checkbox" name="rec{$smarty.foreach.RowsGrid.index}" id="rec{$smarty.foreach.RowsGrid.index}" />
            {foreach item=PkValue from=$RowPrimaryKeys[$smarty.foreach.RowsGrid.index] name=CPkValues}
                <input type="hidden" name="rec{$smarty.foreach.RowsGrid.index}_pk{$smarty.foreach.CPkValues.index}" value="{$PkValue}" />
            {/foreach}
        </td>
        {/strip}
        {/if}

        {foreach item=RowColumn from=$Row name=RowColumns}
        {strip}
            <td data-column-name="{$ColumnsNames[$smarty.foreach.RowColumns.index]}" char="{$RowColumnsChars[$smarty.foreach.RowsGrid.index][$smarty.foreach.RowColumns.index]}" class="{if $smarty.foreach.RowColumns.index is even}even{else}odd{/if}" {if $RowColumnsCssStyles[$smarty.foreach.RowsGrid.index][$smarty.foreach.RowColumns.index] != ''}style="{$RowColumnsCssStyles[$smarty.foreach.RowsGrid.index][$smarty.foreach.RowColumns.index]}"{/if}>
                {$RowColumn}
            </td>
        {/strip}
        {/foreach}
    </tr>
    
    {strip}
    <tr style="border: none; height: 0px;">
        <td colspan="{$ColumnCount}" style="border: none; padding: 0px; height: 0px;">
            {foreach item=AfterRow from=$AfterRows[$smarty.foreach.RowsGrid.index]}
                {$AfterRow}
            {/foreach}
        </td>
    </tr>
    {/strip}
    
    {/foreach}
{else} {* count($Rows) > 0 *}
{strip}
    <tr>
        <td colspan="{$ColumnCount}" class="emplygrid">
            {$Captions->GetMessageString('NoDataToDisplay')}
        </td>
    </tr>
{/strip}
{/if} {* count($Rows) > 0 *}
{if $Grid->GetShowAddButton() or $AllowDeleteSelected or $Grid->GetShowUpdateLink()}
    <tr>
        {strip}
        <td colspan="{$ColumnCount}" class="grid_menu">
            {counter start=0 assign="grid_menu_links"}

            {if $Grid->GetShowInlineAddButton()}
                {if $grid_menu_links > 0}|{/if}
                <a class="inline_add_button grid_menu_link" href="#">{$Captions->GetMessageString('AddNewRecordInline')}</a>
                {counter assign="grid_menu_links"}
            {/if}
            {if $Grid->GetShowAddButton()}
                {if $grid_menu_links > 0}|{/if}

                <a class="grid_menu_link" href="{$Grid->GetAddRecordLink()}">{$Captions->GetMessageString('AddNewRecord')}</a>

                {counter assign="grid_menu_links"}
            {/if}
            {if $AllowDeleteSelected}
                {if $grid_menu_links > 0}|{/if}
                <a class="grid_menu_link" href="" onclick="ShowYesNoDialog('Confirmation', 'Delete records?', function() {ldelim} document.selectedRecords.submit(); {rdelim}, function () {ldelim} {rdelim}); return false;">
					{$Captions->GetMessageString('DeleteSelected')}
				</a>
                {counter assign="grid_menu_links"}
            {/if}
            {if $Grid->GetShowUpdateLink()}
                {if $grid_menu_links > 0}|{/if}

                <a class="grid_menu_link" href="{$Grid->GetUpdateLink()}">{$Captions->GetMessageString('Refresh')}</a>

                {counter assign="grid_menu_links"}
            {/if}
        </td>
        {/strip}
    </tr>
{/if}
</table>
</div>
{if $AllowDeleteSelected}</form>{/if}