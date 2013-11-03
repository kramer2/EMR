<table align="center" width="95%" border="0" cellpadding="3" cellspacing="2">
    <tr valign="top">
{foreach item=Column from=$Columns}
        <td><b>{$Column->GetCaption()}</b></td>
{/foreach}
    </tr>
{foreach item=Row from=$Rows name=RowsGrid}
    <tr valign="top">
    <!---->
{foreach item=RowColumn from=$Row}
        <td>
            {$RowColumn}
        </td>
{/foreach}
    <!---->
    </tr>
{/foreach}
</table>
