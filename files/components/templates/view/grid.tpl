<div class="visible-xs" style="padding:28px;"></div>
<div class="container" style="padding-top: 50px;padding-bottom: 30px;">
<!--<div align="center" style="width: auto">-->
  <div class="panel panel-default panel-primary" id="panel-view" style="max-width: 500px;margin: 0 auto;">
    <div class="panel-heading">
      <h3>{$Title}</h3>
    </div>
    <div class="panel-body">
      {if $PrintOneRecord}
      <div align="right" style="max-width: 500px; padding-bottom: 3px;margin: 0 auto;" class="auxiliary_header_text">
        <a class="print-page" href="{$PrintRecordLink}">{$Captions->GetMessageString('PrintOneRecord')}</a>
      </div>
      {/if}
      {section name=RowGrid loop=$ColumnCount}
        <div class="row">
          <div class="col-md-4"><strong class="caption-text">{$Columns[$smarty.section.RowGrid.index]->GetCaption()}</strong></div>
          <div class="col-md-8">
            {$Row[$smarty.section.RowGrid.index]}
          </div>
        </div>
      {/section}
    </div>
    <div class="panel-footer">
      <input class="btn btn-default" type="button" value="{$Captions->GetMessageString('BackToList')}" onclick="window.location.href='{$Grid->GetReturnUrl()}'"/>
    </div>
  </div>
</div>

<style type="text/css">
  #panel-view .row {ldelim}
    border-top: solid 1px #F1F1F1;
    margin-top: 5px;
    margin-bottom: 5px;
    padding-top: 10px;
    padding-bottom: 10px;
  {rdelim}

  #panel-view .row .caption-text {ldelim}
    height: 34px;
    line-height: 34px;
    display: inline-block;
    text-decoration: underline;
  {rdelim}
</style>
