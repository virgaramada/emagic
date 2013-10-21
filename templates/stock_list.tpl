 <table cellspacing="0" cellpadding="0" id="gas-stock">
            <tr>
              <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
            <!-- last month stock -->
             {if !empty($gas_types)}
              {php} $total_last_month_stock = 0; {/php}
              {if !empty($last_month_stock)}
              <tr>
                <td colspan="2"><i><b>Sisa Stok BBM sebelumnya</b></i> : </td>
              </tr>
              {section name=c loop=$gas_types}
              <tr>
                <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
               <tr>
                <td><b>- Sisa stok {$gas_types[c]->getInvDesc()} sebelumnya</b></td>
                <td align="right" class="amount">
                           {foreach from=$last_month_stock key=k item=v}
                             {if $k == $gas_types[c]->getInvType()}
                              {assign var=gas_last_month_stock value=$v}
                              = {php} echo number_format($this->_tpl_vars['v'], 2, ',','.'); {/php} Liter
                              {php}$total_last_month_stock = bcadd($total_last_month_stock, $this->_tpl_vars['gas_last_month_stock']);{/php}
                             {/if}
                           {/foreach}
                        </td>
                </tr>
              {/section}
              {/if}
             {/if}

               <tr>
               <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
            
          <!-- stock bbm -->
             <tr>
               <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
              </tr>
              <tr class="title">
                <td>Total Sisa Stok BBM sebelumnya </td>
                <td align="right">=  {php} echo number_format($total_last_month_stock, 2, ',','.' ); {/php} Liter</td>
              </tr>
              <tr>
               <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
              </tr>
             <tr>
              <tr>
               <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <!-- supply bbm -->
              {if !empty($gas_types)}

              <tr>
                <td colspan="2"><i><b>Suplai BBM</b></i> : </td>
              </tr>
              <tr>
                <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              {php} $gas_supply = 0;{/php}
              {section name=c loop=$gas_types}
               <tr>
                <td><b>- {$gas_types[c]->getInvDesc()}</b>
                </td>
                <td align="right" class="amount">
                        {if !empty($inv_supply)}
                          {foreach from=$inv_supply key=k item=v}
                          
                             {if $k == $gas_types[c]->getInvType()}
                             = {php} echo number_format($this->_tpl_vars['v'], 2, ',','.'); {/php} Liter
                             {php} $gas_supply = bcadd($gas_supply,$this->_tpl_vars['v']); {/php}
                             {/if}
                          {/foreach}
                        {/if}
                     </td>
              </tr>
              <tr>
                <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              {/section}
             {/if}
             <!-- total supply -->
             <tr>
               <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
             </tr>
             {php} $t_supply = $gas_supply + $total_last_month_stock; {/php}
             <tr class="title">
                <td>Total Suplai BBM {$actual_date}</td>
                <td align="right">= {php} echo number_format($t_supply, 2, ',','.'); {/php} Liter</td>
              </tr>
             <tr>
    <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
  </tr>
              <tr>
                <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>

              <tr>
                <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              
              <!-- stock BBM -->
             {if !empty($gas_types)}
              {php} $total_last_stock = 0; {/php}
              {if !empty($last_stock)}
              <tr>
                <td colspan="2"><i><b>Sisa Stok BBM</b></i> : </td>
              </tr>
              {section name=c loop=$gas_types}
              <tr>
                <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
               <tr>
                <td><b>- Sisa stok {$gas_types[c]->getInvDesc()} {$actual_date}</b></td>
                <td align="right" class="amount">	              
                           {foreach from=$last_stock key=k item=v}        
                             {if $k == $gas_types[c]->getInvType()}
                              {assign var=gas_last_stock value=$v}
                              = {php} echo number_format($this->_tpl_vars['v'], 2, ',','.'); {/php} Liter
                              {php}$total_last_stock = bcadd($total_last_stock, $this->_tpl_vars['gas_last_stock']);{/php}                         
                             {/if}
                           {/foreach}
                        </td>
                </tr>
              {/section}
              {/if}
             {/if}
              
               <tr>
               <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
             
          <!-- total stock bbm -->
             <tr>
               <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
              </tr>
              <tr class="title">
                <td>Total Sisa Stok BBM {$actual_date} </td>
                <td align="right">=  {php} echo number_format($total_last_stock, 2, ',','.' ); {/php} Liter</td>
              </tr>
              <tr>
               <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
              </tr>
             <tr>
              <tr>
               <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
             
               <tr>
               <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              
              <!-- REAL STOCK -->
	
	
	{if !empty($gas_types)} 

	{php} $total_real_stock_value = 0; {/php} 
		{if	!empty($real_stock_list)}
		
		<tr>
			<td colspan="2"><i><b>Real Stok BBM</b></i> :</td>
		</tr>
			{section name=c loop=$gas_types}
			<tr>
				<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
					border="0" /></td>
			</tr>
			<tr>
				<td><b>- Real stok {$gas_types[c]->getInvDesc()} {$actual_date}</b></td>
				<td align="right" class="amount">
				{foreach from=$real_stock_list key=k item=v} 
				 {if $k == $gas_types[c]->getInvType()}
				  {assign var=gas_real_stock_value value=$v}
				  = {php} echo number_format($this->_tpl_vars['v'], 2, ',','.'); {/php} Liter
				  {php} $total_real_stock_value = bcadd($total_real_stock_value, $this->_tpl_vars['gas_real_stock_value']);{/php} 
				 
				 {/if} 
				{/foreach}</td>
			</tr>
			{/section} 
		{/if} 
	{/if}
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>

	<!-- total stock bbm -->
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr class="title">
		<td>Total Real Stok BBM {$actual_date}</td>
		<td align="right">
		= {php} 
		bcscale(2); 
		echo number_format($total_real_stock_value, 2, ',','.' ); 
		{/php} Liter
		</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>


	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	{php} $total_stock_losses = 0; {/php} 
	{php} $total_stock_losses_value = 0; {/php} 
	
	<!-- END REAL STOCK -->
	
              <!-- last month lub stock -->
              
             <!-- stock pelumas -->
             {php} $total_llast_month_stock = 0; {/php}
              {if !empty($last_month_stock) and !empty($lub_types)}
              <tr>
                <td colspan="2"><i><b>Sisa Stok Pelumas sebelumnya</b></i> : </td>
              </tr>
             {section name=c loop=$lub_types}
              <tr>
                <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>

               <tr>
                <td><b>- Sisa stok {$lub_types[c]->getInvDesc()} sebelumnya</b></td>
                <td align="right" class="amount">	              
                           {foreach from=$last_month_stock key=k item=v}        
                             {if $k == $lub_types[c]->getInvType()}
                              {assign var=lub_last_month_stock value=$v}
                              = {php} echo number_format($this->_tpl_vars['v'], 0, ',','.'); {/php} unit
                              {php}$total_llast_month_stock = bcadd($total_llast_month_stock, $this->_tpl_vars['lub_last_month_stock']);{/php}                         
                             {/if}
                           {/foreach}
                        </td>
                </tr>
                
             {/section}
              {/if}
              <tr>
                <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
             <tr>
               <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
              </tr>
              <tr class="title">
                <td>Total Sisa Stok Pelumas sebelumnya </td>
                <td align="right">=  {php} echo number_format($total_llast_month_stock,0, ',','.'); {/php} unit</td>
              </tr>
              <tr>
               <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
              </tr>
             <tr>
               <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <!-- supply pelumas -->
              {if !empty($lub_types)}
              <tr>
                <td colspan="2"><i><b>Suplai Pelumas </b></i>: </td>
              </tr>
              <tr>
                <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              {php} $lub_supply = 0;{/php}
              {section name=d loop=$lub_types}
               <tr>
                <td><b>- {$lub_types[d]->getInvDesc()}</b></td>
                <td align="right" class="amount">
                        {if !empty($inv_supply)}
                          {foreach from=$inv_supply key=a item=b}
                             {if $a == $lub_types[d]->getInvType()}
                             = {php} echo number_format($this->_tpl_vars['b'], 0, ',','.'); {/php} unit
                             {php} $lub_supply = bcadd($lub_supply,$this->_tpl_vars['b']); {/php}
                            {/if}
                          {/foreach}
                        {/if}
                     </td>
              </tr>
              <tr>
                <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              {/section}
             {/if}
            <!-- total supply pelumas -->
            {php} $lb_supply = $lub_supply + $total_llast_month_stock; {/php}
                   
             <tr>
               <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
             </tr>
             <tr class="title">
                <td>Total Suplai Pelumas {$actual_date}</td>
                <td align="right">= {php} echo number_format($lb_supply, 0, ',','.'); {/php} unit</td>
              </tr>
             <tr>
    <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
  </tr>
     <tr>
                <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
          
              <tr>
                <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
             <!-- stock pelumas -->
             {php} $total_llast_stock = 0; {/php}
              {if !empty($last_stock) and !empty($lub_types)}
              <tr>
                <td colspan="2"><i><b>Sisa Stok Pelumas</b></i> : </td>
              </tr>
             {section name=c loop=$lub_types}
              <tr>
                <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>

               <tr>
                <td><b>- Sisa stok {$lub_types[c]->getInvDesc()} {$actual_date}</b></td>
                <td align="right" class="amount">	              
                           {foreach from=$last_stock key=k item=v}        
                             {if $k == $lub_types[c]->getInvType()}
                              {assign var=lub_last_stock value=$v}
                              = {php} echo number_format($this->_tpl_vars['v'], 0, ',','.'); {/php} unit
                              {php}$total_llast_stock = bcadd($total_llast_stock, $this->_tpl_vars['lub_last_stock']);{/php}                         
                             {/if}
                           {/foreach}
                        </td>
                </tr>
             {/section}
              {/if}
              <tr>
                <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
             <tr>
               <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
              </tr>
              <tr class="title">
                <td>Total Sisa Stok Pelumas {$actual_date} </td>
                <td align="right">=  {php} echo number_format($total_llast_stock,0, ',','.'); {/php} unit</td>
              </tr>
              <tr>
               <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
              </tr>
             <tr>
               <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
          </table>