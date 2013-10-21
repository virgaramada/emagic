{include file="header.tpl"}
<table border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
   
    <td>
{if !empty($sales_order_list)}
     <table border="0" cellspacing="0" cellpadding="0">
		  <tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/><h4>Tabel SO</h4></td></tr>
		  
	</table>
	

<br/>
<table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
	<tr>
	<td>
            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
             <tr class="title"><td colspan="11" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
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
                 
             </tr>
               <tr class="title">
                <td id="vertical-spacer" colspan="11"><img src="images/dot.gif" border="0"/></td>
              </tr>
 
     {section name=c loop=$sales_order_list}
        <tr>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>
                {if !empty($inv_types)}
                      {section name=a loop=$inv_types}
                         {if $inv_types[a]->getInvType() eq $sales_order_list[c]->getInvType()} 
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
                 {/if} </td>
                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getBankName()}<br/>{$sales_order_list[c]->getBankAccNumber()}</td>
                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getSalesOrderNumber()}</td>
                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getStationId()}</td>
                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getQuantity()} ltr</td>
                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getOrderMessage()|replace:" ":"<br/>"}</td>
                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>
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
		  
        </tr>
        <tr>
                <td colspan="11" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="11" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
     {/section}
     
              <tr>
                <td colspan="11" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr><td colspan="11" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedSalesOrderList}</td></tr>
              <tr>
                <td colspan="11" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr><td colspan="11" align="right"><img src="images/dot.gif" border="0" height="1" width="10"/><a href="StationMonitorAction.php{php} echo ("?".strip_tags(SID));{/php}">Kembali</a><img src="images/dot.gif" border="0" height="1" width="10"/></td></tr>
              <tr>
                <td colspan="11" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
      </table>
	  </td>
	   
		</tr>
		</table>
    {/if}
    </td>
   
  </tr>
  
</table>
<table border="0" cellspacing="0" cellpadding="0">
 {if empty($sales_order_list)}
		  <tr><td class="error-message"><img src="images/dot.gif" border="0" height="10" width="1"/>Belum ada SPBU yang memiliki SO</td></tr>
		  {/if}
</table>
{include file="footer.tpl"}
