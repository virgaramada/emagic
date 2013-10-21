 {if !empty($inv_customer_list)}
 <table border="0" cellspacing="0" cellpadding="0">
  <tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/><h4>Tabel Tipe Penyaluran</h4></td></tr>
</table>
<br/>
<table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
	<tr>
	<td>
            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
            <tr class="title"><td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
              <tr class="title">
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Kode</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Keterangan</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Kategori</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
        </tr>
        <tr class="title">
                <td id="vertical-spacer" colspan="4"><img src="images/dot.gif" border="0"/></td>
              </tr>

        {section name=c loop=$inv_customer_list}
        <tr>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$inv_customer_list[c]->getCustomerType()}</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$inv_customer_list[c]->getCustomerDesc()}</td>
                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{if $inv_customer_list[c]->getCategory() == 'OWN_USE'} Own Use {/if}
                 {if $inv_customer_list[c]->getCategory() == 'SALES'} Penjualan {/if} {if $inv_customer_list[c]->getCategory() == 'LOSS'} Losses {/if}</td>
		  <td><a href="InventoryCustomerAction.php?method=edit&amp;cust_id={$inv_customer_list[c]->getCustId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Ubah</a> 
   <img src="images/dot.gif" border="0" height="1" width="1"/> 
{if ($smarty.session.user_role == 'SUP' || $smarty.session.user_role == 'PUS')}
   <a id="inv_cust_delete_{$smarty.section.c.index}" href="InventoryCustomerAction.php?method=delete&amp;cust_id={$inv_customer_list[c]->getCustId()}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus data?');">Hapus</a>
{/if}
</td>
        </tr>
          {/section}
           <tr>
                <td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr><td colspan="4" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedCustomerList}</td></tr>
              {if ($smarty.session.user_role == 'SUP' || $smarty.session.user_role == 'PUS')}
              <tr>
                <td colspan="4" align="right"><a id="inv_cust_delete_all" href="InventoryCustomerAction.php?method=deleteAll{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus semua data?');">Hapus Semua</a><img src="images/dot.gif" border="0" height="1" width="10"/></td>
              </tr>
              <tr>
                <td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              {/if}
      </table>
	  </td>
		</tr>
		</table>
		{/if}