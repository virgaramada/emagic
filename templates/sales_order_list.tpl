 {if !empty($sales_order_list)}
 <br/>
 <table border="0" cellspacing="0" cellpadding="0">
  <tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
</table>
<br/>
<table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
	<tr>
	<td>
		<div class="tabulation">
			<span class="active-tabForm ">
				Tabel SO
			</span>
		</div>
			<div class="tabbodycolored">
            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
			  <thead>
              <tr class="title">
                <td>Jenis</td>
                <td>Tgl Penyetoran</td>
                <td>Tgl Order</td>
                <td>Tgl Permintaan Kirim</td>
                <td>Shift</td>
                <td>No. Rek</td>
                 <td>No. SO</td>
                  <td>No. SPBU</td>
                 <td>Jumlah</td>
                 <td>Int. Msg</td>
                 <td>Status</td>
                 <td>Action</td>
             </tr>
			 </thead>
			 <tbody>
    	 {section name=c loop=$sales_order_list}
        
			<tr class="{cycle values='bodyTableOdd,bodyTableEven'}">
                <td>
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
               	 <td>{$sales_order_list[c]->getBankTransferDate()}</td>
               	 <td>{$sales_order_list[c]->getOrderDate()} </td>
                 <td>{$sales_order_list[c]->getDeliveryDate()} </td>
                 <td>
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
                 <td>{$sales_order_list[c]->getBankName()}<br/>{$sales_order_list[c]->getBankAccNumber()}</td>
                 <td>{$sales_order_list[c]->getSalesOrderNumber()}</td>
                 <td>{$sales_order_list[c]->getStationId()}</td>
                 <td>{$sales_order_list[c]->getQuantity()} ltr</td>
                 <td>{$sales_order_list[c]->getOrderMessage()|replace:" ":"<br/>"}</td>
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
		  <td>
    
			<a href="SalesOrderAction.php?method=view&amp;sales_order_id={$sales_order_list[c]->getSalesOrderId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Edit</a> 
   					<img src="images/dot.gif" border="0" height="1" width="1"/>
           
           		  <a href="SalesOrderAction.php?method=delete&amp;sales_order_number={$sales_order_list[c]->getSalesOrderNumber()}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus semua data?');">delete</a> 
   					<img src="images/dot.gif" border="0" height="1" width="1"/>
            </td>
        </tr>
     {/section}
           <tr>
                <td colspan="12" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr><td colspan="12" id="horizontal-spacer"><img src="images/dot.gif" border="0" /><sup>{$paginatedSalesOrderList}</sup></td></tr>
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
		</tbody>
		</table>
	  </div>
	  <div class="tabbtmcolored"></div>
	  </td>
		</tr>
		</table>
{/if}


