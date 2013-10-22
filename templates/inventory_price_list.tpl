{if !empty($inv_price_list)}
<table border="0" cellspacing="0" cellpadding="0">
<tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/><h4>Tabel Harga Per Unit</h4></td></tr>
</table>
<br/>
<table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
	<tr>
	<td>
            <table  border="0" cellspacing="0" cellpadding="0" id="inner-table">
            <tr class="title"><td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
              <tr class="title">
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Kategori</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Harga satuan</td>
		        <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
        </tr>
        <tr class="title"><td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>

        {section name=c loop=$inv_price_list}
        <tr>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>
                {if !empty($inv_types)}
			          {section name=d loop=$inv_types}
			            {if $inv_price_list[c]->getInvType() == $inv_types[d]->getInvType()}
			             {$inv_types[d]->getInvDesc()}
			          {/if}
			          {/section}
                {/if}</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>
                {if $inv_price_list[c]->getCategory() == 'OWN_USE'} Own Use {/if}
                {if $inv_price_list[c]->getCategory() == 'SALES'} Penjualan {/if} 
                {if $inv_price_list[c]->getCategory() == 'LOSS'} Losses {/if}
                </td>
           <td><img src="images/dot.gif" border="0" height="1" width="10"/>Rp {$inv_price_list[c]->getUnitPrice()}</td>
		   <td><a href="InventoryPriceAction.php?method=edit&amp;inv_id={$inv_price_list[c]->getInvId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Ubah</a> <img src="images/dot.gif" border="0" height="1" width="1"/> <a id="inv_price_delete_{$smarty.section.c.index}" href="InventoryPriceAction.php?method=delete&amp;inv_id={$inv_price_list[c]->getInvId()}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus data?');">Hapus</a></td>
        </tr>
          {/section}
         <tr><td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
         <tr><td colspan="4" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedInvPrice}</td></tr>
         {if ($smarty.session.user_role == 'ADM' || $smarty.session.user_role == 'OWN')}
            <tr><td colspan="4" align="right"><a id="inv_price_delete_all" href="InventoryPriceAction.php?method=deleteAll{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus semua data?');">Hapus Semua</a><img src="images/dot.gif" border="0" height="1" width="10"/></td></tr>
            <tr><td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
         {/if}   
      </table>
	  </td>
		</tr>
		</table>
		{/if}