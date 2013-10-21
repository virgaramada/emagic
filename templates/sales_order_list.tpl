 {if !empty($sales_order_list)}
 <br/>
 <table border="0" cellspacing="0" cellpadding="0">
  <tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/><h4>Tabel SO</h4></td></tr>
</table>
<br/>
<table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
	<tr>
	<td>
            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
             <tr class="title"><td colspan="12" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
             </tr>
              <tr class="title">
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tgl Penyetoran</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tgl Order</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tgl Permintaan Kirim</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Shift</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. Rek</td>
                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. SO</td>
                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. SPBU</td>
                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>Int. Msg</td>
                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>Status</td>
                 <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
             </tr>
               <tr class="title">
                <td id="vertical-spacer" colspan="12"><img src="images/dot.gif" border="0"/></td>
              </tr>

     {section name=c loop=$sales_order_list}
     
        <tr>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>
                {if !empty($inv_types)}
                      {section name=a loop=$inv_types}
                         {if $inv_types[a]->getInvType() == $sales_order_list[c]->getInvType()} 
                               {$inv_types[a]->getInvDesc()}
                         {/if}
                       {/section}
                {else}
                     {$sales_order_list[c]->getInvType()}
                {/if}
                </td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getBankTransferDate()}</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getOrderDate()} </td>
                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getDeliveryDate()} </td>
                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>
                 {if $sales_order_list[c]->getDeliveryShiftNumber() eq '1'}
                     I
                 {elseif $sales_order_list[c]->getDeliveryShiftNumber() eq '2'}
                     II
                 {elseif $sales_order_list[c]->getDeliveryShiftNumber() eq '3'}
                     III 
                 {elseif $sales_order_list[c]->getDeliveryShiftNumber() eq '4'}
                     IV           
                 {/if}
                  </td>
                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getBankName()}<br/>{$sales_order_list[c]->getBankAccNumber()}</td>
                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getSalesOrderNumber()}</td>
                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getStationId()}</td>
                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getQuantity()} ltr</td>
                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getOrderMessage()|replace:" ":"<br/>"}</td>
		   <td>
											 	    {if ($sales_order_list[c]->getOrderStatus() eq 'REQ')}
											         Sudah Order
											       {/if}
											        {if ($sales_order_list[c]->getOrderStatus() eq 'CFM')}
											         Good Issue						        
											       {/if}
											       {if ($sales_order_list[c]->getOrderStatus() eq 'PLN')}
											         Sedang Proses						        
											       {/if}
												    </td>
		  <td><img src="images/dot.gif" border="0" height="1" width="10"/>
		  {if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN') and $sales_order_list[c]->getOrderStatus() eq 'REQ'}
		  <a href="SalesOrderAction.php?method=view&amp;sales_order_id={$sales_order_list[c]->getSalesOrderId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Edit</a> 
   					<img src="images/dot.gif" border="0" height="1" width="1"/>
		{/if}
			</td>
        </tr>
        <tr>
                <td colspan="12" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="12" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
     {/section}
           <tr>
                <td colspan="12" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr><td colspan="12" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedSalesOrderList}</td></tr>
              {*
              {if ($smarty.session.user_role == 'ADM' || $smarty.session.user_role == 'OWN')}
              <tr>
                <td colspan="12" align="right"><a id="sales_order_delete_all" href="SalesOrderAction.php?method=deleteAll{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus semua data?');">Hapus Semua</a><img src="images/dot.gif" border="0" height="1" width="10"/></td>
              </tr>
              <tr>
                <td colspan="12" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              {/if}
              *}
      </table>
	  </td>
		</tr>
		</table>
{/if}


