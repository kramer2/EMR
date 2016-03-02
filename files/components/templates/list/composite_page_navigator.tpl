<!-- <Pages> -->
<div class="col-md-12">
  {foreach item=SubPageNavigator from=$PageNavigator->GetPageNavigators()}
  
    {$Renderer->Render($SubPageNavigator)}
  
  {/foreach}
</div>
<!-- </Pages> -->
