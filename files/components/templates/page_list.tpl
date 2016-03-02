  {foreach item=PageLink from=$PageList->GetPages()}        
      <li class="{if $PageLink->GetShowAsText()}active{/if}">
        <a href="{$PageLink->GetLink()}" title="{$PageLink->GetHint()}">
          <span title="{$PageLink->GetHint()}">{$PageLink->GetCaption()}</span>
        </a>
      </li>
  {/foreach}
