{include file="header.tpl"}
<table  border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
 
    <td>
    {assign var=action_url value="UserManagementAction.php"}
    {assign var=ch_pass_action_url value="ChangePasswordAction.php"}

	{if ($smarty.session.user_role eq 'SUP')}
	    {assign var=action_url value="SuperuserManagementAction.php"}
	    {assign var=ch_pass_action_url value="PowerUserPasswordAction.php"}
	{/if}
	{if ($smarty.session.user_role eq 'PUS')}
	    {assign var=action_url value="PowerUserManagementAction.php"}
	    {assign var=ch_pass_action_url value="PowerUserPasswordAction.php"}
	
	{/if}
	{if ($smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'ADM')}
	     {assign var=action_url value="UserManagementAction.php"}
         {assign var=ch_pass_action_url value="ChangePasswordAction.php"}
	
	{/if}
      <form name="user_form" method="post" action="{$action_url}{php} echo ("?".strip_tags(SID));{/php}">
      <table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
         
            <table  border="0" cellspacing="0" cellpadding="0" id="inner-table">
           
            <tr><td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td class="title" colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>{if !empty($user)} Ubah {else} Tambah {/if} User</td>
              </tr>
              <tr><td colspan="2"><img src="images/dot.gif" border="0" height="10" width="1"/></td>
              </tr>
              
              {if !empty($user)}
              <input type="hidden" name="method" value="update"/>
              <input type="hidden" name="user_id" value="{$user->getUserId()}"/>
               {else}
               <input type="hidden" name="method" value="create"/>
               {/if}
               
                 <tr>
                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis User<font class="small-font">(*)</font></td>
                  <td>
                    <select name="user_role">
                  {if !empty($roles)}  
                    {if !empty($user)}
                     
                     {foreach from=$roles key=k item=v}
                      <option value="{$v}" {if ($user->getUserRole() eq $v)}selected=selected {/if}>{$k}</option>
                      {/foreach}
                   {else}
                     {foreach from=$roles key=k item=v}
                      <option value="{$v}">{$k}</option>
                      {/foreach}
                   {/if}
                 {/if} 
                    </select>
                  </td>
                  </tr>
                  
                  {if !empty($gas_station_list)}
                    <tr>
                    <td><img src="images/dot.gif" border="0" height="1" width="10"/>No SPBU<font class="small-font">(*)</font></td>
                   <td>
                    <select name="station_id">
                     
	                     {if !empty($user)}
	                        {section name=gs loop=$gas_station_list}
	                           <option value="{$gas_station_list[gs]->getStationId()}" {if ($user->getStationId() eq $gas_station_list[gs]->getStationId())} selected="selected" {/if}>{$gas_station_list[gs]->getStationId()}</option>
	                         {/section}
	                     {else}
	                        {section name=gs loop=$gas_station_list}
	                           <option value="{$gas_station_list[gs]->getStationId()}">{$gas_station_list[gs]->getStationId()}</option>
	                        {/section}
	                     {/if}
	                     
                     
                    </select>
                   </td>
                  </tr>
                  {/if}
                  
                  <tr>
                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Login yang dipakai<font class="small-font">(*)</font></td>
                  <td>
                    {if !empty($user)}
                  <input type="text" name="user_name" value="{$user->getUsername()}" onfocus="this.blur()" class="disabled"/>
                  {else}
                   <input type="text" name="user_name" value="{$smarty.post.user_name}" />
                  {/if}
                  </td>
				  </tr>
			    {if empty($user)}
				  <tr>
                   <td><img src="images/dot.gif" border="0" height="1" width="10"/>Kata sandi yang dipakai<font class="small-font">(*)</font></td>
                   <td>
                   <input type="password" name="user_password" value="{$smarty.post.user_password}" />
                  </td>
                  </tr>
                  
                  <tr>
				  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Ulangi Kata sandi yang dipakai<font class="small-font">(*)</font></td>
				  <td>
                   <input type="password" name="user_password2" value="{$smarty.post.user_password2}" />
                  </td>
                </tr>
                {/if}
                
                {if !empty($user)}
                  <tr>
                   <td colspan="2" style="text-align:right"><img src="images/dot.gif" border="0" height="1" width="10"/><a href="{$ch_pass_action_url}?user_id={$user->getUserId()}&amp;station_id={$user->getStationId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Ubah kata sandi</a><img src="images/dot.gif" border="0" height="1" width="10"/></td>
                   
                  </tr>
                  {/if}
                <tr>
                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Nama depan<font class="small-font">(*)</font></td>
                  <td>
                  {if !empty($user)}
                  <input type="text" name="first_name" value="{$user->getFirstName()}" />
                  {else}
                   <input type="text" name="first_name" value="{$smarty.post.first_name}" />
                  {/if}
                  </td>
                  </tr>
                  <tr>
				  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Nama belakang</td>
				  <td>
                    {if !empty($user)}
                  <input type="text" name="last_name" value="{$user->getLastName()}" />
                  {else}
                   <input type="text" name="last_name" value="{$smarty.post.last_name}" />
                  {/if}
                  </td>
                </tr>
                <tr>
				  <td><img src="images/dot.gif" border="0" height="1" width="10"/>E-mail<font class="small-font">(*)</font></td>
				  <td>
                    {if !empty($user)}
                  <input type="text" name="email_address" value="{$user->getEmailAddress()}" />
                  {else}
                   <input type="text" name="email_address" value="{$smarty.post.email_address}" />
                  {/if}
                  </td>
                </tr>
                <tr><td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
                <tr>
                 <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/><font class="small-font">(*) wajib diisi</font></td>
                </tr>
                <tr>
                  <td colspan="2" align="right">
                    <input type="submit" name="submit" value="Proses" id="submit"/><img src="images/dot.gif" border="0" height="1" width="10"/></td>
                </tr>
                <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="10" width="1"/></td>
                </tr>
              
            </table>
            
          </td>
        </tr>
      </table>
	  </form>
     {if $smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'PUS'}
          {include file="user_list.tpl"}
      {/if}
    </td>
  </tr>
</table>
{include file="footer.tpl"}
