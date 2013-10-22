{include file="header.tpl"}
<table border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
    <td colspan="3" align="center">
	<form name="station_reg_form" method="post" action="StationRegistrationAction.php{php} echo ("?".strip_tags(SID));{/php}">
      <table border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>

          <input type="hidden" name="method" value="create"/>
            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
            <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" class="title"><img src="images/dot.gif" border="0" height="1" width="10"/>Registrasi SPBU</td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
                            
              <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>No SPBU(*)</td>
                <td><input type="text" name="station_id" value="{$smarty.post.station_id}"/></td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Wilayah Penyaluran(*)</td>
                  <td><select name="location_code">
                  {if !empty($dist_locations)}
                     {section name=c loop=$dist_locations}
                     <option value="{$dist_locations[c]->getLocationCode()}" {if $smarty.post.location_code eq $dist_locations[c]->getLocationCode()}selected=selected {/if}>{$dist_locations[c]->getLocationName()}</option>                    
                     {/section}
                  {/if}
                  </select>
                  </td>
                </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Alamat SPBU(*)</td>
                  <td>
                  <textarea rows="1" cols="1" name="station_address">{$smarty.post.station_address}</textarea>
                  </td>
                </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3"><img src="images/dot.gif" border="0" height="1" width="10"/>
                <span style="text-decoration:underline;font-weight:bold;">Data Pemilik</span></td>
              </tr>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Nama depan (*)</td>
                  <td><input type="text" name="first_name" value="{$smarty.post.first_name}"/></td>
                </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Nama belakang</td>
                  <td><input type="text" name="last_name" value="{$smarty.post.last_name}"/></td>
                </tr>
                
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>E-mail</td>
                  <td><input type="text" name="email_address" value="{$smarty.post.email_address}"/></td>
                </tr>
               
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3"><img src="images/dot.gif" border="0" height="1" width="10"/>
                <span style="text-decoration:underline;font-weight:bold;">Data Akses</span></td>
              </tr>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Login (*)</td>
                  <td><input type="text" name="user_name" value="{$smarty.post.user_name}"/></td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Kata sandi (*)</td>
                  <td><input type="password" name="user_password" value="{$smarty.post.user_password}"/></td>
              </tr>
                <tr>
                  <td colspan="3" align="right">
                    <input type="submit" name="submit" value="DAFTAR" id="submit"/><img src="images/dot.gif" border="0" height="1" width="10"/></td>
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
