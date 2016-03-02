{capture assign="ContentBlock"}
<body>
{include file='common/site_header.tpl'}
<div class="container" style="padding-top: 50px;">
  <div class="row" style="margin-bottom: 10px;">
    <div class="col-md-12">
      <br>
      {$Renderer->Render($LoginControl)}
    </div>
  </div>
</div>
</body>
{/capture}

{* Base template *}
{include file="common/base_page_template.tpl"}