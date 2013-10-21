{include file="header.tpl"}
<table border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
    <td>
	<form name="sales_order_form" method="post" action="SalesOrderAction.php{php} echo ("?".strip_tags(SID));{/php}">
      <table border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
		    <div class="tabulation">
				<span class="active-tabForm ">
				{if !empty($salesOrder)}Ubah{else}Tambah{/if} Sales Order
				</span>
			</div>
			<div class="tabbodycolored">
            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
               
               {if !empty($salesOrder)}
              <input type="hidden" name="method" value="update"/>
              <input type="hidden" name="sales_order_id" value="{$salesOrder->getSalesOrderId()}"/>
              <input type="hidden" name="sales_order_number" value="{$salesOrder->getSalesOrderNumber()}"/>
               {else}
               <input type="hidden" name="method" value="create"/>
               {/if}
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis BBM</td>
                  <td>
                    <select name="inv_type">
                  {if !empty($inv_types)}
                     {section name=c loop=$inv_types}
                     {if !empty($salesOrder)}
                     <option value="{$inv_types[c]->getInvType()}" {if $salesOrder->getInvType() == $inv_types[c]->getInvType()}selected=selected {/if}>{$inv_types[c]->getInvDesc()}</option>
                     {else}
                     <option value="{$inv_types[c]->getInvType()}" {if $smarty.post.inv_type == $inv_types[c]->getInvType()}selected=selected {/if}>{$inv_types[c]->getInvDesc()}</option>
                     {/if}
                     {/section}
                  {/if}
               </select></td>
               </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
                  <td>
                     {if !empty($salesOrder)}
                          <input type="text" name="quantity" value="{$salesOrder->getQuantity()}" style="width:100px" maxlength="10"/>
                      {else}
                       <input type="text" name="quantity" value="" style="width:100px" maxlength="10"/>
                    {/if} Liter
                  </td>
                  </tr>
                   <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                   <tr>
                 <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Tgl Penyetoran</td>
                 <td>{html_select_date end_year='+1' field_order=DMY prefix='Transfer_Date_'} jam {html_select_time use_24_hours=true display_seconds=false display_meridian=false prefix='Transfer_Time_'}</td>
                </tr>
                {if !empty($salesOrder)}
		                <script type="text/javascript">
				         recalculateDateTime('Transfer_Date_', 'Transfer_Time_', document.sales_order_form, '{$salesOrder->getBankTransferDate()}');
				       </script>
					{/if}
                
                 <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                
                 <tr>
                 <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Tgl Permintaan Kirim</td>
                 <td>{html_select_date end_year='+1' field_order=DMY prefix='Delivery_Date_'}</td>
                </tr>
                  {if !empty($salesOrder)}
		                <script type="text/javascript">
				         recalculateDate('Delivery_Date_', document.sales_order_form, '{$salesOrder->getDeliveryDate()}');
				       </script>
					{/if}
                 <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                 <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Shift</td>
                  <td>
                      {if !empty($salesOrder)}
						<input type="text" name="delivery_shift_number" value='{$salesOrder->getDeliveryShiftNumber()}' style="width:40px" maxlength="4" readonly />
                 	 {else}
						<input type="text" name="delivery_shift_number" value='' style="width:40px" maxlength="4" />
                 	 {/if}
				  </td>
				  </tr>
               
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                  <tr>
                    <td><img src="images/dot.gif" border="0" height="1" width="10"/>Bank</td>
                  <td colspan="2">
                    {if !empty($salesOrder)}
                  <input type="text" name="bank_name" value="{$salesOrder->getBankName()}" style="width:150px" maxlength="50" />
                  {else}
                    <input type="text" name="bank_name" value="" style="width:150px" maxlength="50"/>
                  {/if} 
                   &#160;No. Rek&#160;
                  {if !empty($salesOrder)}
                  <input type="text" name="bank_acc_number" value="{$salesOrder->getBankAccNumber()}" style="width:150px" maxlength="50"/>
                  {else}
                    <input type="text" name="bank_acc_number" value="" style="width:150px" maxlength="50"/>
                  {/if}</td>
                </tr>
                 <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>No. Sales Order (SO)</td>
                <td>
                 {if !empty($salesOrder)}
                  <input type="text" name="sales_order_number" value="{$salesOrder->getSalesOrderNumber()}" style="width:150px" maxlength="20" readonly/>
                  {else}
                    <input type="text" name="sales_order_number" value="" style="width:150px" maxlength="20"/>
                  {/if}
               
                  </td>
                </tr>
                 <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Internal message</td>
                <td>
                 {if !empty($salesOrder)}
                 <textarea rows="1" cols="1" name="order_message">{$salesOrder->getOrderMessage()}</textarea>                  
                  {else}
                    <!-- <textarea rows="1" cols="1" name="order_message">{$smarty.post.order_message}</textarea> -->
                  <textarea rows="1" cols="1" name="order_message"></textarea>
                  {/if}
                  </td>
                </tr>
       
                  <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                 <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                <tr>
                  <td colspan="3" id="submit-button" align="right">
                    <input type="submit" name="submit" value="Proses" id="submit" class="button"/><img src="images/dot.gif" border="0" height="1" width="10"/>
                  </td>
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
      {include file="sales_order_list.tpl"}
    </td>
  </tr>
</table>
{include file="footer.tpl"}
