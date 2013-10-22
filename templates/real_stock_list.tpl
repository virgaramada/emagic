{if !empty($real_stock_list)}
<table border="0" cellspacing="0" cellpadding="0">
<tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/><h4>Tabel Real Stock</h4></td></tr>
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
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tgl Berlaku</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Kuantitas</td>
		        <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
        </tr>
        <tr class="title">
               <td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
        </tr>

        {section name=c loop=$real_stock_list}
        <tr>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>
                {if !empty($inv_types)}
			          {section name=d loop=$inv_types}
			            {if $real_stock_list[c]->getInvType() == $inv_types[d]->getInvType()}
			             {$inv_types[d]->getInvDesc()}
			            {/if}
			          {/section}
                {/if}</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/> 
                {$real_stock_list[c]->getStartDate()} - {$real_stock_list[c]->getEndDate()}</td>
           <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$real_stock_list[c]->getQuantity()} Ltr</td>
		   <td><a href="RealStockAction.php?method=edit&amp;real_stock_id={$real_stock_list[c]->getRealStockId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Ubah</a> <img src="images/dot.gif" border="0" height="1" width="1"/> 
		   <a id="real_stock_delete_{$smarty.section.c.index}" href="RealStockAction.php?method=delete&amp;real_stock_id={$real_stock_list[c]->getRealStockId()}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus data?');">Hapus</a></td>
        </tr>
          {/section}
         <tr><td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
         <tr><td colspan="4" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedRealStockList}</td></tr>
         {if ($smarty.session.user_role == 'OWN')}
            <tr><td colspan="4" align="right"><a id="real_stock_delete_all" href="RealStockAction.php?method=deleteAll{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus semua data?');">Hapus Semua</a><img src="images/dot.gif" border="0" height="1" width="10"/></td></tr>
            <tr><td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
         {/if}   
      </table>
	  </td>
		</tr>
		</table>
		{/if}