{capture assign="HeadMetaTags"}
    {if $Page->HasRss()}
    <link rel="alternate" type="application/rss+xml" title="RSS" href="{$Page->GetRssLink()}" />
    {/if}
    {$HeadMetaTags}
{/capture}

{capture assign="ContentBlock"}
<body>

{if not $Page->GetVisualEffectsEnabled()}
<!-- Turn on visual effects -->
<script type="text/javascript">
    jQuery.fx.off = true;
</script>
{/if}

{include file='common/site_header.tpl'}
<style type="text/css">
@media (min-width: 600px) {ldelim}
  .table-responsive {ldelim}
    overflow: visible;
  {rdelim}
  #grid_header th {ldelim}
    white-space: nowrap;
  {rdelim}
{rdelim}
</style>
<div class="visible-xs" style="padding:28px;"></div>
<div class="container" style="padding-top: 50px;">
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-12">
            {if $Page->GetMessage() != null && $Page->GetMessage() != ''}
                <div class="alert alert-danger">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Error:</strong> {$Page->GetMessage()}
                </div>
            {/if}
            <div class="row">                
                <div class="col-md-12 text-center">
                    <h1>{$Page->GetCaption()}</h2>
                </div>
            </div>
            <div class="row">
                {if $Page->GetPrinterFriendlyAvailable() or
                $Page->GetExportToExcelAvailable() or
                $Page->GetExportToWordAvailable() or
                $Page->GetExportToXmlAvailable() or
                $Page->GetExportToCsvAvailable() or
                $Page->GetExportToPdfAvailable()}
                <div class="col-md-9">
                  {if $Page->GetAdvancedSearchAvailable()}
                    {if isset($AdvancedSearch) and !empty($AdvancedSearch)}
                      {strip}
                        <!--<a id="advanced_search_link" href="javascript: ;" onclick="javascript: $('#searchControl').slideToggle('slow');" class="adv_filter_link{if $IsAdvancedSearchActive} active{/if}">-->
                        <a id="advanced_search_link" href="#" data-toggle="modal" data-target="#advanced_search_modal" style="height: 36px;display: block;line-height: 36px;">
                          {$Captions->GetMessageString('AdvancedSearch')}
                            {if $IsAdvancedSearchActive} *{/if}
                        </a>
                        {if $IsAdvancedSearchActive}
                          <div class="visible-md" style="display: none;" id="advanced_search_condition">
                            {$Captions->GetMessageString('SearchCondtitions')}:
                            <table class="advanced_search_hint">
                              {foreach from=$FriendlyAdvancedSearchCondition item=FieldCondition}
                              <tr>
                                <td>{$FieldCondition.Caption} </td>
                                <td>{$FieldCondition.Condition}</td>
                              </tr>
                              {/foreach}
                            </table>
                          </div>
                          <div class="visible-xs visible-sm">
                            {$Captions->GetMessageString('SearchCondtitions')}:
                            <br>
                            <ul>
                            {foreach from=$FriendlyAdvancedSearchCondition item=FieldCondition}
                              <li><label>{$FieldCondition.Caption}: </label>{$FieldCondition.Condition}</li>
                            {/foreach}
                            </ul>
                          </div>
                        {/if}
                      {/strip}
                    {/if}
                  {/if}
                  {if $Page->GetAdvancedSearchAvailable()}{$AdvancedSearch}{/if}
                </div>
                <div class="col-md-3 text-right">
                    {if $Page->GetExportToExcelAvailable() or $Page->GetExportToWordAvailable() or $Page->GetExportToXmlAvailable() or $Page->GetExportToCsvAvailable() or $Page->GetExportToPdfAvailable()}
                    <p class="visible-xs visible-sm"/>
                    <div class="dropdown pull-right">
                      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="glyphicon glyphicon"></i>
                        {$Captions->GetMessageString('Export')}
                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right">
                        {if $Page->GetExportToExcelAvailable()}
                        <li><a class="" href="{$Page->GetExportToExcelLink()}">{$Captions->GetMessageString('ExportToExcel')}</a></li>
                        {/if}
                        {if $Page->GetExportToWordAvailable()}
                        <li><a class="" href="{$Page->GetExportToWordLink()}">{$Captions->GetMessageString('ExportToWord')}</a></li>
                        {/if}
                        {if $Page->GetExportToXmlAvailable()}
                        <li><a class="" href="{$Page->GetExportToXmlLink()}">{$Captions->GetMessageString('ExportToXml')}</a></li>
                        {/if}
                        {if $Page->GetExportToCsvAvailable()}
                        <li><a class="" href="{$Page->GetExportToCsvLink()}">{$Captions->GetMessageString('ExportToCsv')}</a></li>
                        {/if}
                        {if $Page->GetExportToPdfAvailable()}
                        <li><a class="" href="{$Page->GetExportToPdfLink()}" target="_blank">{$Captions->GetMessageString('ExportToPdf')}</a></li>
                        {/if}
                      </ul>
                    </div>
                    {/if}
                    {if $Page->GetPrinterFriendlyAvailable()}
                    <div class="dropdown pull-right" style="margin-right: 5px;">
                      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-print"></i>
                        {$Captions->GetMessageString('Print')}
                        <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right">
                        <li><a class="print-page" href="{$Page->GetPrintCurrentPageLink()}">{$Captions->GetMessageString('PrintCurrentPage')}</a></li>
                        <li><a class="print-page" href="{$Page->GetPrintAllLink()}">{$Captions->GetMessageString('PrintAllPages')}</a></li>
                      </ul>
                    </div>
                    {/if}
                    <p class="" style="clear: both;"/>
                </div>
                {/if}
            </div>
            <div class="row">
                {if $Page->GetShowTopPageNavigator()}
                    {$PageNavigator}
                {/if}
            </div>
            <div class="row">
                {$ContentBlock}
            </div>
            <div class="row">
                {if $Page->GetShowBottomPageNavigator()}
                    {$PageNavigator2}
                {/if}
            </div>
        </div>
    </div>
    {if $Page->GetGridHeader() != ''}
        <div style="margin-top: 5px; margin-bottom: 5px;">
            {$Page->GetGridHeader()}
        </div>
    {/if}

    {if $IsAdvancedSearchActive}
        <script>
          if (findBootstrapEnvironment() != 'xs' && findBootstrapEnvironment() != 'sm') {ldelim}
            $('#advanced_search_link').qtip({ldelim}
              container: 'advanced_search_link_cont',
              content:($('#advanced_search_condition').html()),
              position:'center',
              tip_class: 'qtip-wrapper-asearch'
            {rdelim});
          {rdelim}
        </script>
    {/if}
    {$Page->GetFooter()}
</div>
</body>
{/capture}

{* Base template *}
{include file="common/base_page_template.tpl"}