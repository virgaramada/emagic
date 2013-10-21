{if !empty($real_stock_list)}
<table border="0" cellspacing="0" cellpadding="0">
<tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
</table>
<br/>
<table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
	<tr>
	<td>
		<div class="tabulation">
				<span class="active-tabForm ">
				Tabel Real Stock
				</span>
		</div>
		<div class="tabbodycolored">
            <table  border="0" cellspacing="0" cellpadding="0" id="inner-table">
				<thead>
				<tr class="title">
                <td>Jenis</td>
                <td>Tgl Berlaku</td>
                <td>Kuantitas</td>
		        <td></td>
				</tr>
				</thead>
				<tbody>
				{section name=c loop=$real_stock_list}
				<tr class="{cycle values='bodyTableOdd,bodyTableEven'}">
                <td>
                {if !empty($inv_types)}
			          {section name=d loop=$inv_types}
			            {if $real_stock_list[c]->getInvType() == $inv_types[d]->getInvType()}
			             {$inv_types[d]->getInvDesc()}
			            {/if}
			          {/section}
                {/if}</td>
                <td>{$real_stock_list[c]->getStartDate()} - {$real_stock_list[c]->getEndDate()}</td>
				<td>{$real_stock_list[c]->getQuantity()} Ltr</td>
				<td><a href="RealStockAction.php?method=edit&amp;real_stock_id={$real_stock_list[c]->getRealStockId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Ubah</a> <img src="images/dot.gif" border="0" height="1" width="1"/> 
				<a id="real_stock_delete_{$smarty.section.c.index}" href="RealStockAction.php?method=delete&amp;real_stock_id={$real_stock_list[c]->getRealStockId()}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus data?');">Hapus</a></td>
				</tr>
				{/section}
				<tr><td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
				<tr><td colspan="4" id="horizontal-spacer"><sup>{$paginatedRealStockList}</sup></td></tr>
				{if ($smarty.session.user_role == 'OWN')}
				<tr><td colspan="4" align="right"><a id="real_stock_delete_all" href="RealStockAction.php?method=deleteAll{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus semua data?');">Hapus Semua</a><img src="images/dot.gif" border="0" height="1" width="10"/></td></tr>
				<tr><td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
				{/if}
				</tbody>
			</table>
		</div>
		<div class="tabbtmcolored"></div>
	  </td>
		</tr>
		</table>
		{/if}