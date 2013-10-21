{include file="header.tpl"}
<table border="0" cellspacing="0" cellpadding="0" align="center" id="main-table">
{include file="error_message.tpl"}
<tr>
   <td>
    <form name="login_form" method="post" action="LoginAction.php{php} echo ("?".strip_tags(SID));{/php}">
    <input type="hidden" name="method" value="login"/>
      <table align="center" border="0" cellspacing="0" cellpadding="1" id="login-outer">
        <tr>
          <td><table border="0" cellspacing="1" cellpadding="0" id="login-inner">
              <tr>
                <td colspan="3" id="vertical-larger-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td class="title"><img src="images/dot.gif" border="0" height="1" width="10"/>Nama Login :</td>
                <td colspan="2"><input type="text" name="user_name" value="{$smarty.post.user_name}" /></td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-larger-spacer"><img src="images/dot.gif" border="0"/></td>
              <tr>
                 <td class="title"><img src="images/dot.gif" border="0" height="1" width="10"/>Kata Sandi :</td>
                 <td colspan="3"><input type="password" name="user_password" value="{$smarty.post.user_password}" /></td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-larger-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" align="right"><input type="submit" name="submit" value="masuk" id="submit"/><img src="images/dot.gif" border="0" height="1" width="10"/></td>
              </tr>
              
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              
              <tr>
                <td colspan="3" id="vertical-spacer" style="text-align:center;"><img src="images/dot.gif" border="0"/><a href="StationRegistrationAction.php{php} echo ("?".strip_tags(SID));{/php}">Registrasi SPBU Online</a></td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
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