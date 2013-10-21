{include file="header.tpl"}
<table  border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
  
    <td>
    
    {assign var=ch_pass_action_url value="ChangePasswordAction.php"}

	{if ($smarty.session.user_role eq 'SUP')}
	    {assign var=ch_pass_action_url value="PowerUserPasswordAction.php"}
	{/if}
	{if ($smarty.session.user_role eq 'PUS')}
	    {assign var=ch_pass_action_url value="PowerUserPasswordAction.php"}
	{/if}
	{if ($smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'ADM')}
         {assign var=ch_pass_action_url value="ChangePasswordAction.php"}
	{/if}
     <form name="user_form" method="post" action="{$ch_pass_action_url}{php} echo ("?".strip_tags(SID));{/php}">
      <table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
          
            <table  border="0" cellspacing="0" cellpadding="0" id="inner-table">
           
            <tr><td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td class="title" colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Ubah kata sandi</td>
              </tr>
              <tr><td colspan="2"><img src="images/dot.gif" border="0" height="10" width="1"/></td>
              </tr>
              
              {if !empty($user)}
                <input type="hidden" name="method" value="change"/>
                 <input type="hidden" name="user_id" value="{$user->getUserId()}"/>
                  <input type="hidden" name="user_name" value="{$user->getUserName()}"/>
                  <input type="hidden" name="station_id" value="{$user->getStationId()}"/>
               
               {/if}
				  <tr>
                   <td><img src="images/dot.gif" border="0" height="1" width="10"/>Kata sandi yang lama<font class="small-font">(*)</font></td>
                   <td>
                   <input type="password" name="old_passwd" value="{$smarty.post.old_passwd}" />
                  </td>
                  </tr>
                  
                  <tr>
				  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Kata sandi yang baru<font class="small-font">(*)</font></td>
				  <td>
                   <input type="password" name="new_passwd" value="{$smarty.post.new_passwd}" />
                  </td>
                </tr>
                <!-- TODO add captcha -->
                <tr>
                 <td colspan="2"><font class="small-font">(*) wajib diisi</font></td>
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
    </td>
  </tr>
</table>
{include file="footer.tpl"}
