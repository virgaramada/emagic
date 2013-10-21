{if !empty($inv_output_list)}

<!-- sales -->
               {if !empty($cust_types)}
                  {section name=y loop=$cust_types}
                          {if $cust_types[y]->getCategory() == 'SALES'}
                           {php} $r = 0;{/php}
                         {section name=c loop=$inv_output_list}
                           {assign var=total_output value=$inv_output_list[c]->getOutputValue()}
                           {if $inv_output_list[c]->getCustomerType() == $cust_types[y]->getCustomerType()}
                           {php} if ((int) $r == 0) { {/php}
                         <table  border="0" cellspacing="0" cellpadding="0">
							 <tr>
							   <td id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
							 </tr>
							  <tr>
							   <td class="title">PENJUALAN</td>
							 </tr>
							<tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
							</tr>
							</table>
                          <table  border="0" cellspacing="0" cellpadding="0">
						<tr>
						   <td>{$cust_types[y]->getCustomerDesc()}</td>
						 </tr>
						<tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
						</table>
                  <table border="0" cellspacing="0" cellpadding="1" id="outer-table">
						<tr>
						<td>
					            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
					            <tr class="title"><td colspan="6" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
					            </tr>
					              <tr class="title">
					                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis</td>
					                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis Kendaraan</td>
					                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tanggal</td>
					                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Harga satuan</td>
					                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
							        <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
					        </tr>
					        <tr class="title"><td colspan="6" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
					            </tr>
					         {php}  } {/php}

								             <tr>
								                <td><img src="images/dot.gif" border="0" height="1" width="10"/>
								                {if !empty($inv_types)}
										          {section name=d loop=$inv_types}
										            {if $inv_output_list[c]->getInvType() == $inv_types[d]->getInvType()}
										             {$inv_types[d]->getInvDesc()}
										          {/if}
										          {/section}
			          							{/if}</td>
			          							<td><img src="images/dot.gif" border="0" height="1" width="10"/>
          							{if $inv_output_list[c]->getVehicleType() == 'MBL'}Mobil{else}Motor{/if}</td>
								                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$inv_output_list[c]->getOutputDate()}</td>
								           <td><img src="images/dot.gif" border="0" height="1" width="10"/>Rp {$inv_output_list[c]->getUnitPrice()}</td>
								           <td>{$inv_output_list[c]->getOutputValue()} {if $smarty.request.productType == 'LUB'}unit{else}ltr{/if}</td>
										   <td><a href="InventoryOutputAction.php?method=edit&amp;inv_id={$inv_output_list[c]->getInvId()}&amp;productType={$smarty.request.productType}{php} echo ("&amp;".strip_tags(SID));{/php}">Ubah</a>
										   <img src="images/dot.gif" border="0" height="1" width="1"/>
										   <a id="inv_output_delete_sales_{$smarty.section.c.index}" href="InventoryOutputAction.php?method=delete&amp;inv_id={$inv_output_list[c]->getInvId()}&amp;productType={$smarty.request.productType}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus data?');">Hapus</a></td>
								        </tr>

                             {php} $r = bcadd($r,$this->_tpl_vars['total_output']); {/php}
                            {/if}
                         {/section}
                         {php} if ((int) $r > 0) { {/php}

						 <tr><td colspan="6" id="vertical-spacer"><img src="images/dot.gif" border="0" /></td>
						</tr>
						  <tr><td colspan="6" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedOutputList}</td></tr>
	         <tr><td colspan="6" id="vertical-spacer"> <img src="images/dot.gif" border="0" /></td></tr>
						      </table>
							  </td>
								</tr>
								</table>
								<table  border="0" cellspacing="0" cellpadding="0" id="inventory-output">
										<tr>
								   <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
								 </tr>
								<tr>
								   <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
								 </tr>
								         <tr class="title">
								               <td>Total {$cust_types[y]->getCustomerDesc()}</td>
								                <td align="right"> {if $smarty.request.productType == 'LUB'}
								                                      
								                                      {if !empty($total_output_by_customer_type)}
            						                                      {foreach from=$total_output_by_customer_type key=k item=v}
            						                                            {if ($k == $cust_types[y]->getCustomerType()) } 
            						                                              {php} echo((int) $this->_tpl_vars['v']){/php}
            						                                            {/if}
            						                                      {/foreach}
						                                              {/if} unit
								                                  {else}
								                                     {php} echo number_format($r, 2, ',','.'); {/php} ltr{/if}</td>
								        </tr>
								 <tr>
								   <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
								 </tr>
                                 <tr><td id="vertical-larger-spacer"><img src="images/dot.gif" border="0" /></td>
												</tr>
								 </table>
								 {php} } {/php}
					{/if}
                {/section}

        {/if}
        
<!-- own use -->
               {if !empty($cust_types)}
                  {section name=y loop=$cust_types}
                          {if $cust_types[y]->getCategory() == 'OWN_USE'}
                          {php} $r = 0;{/php}
                          {section name=c loop=$inv_output_list}
                           {assign var=total_output value=$inv_output_list[c]->getOutputValue()}
                           {if $inv_output_list[c]->getCustomerType() == $cust_types[y]->getCustomerType()}
                           {php} if ((int) $r == 0) { {/php}
                           <table  border="0" cellspacing="0" cellpadding="0">
								 <tr>
								  <td id="vertical-spacer"><img src="images/dot.gif" border="0" /></td>
								 </tr>
								<tr>
								   <td class="title">OWN USE</td>
								 </tr>
								 <tr>
								  <td id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
								</tr>
								</table>
	                          <table  border="0" cellspacing="0" cellpadding="0">
							<tr>
							   <td>{$cust_types[y]->getCustomerDesc()}<td>
							 </tr>
							  <tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
							</tr>
							</table>

					      <table border="0" cellspacing="0" cellpadding="1" id="outer-table">
						   <tr>
						      <td>
					            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
					             <tr class="title">
					              <td colspan="6" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
					            </tr>
					            <tr class="title">
					                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis</td>
					                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis kendaraan</td>
					                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tanggal</td>
					                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Harga satuan</td>
					                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
							        <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
					             </tr>
					       <tr class="title">
					          <td colspan="6" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
					        </tr>
                            {php} } {/php}
					             <tr>
					                <td><img src="images/dot.gif" border="0" height="1" width="10"/>
					                {if !empty($inv_types)}
							          {section name=d loop=$inv_types}
							            {if $inv_output_list[c]->getInvType() == $inv_types[d]->getInvType()}
							             {$inv_types[d]->getInvDesc()}
							          {/if}
							          {/section}
          							{/if}</td>
          							<td><img src="images/dot.gif" border="0" height="1" width="10"/>
          							{if $inv_output_list[c]->getVehicleType() == 'MBL'}Mobil{else}Motor{/if}</td>
					                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$inv_output_list[c]->getOutputDate()}</td>
							           <td><img src="images/dot.gif" border="0" height="1" width="10"/>Rp {$inv_output_list[c]->getUnitPrice()}</td>
							           <td>{$inv_output_list[c]->getOutputValue()} {if $smarty.request.productType == 'LUB'}unit{else}ltr{/if}</td>
									   <td><a href="InventoryOutputAction.php?method=edit&amp;inv_id={$inv_output_list[c]->getInvId()}&amp;productType={$smarty.request.productType}{php} echo ("&amp;".strip_tags(SID));{/php}">Ubah</a>
									   <img src="images/dot.gif" border="0" height="1" width="1"/>
									   <a d="inv_output_delete_own_use_{$smarty.section.c.index}" href="InventoryOutputAction.php?method=delete&amp;inv_id={$inv_output_list[c]->getInvId()}&amp;productType={$smarty.request.productType}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus data?');">Hapus</a></td>
							        </tr>
                            {php} $r = bcadd($r,$this->_tpl_vars['total_output']); {/php}
					       {/if}
                         {/section}

                         {php} if ((int) $r > 0) { {/php}

						 <tr><td colspan="6" id="vertical-larger-spacer"><img src="images/dot.gif" border="0" /></td></tr>
						 </table></td></tr></table>
						<table  border="0" cellspacing="0" cellpadding="0" id="inventory-output">
								<tr>
						   <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
						 </tr>
						<tr>
						   <td colspan="2" id="horizontal-line"><img src="images/dot.gif"/></td>
						 </tr>
						         <tr class="title">
						               <td>Total {$cust_types[y]->getCustomerDesc()}</td>
						                <td align="right">{if $smarty.request.productType == 'LUB'}
						                                      
						                                    {if !empty($total_output_by_customer_type)}
						                                      {foreach from=$total_output_by_customer_type key=k item=v}
						                                            {if ($k == $cust_types[y]->getCustomerType()) } 
						                                              {php} echo((int) $this->_tpl_vars['v']){/php}
						                                            {/if}
						                                      {/foreach}
						                                      {/if} unit
						                                  {else}
						                                     {php} echo number_format($r, 2, ',','.'); {/php} ltr{/if}</td>
						        </tr>
						        <tr>
						        <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
						    </tr>
						    <tr><td id="vertical-larger-spacer"><img src="images/dot.gif" border="0" /></td>
												</tr>
						 </table>
						 {php} } {/php}
					{/if}
                {/section}
        {/if}
        
        <!-- losses -->
        {if !empty($cust_types)}
                  {section name=y loop=$cust_types}
                          {if $cust_types[y]->getCategory() == 'LOSS'}
                           {php} $r = 0;{/php}
                         {section name=c loop=$inv_output_list}
                           {assign var=total_output value=$inv_output_list[c]->getOutputValue()}
                           {if $inv_output_list[c]->getCustomerType() == $cust_types[y]->getCustomerType()}
                           {php} if ((int) $r == 0) { {/php}
                         <table  border="0" cellspacing="0" cellpadding="0">
							 <tr>
							   <td id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
							 </tr>
							  <tr>
							   <td class="title">LOSSES</td>
							 </tr>
							<tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
							</tr>
							</table>
                          <table  border="0" cellspacing="0" cellpadding="0">
						<tr>
						   <td>{$cust_types[y]->getCustomerDesc()}</td>
						 </tr>
						<tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
						</table>
                  <table border="0" cellspacing="0" cellpadding="1" id="outer-table">
						<tr>
						<td>
					            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
					            <tr class="title"><td colspan="6" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
					            </tr>
					              <tr class="title">
					                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis</td>
					                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis Kendaraan</td>
					                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tanggal</td>
					                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Harga satuan</td>
					                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
							        <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
					        </tr>
					        <tr class="title"><td colspan="6" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
					            </tr>
					         {php}  } {/php}

								             <tr>
								                <td><img src="images/dot.gif" border="0" height="1" width="10"/>
								                {if !empty($inv_types)}
										          {section name=d loop=$inv_types}
										            {if $inv_output_list[c]->getInvType() == $inv_types[d]->getInvType()}
										             {$inv_types[d]->getInvDesc()}
										          {/if}
										          {/section}
			          							{/if}</td>
			          							<td><img src="images/dot.gif" border="0" height="1" width="10"/>
          							{if $inv_output_list[c]->getVehicleType() == 'MBL'}Mobil{else}Motor{/if}</td>
								                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$inv_output_list[c]->getOutputDate()}</td>
								           <td><img src="images/dot.gif" border="0" height="1" width="10"/>Rp {$inv_output_list[c]->getUnitPrice()}</td>
								           <td>{$inv_output_list[c]->getOutputValue()} {if $smarty.request.productType == 'LUB'}unit{else}ltr{/if}</td>
										   <td><a href="InventoryOutputAction.php?method=edit&amp;inv_id={$inv_output_list[c]->getInvId()}&amp;productType={$smarty.request.productType}{php} echo ("&amp;".strip_tags(SID));{/php}">Ubah</a>
										   <img src="images/dot.gif" border="0" height="1" width="1"/>
										   <a id="inv_output_delete_loss_{$smarty.section.c.index}" href="InventoryOutputAction.php?method=delete&amp;inv_id={$inv_output_list[c]->getInvId()}&amp;productType={$smarty.request.productType}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus data?');">Hapus</a></td>
								        </tr>

                             {php} $r = bcadd($r,$this->_tpl_vars['total_output']); {/php}
                            {/if}
                         {/section}
                         {php} if ((int) $r > 0) { {/php}

						 <tr><td colspan="6" id="vertical-spacer"><img src="images/dot.gif" border="0" /></td>
						</tr>
						  <tr><td colspan="6" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedOutputList}</td></tr>
	         <tr><td colspan="6" id="vertical-spacer"> <img src="images/dot.gif" border="0" /></td></tr>
						      </table>
							  </td>
								</tr>
								</table>
								<table  border="0" cellspacing="0" cellpadding="0" id="inventory-output">
										<tr>
								   <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
								 </tr>
								<tr>
								   <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
								 </tr>
								         <tr class="title">
								               <td>Total {$cust_types[y]->getCustomerDesc()}</td>
								                <td align="right"> {if $smarty.request.productType == 'LUB'}
								                                      
								                                      {if !empty($total_output_by_customer_type)}
            						                                      {foreach from=$total_output_by_customer_type key=k item=v}
            						                                            {if ($k == $cust_types[y]->getCustomerType()) } 
            						                                              {php} echo((int) $this->_tpl_vars['v']){/php}
            						                                            {/if}
            						                                      {/foreach}
						                                              {/if} unit
								                                  {else}
								                                     {php} echo number_format($r, 2, ',','.'); {/php} ltr{/if}</td>
								        </tr>
								 <tr>
								   <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
								 </tr>

								 </table>
								 {php} } {/php}
					{/if}
                {/section}

        {/if}
	    {if ($smarty.session.user_role == 'ADM' || $smarty.session.user_role == 'OWN')}    
	         <table  border="0" cellspacing="0" cellpadding="0" id="delete-all">
			 <tr>
			   <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0" /></td>
			</tr>
	        <tr>
	         <td colspan="2" align="right"><a id="inv_output_delete_all" href="InventoryOutputAction.php?method=deleteAll&amp;productType={$smarty.request.productType}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus semua data?');">Hapus Semua</a></td>
	       </tr>
		  </table>
	  {/if}
{/if}