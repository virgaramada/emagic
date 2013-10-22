{if !empty($errors)}
<div id="errorContainer">
     {foreach from=$errors key=k item=v}
       <div class="error-message" id="errorMessages">{$v}</div>
     {/foreach}
   </div>   
{/if}

