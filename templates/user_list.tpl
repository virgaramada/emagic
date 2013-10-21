{if !empty($user_list)}
<table border="0" cellspacing="0" cellpadding="0">
  <tr><td id="vertical-spacer"><img src="images/dot.gif" border="0" /><h4>Daftar User</h4></td></tr>
</table>
<br/>
{assign var=action_url value="UserManagementAction.php"}

{if ($smarty.session.user_role eq 'SUP')}
    {assign var=action_url value="SuperuserManagementAction.php"}
{/if}
{if ($smarty.session.user_role eq 'PUS')}
    {assign var=action_url value="PowerUserManagementAction.php"}

{/if}
{if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN')}
    {assign var=action_url value="UserManagementAction.php"}

{/if}
<table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
	<tr>
	<td>
            <table  border="0" cellspacing="0" cellpadding="0" id="inner-table">
              <tr class="title"><td colspan="6" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
              <tr class="title">
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tipe</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Login</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Nama</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Email</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Aktif</td>
				<td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
        </tr>
        <tr class="title"><td colspan="6"><img src="images/dot.gif" border="0" height="10" width="1"/></td>
            </tr>
       {section name=c loop=$user_list}
        
        <tr>
               <td><img src="images/dot.gif" border="0" height="1" width="10"/>
               {if !empty($active_roles)}
	               {foreach from=$active_roles key=k item=v}
	                  {if $user_list[c]->getUserRole() eq $v}
	                        {$k}
	                  {/if}
	               {/foreach}
	            {else}
	               {$user_list[c]->getUserRole()}
               {/if}
               </td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$user_list[c]->getUsername()}</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$user_list[c]->getFirstName()}<img src="images/dot.gif" border="0" height="1" width="10"/>{$user_list[c]->getLastName()}</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$user_list[c]->getEmailAddress()}</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{if ($user_list[c]->isAccountActivated() eq 'true')} Ya {else} Tidak {/if} </td>
 		  <td><a href="{$action_url}?method=edit&amp;user_id={$user_list[c]->getUserId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Ubah</a> 
 		  <img src="images/dot.gif" border="0" height="1" width="1"/>
 		  {if ($user_list[c]->isAccountActivated() eq 'true')} 
 		  <a href="{$action_url}?method=passivateAccount&amp;user_id={$user_list[c]->getUserId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Non-aktifkan</a> 
 		  {else} 
 		  <a href="{$action_url}?method=activateAccount&amp;user_id={$user_list[c]->getUserId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Aktifkan</a>
 		  {/if}
 		  {if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'PUS')}
 		  <img src="images/dot.gif" border="0" height="1" width="1"/>
 		  <a id="user_list_delete_{$smarty.section.c.index}" href="{$action_url}?method=delete&amp;user_id={$user_list[c]->getUserId()}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus data?');">Hapus</a>
 		  {/if}</td>
        </tr>
        
       {/section}

         <tr>
   <td colspan="6" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
 </tr>
 <tr><td colspan="6" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedUserList}</td></tr>
         {if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'PUS')}
            <tr><td colspan="6" align="right"><a id="user_list_delete_all" href="{$action_url}?method=deleteAll{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus semua data?');">Hapus Semua</a><img src="images/dot.gif" border="0" height="1" width="10"/></td>
            </tr>
              <tr><td colspan="6"><img src="images/dot.gif" border="0" height="10" width="1"/></td>
            </tr>
         {/if}
      </table>
	  </td>
		</tr>
		</table>
{/if}
