
<div class="visible-xs" style="padding:28px;"></div>
<div class="container" style="padding-top: 50px;padding-bottom: 30px;">
  <!--<div align="center" style="width: auto">-->
  <div class="panel panel-default panel-primary" id="panel-delete" style="max-width: 500px;margin: 0 auto;">
    <div class="panel-heading">
      <h3>{$Title}</h3>
    </div>
    <div class="panel-body">
      {if $Grid->GetErrorMessage() != ''}
      <div class="alert alert-danger fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
        <strong>{$Captions->GetMessageString('ErrorsDuringDeleteProcess')}</strong><br/>
        {$Grid->GetErrorMessage()}
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
      <form name="deleteform" style="margin: 0px; padding: 0px;" enctype="multipart/form-data" method="POST" action="{$Grid->GetEditPageAction()}">
        {foreach key=HiddenValueName item=HiddenValue from=$HiddenValues}   
          <input type="hidden" name="{$HiddenValueName}" value="{$HiddenValue}" />
        {/foreach}
        <input class="btn btn-primary" type="submit" value="{$Captions->GetMessageString('Delete')}" />
        <input class="btn btn-default" type="button" value="{$Captions->GetMessageString('BackToList')}" onclick="window.location.href='{$Grid->GetReturnUrl()}'"/>
      </form>
    </div>
  </div>
</div>

<style type="text/css">
  #panel-delete .row {ldelim}
    border-top: solid 1px #F1F1F1;
    margin-top: 5px;
    margin-bottom: 5px;
    padding-top: 10px;
    padding-bottom: 10px;
  {rdelim}

  #panel-delete .row .caption-text {ldelim}
    height: 34px;
    line-height: 34px;
    display: inline-block;
    text-decoration: underline;
  {rdelim}
</style>
