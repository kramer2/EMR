{include file='common/edit_validation_script.tpl'}
<div class="visible-xs" style="padding:28px;"></div>
<div class="container" style="padding-top: 50px;padding-bottom: 30px;">

<!--<div align="center" style="width: 100%">-->
  <div class="panel panel-default panel-primary"  style="max-width: 500px;margin: 0 auto;">
    <div class="panel-heading">
      <h3>{$Title}: {$Captions->GetMessageString('InsertRecord')}</h3>
    </div>
    <div class="panel-body">
      <div id="errorMessagesRow" style="display: none;" class="alert alert-danger fade in">
        <strong>{$Captions->GetMessageString('ClientValidationsErrors')}</strong><br/>
        <span id="errorMessages"></span>
      </div>
      {if $Grid->GetErrorMessage() != ''}
      <div class="alert alert-danger fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
        <strong>{$Captions->GetMessageString('ErrorsDuringInsertProcess')}</strong><br/>
        {$Grid->GetErrorMessage()}
      </div>
      {/if}
      <p class="help-block">{$Captions->GetMessageString('RequiredField')} <font color="#FF0000">*</font></p>
      <form name="insertform" id="insertform" enctype="multipart/form-data" method="POST" action="{$Grid->GetEditPageAction()}">
        {foreach key=HiddenValueName item=HiddenValue from=$HiddenValues}
          <input type="hidden" name="{$HiddenValueName}" value="{$HiddenValue}" />
        {/foreach}
		

        <!--<table class="grid table table-striped" style="width: auto;margin: 0 auto;">-->
        {foreach item=column from=$Grid->GetInsertColumns() name=Columns}
          <div class="row {if $smarty.foreach.Columns.index is even}even{else}odd{/if}">
            {assign var="num_cols" value=2}
            {if $column->GetShowSetToNullCheckBox()}
              {if $num_cols++}{/if}
            {/if}
            {if $column->GetAllowSetToDefault()}
              {if $num_cols++}{/if}
            {/if}
            <div class="col-md-{math equation="12/num" num=$num_cols}">
              <div class="caption-text"><strong>{$column->GetCaption()}</strong></div>
              {if not $column->GetAllowSetToNull()}<font color="#FF0000">*</font>{/if}
            </div>
            <div class="col-md-{math equation="12/num" num=$num_cols}">
              {$Renderer->Render($column)}
            </div>

            {if $column->GetShowSetToNullCheckBox()}
            <div class="col-md-{math equation="12/num" num=$num_cols}">
              <div class="checkbox null-check">
                <label>
                  <input type="checkbox" value="1" id="{$column->GetFieldName()}_null" name="{$column->GetFieldName()}_null"{if $column->IsValueNull()} checked="checked"{/if}/>{$Captions->GetMessageString('SetNull')}
                </label>
              </div>                   
            </div>
            {/if}     
            {if $column->GetAllowSetToDefault()}
            <div class="col-md-{math equation="12/num" num=$num_cols}">
              <div class="checkbox null-check">
                <label>
                  <input type="checkbox" value="1" name="{$column->GetFieldName()}_def" id="{$column->GetFieldName()}_def"/>{$Captions->GetMessageString('SetDefault')}
                </label>
              </div>
            </div>
            {/if}
          </div>
        {/foreach}
      </form>
    </div>
    <div class="panel-footer">
      <input class="btn btn-primary" type="button" value="{$Captions->GetMessageString('SaveNewRecord')}" name="submit1" onclick="if (ValidateControls()) document.insertform.submit();"/>
      <input class="btn btn-default" type="reset" value="{$Captions->GetMessageString('BackToList')}" onclick="window.location.href='{$Grid->GetReturnUrl()}'"/>
    </div>
  </div>
</div>
<style type="text/css">
  #insertform .row {ldelim}
    border-top: solid 1px #F1F1F1;
    margin-top: 5px;
    margin-bottom: 5px;
    padding-top: 10px;
    padding-bottom: 10px;
  {rdelim}

  #insertform .row .caption-text {ldelim}
    height: 34px;
    line-height: 34px;
    display: inline-block;
  {rdelim}

  @media (max-width: 990px) {ldelim}
    .null-check {ldelim}
      border-top: solid 1px #aaaaaa;
    {rdelim}
  {rdelim}
</style>