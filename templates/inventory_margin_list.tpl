{if !empty($inv_margin_list)}
<table border="0" cellspacing="0" cellpadding="0">
  <tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
</table>
<br/>
<table border="0" cellspacing="0" cellpadding="1" id="outer-table">
	<tr>
	<td>
	<div class="tabulation">
				<span class="active-tabForm ">
				Tabel Margin
				</span>
	</div>
	<div class="tabbodycolored">
	<table border="0" cellspacing="0" cellpadding="0" id="inner-table">
            <tr class="title"><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
              <tr class="title">
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Margin</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
        </tr>
<tr class="title"><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>

        {section name=c loop=$inv_margin_list}
        <tr>
          <td><img src="images/dot.gif" border="0" height="1" width="10"/>
          {if !empty($inv_types)}
			          {section name=d loop=$inv_types}
			            {if $inv_margin_list[c]->getInvType() == $inv_types[d]->getInvType()}
			             {$inv_types[d]->getInvDesc()}
			            {/if}
			          {/section}
          {/if}</td>
          <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$inv_margin_list[c]->getMarginValue()}%</td>
		  <td><a href="InventoryMarginAction.php?method=edit&amp;inv_id={$inv_margin_list[c]->getInvId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Ubah</a> <img src="images/dot.gif" border="0" height="1" width="1"/> <a id="inv_margin_delete_{$smarty.section.c.index}" href="InventoryMarginAction.php?method=delete&amp;inv_id={$inv_margin_list[c]->getInvId()}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus data?');">Hapus</a></td>
        </tr>
          {/section}
         <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
         <tr><td colspan="3" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedMarginList}</td></tr>
         {if ($smarty.session.user_role == 'ADM' || $smarty.session.user_role == 'OWN')}
             <tr><td colspan="3" align="right"><a id="inv_margin_delete_all" href="InventoryMarginAction.php?method=deleteAll{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus semua data?');">Hapus Semua</a><img src="images/dot.gif" border="0" height="1" width="10"/></td>
            </tr>
            <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
          {/if}  
      </table>
	  </div>
	  <div class="tabbtmcolored"></div>
	  </td>
		</tr>
		</table>
{/if}