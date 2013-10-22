

{if !empty($inv_supply_list)}
<table border="0" cellspacing="0" cellpadding="0">
  <tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/><h4>Tabel Suplai</h4></td></tr>
</table>
<br/>
<table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
	<tr>
	<td>
            <table  border="0" cellspacing="0" cellpadding="0" id="inner-table">
            <tr class="title"><td colspan="7" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
              <tr class="title">
          <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis</td>
          <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tanggal</td>
          {*<td><img src="images/dot.gif" border="0" height="1" width="10"/>NIAP</td>*}
          <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. Polisi</td>
          <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. DO</td>
          <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
		  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>

        </tr>
<tr class="title"><td colspan="7" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>

        {section name=c loop=$inv_supply_list}
        {assign var=total_output value=$inv_supply_list[c]->getSupplyValue()}
        <tr>
          <td><img src="images/dot.gif" border="0" height="1" width="10"/>
           {if !empty($inv_types)}
	          {section name=d loop=$inv_types}
	            {if $inv_supply_list[c]->getInvType() == $inv_types[d]->getInvType()}
	             {$inv_types[d]->getInvDesc()}
	          {/if}
	          {/section}
          {/if}</td>
                <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$inv_supply_list[c]->getSupplyDate()}</td>
               {* <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$inv_supply_list[c]->getNiapNumber()}</td>*}
                <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$inv_supply_list[c]->getPlateNumber()}</td>
                <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$inv_supply_list[c]->getDeliveryOrderNumber()}</td>
                <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$inv_supply_list[c]->getSupplyValue()}
                {if !empty($inv_types)}
	             {section name=d loop=$inv_types}
	               {if $inv_supply_list[c]->getInvType() == $inv_types[d]->getInvType()}
	                 ltr
	               {/if}
	             {/section}
                {/if}</td>
		  <td><a href="InventorySupplyAction.php?method=edit&amp;inv_id={$inv_supply_list[c]->getInvId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Ubah</a> <img src="images/dot.gif" border="0" height="1" width="1"/> <a id="inv_supply_gas_delete_{$smarty.section.c.index}" href="InventorySupplyAction.php?method=delete&amp;inv_id={$inv_supply_list[c]->getInvId()}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus data?');">Hapus</a></td>
        </tr>
           
          {/section}
         <tr><td colspan="7" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
         <tr><td colspan="7" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedGasLinks}</td></tr>
         <tr><td colspan="7" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
      </table>
	  </td>
		</tr>
		</table>
		<table  border="0" cellspacing="0" cellpadding="0" id="inventory-supply">
		<tr>
         <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
       </tr>
       <tr>
         <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
        </tr>
         <tr class="title">
                <td>Total Suplai BBM</td>
                <td align="right"> {php} echo number_format($this->_tpl_vars['total_gas'], 2, ',','.'); {/php} ltr</td>
        </tr>
        <tr>
          <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
        </tr>
      </table>
      {/if}
      <!-- pelumas-->
      
{if !empty($lub_supply_list)}
<table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
	<tr>
	<td>
            <table  border="0" cellspacing="0" cellpadding="0" id="inner-table">
            <tr class="title"><td colspan="7" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
              <tr class="title">
          <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis</td>
          <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tanggal</td>
        {*  <td><img src="images/dot.gif" border="0" height="1" width="10"/>NIAP</td>*}
          <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. Polisi</td>
          <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. DO</td>
          <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
		  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>

        </tr>
<tr class="title"><td colspan="7" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
        {section name=c loop=$lub_supply_list}
        {assign var=total_output value=$lub_supply_list[c]->getSupplyValue()}
        <tr>
          <td><img src="images/dot.gif" border="0" height="1" width="10"/>
           {if !empty($inv_types)}
	          {section name=d loop=$inv_types}
	            {if $lub_supply_list[c]->getInvType() == $inv_types[d]->getInvType()}
	             {$inv_types[d]->getInvDesc()}
	          {/if}
	          {/section}
          {/if}</td>
                <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$lub_supply_list[c]->getSupplyDate()}</td>
               {* <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$lub_supply_list[c]->getNiapNumber()}</td>*}
                <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$lub_supply_list[c]->getPlateNumber()}</td>
                <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$lub_supply_list[c]->getDeliveryOrderNumber()}</td>
                <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$lub_supply_list[c]->getSupplyValue()}
                {if !empty($inv_types)}
	             {section name=d loop=$inv_types}
	               {if $lub_supply_list[c]->getInvType() == $inv_types[d]->getInvType()}
	                  unit
	               {/if}
	             {/section}
                {/if}</td>
		  <td><a href="InventorySupplyAction.php?method=edit&amp;inv_id={$lub_supply_list[c]->getInvId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Ubah</a> <img src="images/dot.gif" border="0" height="1" width="1"/> <a id="inv_supply_lub_delete_{$smarty.section.c.index}" href="InventorySupplyAction.php?method=delete&amp;inv_id={$lub_supply_list[c]->getInvId()}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus data?');">Hapus</a></td>
        </tr>
           
          {/section}
          <tr><td colspan="7" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
          <tr><td colspan="7" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedLubLinks}</td></tr>
          <tr><td colspan="7" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
      </table>
	  </td>
		</tr>
		</table>
		<table  border="0" cellspacing="0" cellpadding="0" id="inventory-supply">
		<tr>
         <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
       </tr>
       <tr>
         <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
        </tr>
        <tr class="title">
            <td>Total Suplai Pelumas</td>
            <td align="right"> {php} echo (int)$this->_tpl_vars['total_lub'] {/php} unit</td>
        </tr>
        <tr>
          <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
        </tr>
      </table>
      {/if}
     {if !empty($inv_supply_list) || !empty($inv_supply_list)}
        {if ($smarty.session.user_role == 'ADM' || $smarty.session.user_role == 'OWN')}
        <table  border="0" cellspacing="0" cellpadding="0" id="inventory-supply">
          <tr>
            <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
          </tr>
          <tr>
            <td colspan="2" align="right"><a id="inv_supply_delete_all" href="InventorySupplyAction.php?method=deleteAll{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus semua data?');">Hapus Semua</a></td>
          </tr>          
        </table>
       {/if}
     {/if}