{include file="header.tpl"}
<table border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
   
    <td>
	<form name="inventory_margin_form" method="post" action="TankCapacityAction.php{php} echo ("?".strip_tags(SID));{/php}">
      <table border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
			<div class="tabulation">
				<span class="active-tabForm ">
				{if !empty($tankCapacity)} Ubah {else} Tambah {/if} Kp Tanki
				</span>
			</div>
			<div class="tabbodycolored">
          
            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
            
              {if !empty($tankCapacity)}
              <input type="hidden" name="method" value="update"/>
              <input type="hidden" name="inv_id" value="{$tankCapacity->getId()}"/>
               {else}
               <input type="hidden" name="method" value="create"/>
               {/if}
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>No SPBU</td>
                  <td>
                  {if !empty($tankCapacity)}
                  <input type="text" name="station_id" value="{$tankCapacity->getStationId()}" onfocus="this.blur();" class="disabled"/>
                  {else}
                     {if !empty($gas_station)}
                    <input type="text" name="station_id" value="{$gas_station->getStationId()}" onfocus="this.blur();" class="disabled"/>
                    {else}
                    <input type="text" name="station_id" value="{if ($smarty.session.user_role != 'SUP' && $smarty.session.user_role != 'PUS')} {$smarty.session.station_id}{/if}" onfocus="{if ($smarty.session.user_role != 'SUP' && $smarty.session.user_role != 'PUS')}this.blur();{/if}"/>
                     {/if}
                  {/if}</td>
                </tr>
                
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis Bahan Bakar</td>
                  <td><select name="inventory_type">
                 {if !empty($inv_types)}
                     {section name=c loop=$inv_types}
                     {if !empty($tankCapacity)}
                     <option value="{$inv_types[c]->getInvType()}" {if $tankCapacity->getInvType() == $inv_types[c]->getInvType()}selected=selected {/if}>{$inv_types[c]->getInvDesc()}</option>
                     {else}
                     <option value="{$inv_types[c]->getInvType()}" {if $smarty.post.inventory_type == $inv_types[c]->getInvType()}selected=selected {/if}>{$inv_types[c]->getInvDesc()}</option>
                     {/if}
                     {/section}
                  {/if}
                  </select></td>
                </tr>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Kp. Tanki</td>
                  <td>
                  {if !empty($tankCapacity)}
                  <input type="text" name="tank_capacity" value="{$tankCapacity->getTankCapacity()}"/>
                  {else}
                    <input type="text" name="tank_capacity" value="{$smarty.post.tank_capacity}"/>
                  {/if} Liter</td>
                </tr>
                <tr>
                  <td colspan="3" align="right">
                    <input type="submit" name="submit" value="Proses" id="submit"/><img src="images/dot.gif" border="0" height="1" width="10"/></td>
                </tr>
                 <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
             
            </table>
			</div>
            <div class="tabbtmcolored"></div>
          </td>
        </tr>
      </table>
	  </form>
      {include file="tank_capacity_list.tpl"}
    </td>
  </tr>
</table>
{include file="footer.tpl"}
