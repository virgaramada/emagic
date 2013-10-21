<table	cellspacing="0" cellpadding="1" id="cash-flow">
<tr>
<td>
<table	cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	
	<!-- last month stock -->
	{if !empty($gas_types)} 
	{php} $total_last_month_stock = 0; {/php}
	{php} $total_last_month_stock_value = 0; {/php}
		 {if !empty($last_month_stock)}
		<tr>
			<td colspan="2"><i><b>Sisa Stok BBM sebelumnya </b></i> :</td>
		</tr>
			{section name=c loop=$gas_types}
			<tr>
				<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
					border="0" /></td>
			</tr>
			<tr>
				<td><b>- Sisa stok {$gas_types[c]->getInvDesc()} sebelumnya</b></td>
				<td align="right" class="amount">
				{foreach from=$last_month_stock key=k item=v} 
					{if $k == $gas_types[c]->getInvType()} 
					{foreach from=$v key=l item=m} 
						{assign	var=gas_last_month_stock value=$m}
						{assign	var=gas_last_month_stock_value value=$l}
						<i>{php} 
						 echo number_format($this->_tpl_vars['l'], 2, ',','.'); 
						{/php} Liter</i>
						 = Rp 
						{php} 
						bcscale(2);
						 echo number_format($this->_tpl_vars['m'], 2, ',','.'); 
						{/php}
						{php} 
						  $total_last_month_stock = bcadd($total_last_month_stock, $this->_tpl_vars['gas_last_month_stock']);
						  $total_last_month_stock_value = bcadd($total_last_month_stock_value, $this->_tpl_vars['gas_last_month_stock_value']);
						{/php} 
					{/foreach}	
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

	<!-- stock bbm -->
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr class="title">
		<td>Total Sisa Stok BBM sebelumnya</td>
		<td align="right">
		<i>{php} 
		  bcscale(2); 
		  echo number_format($total_last_month_stock_value, 2, ',','.' ); 
		{/php} Liter</i> = Rp 
		{php} 
		  bcscale(2); 
		  echo number_format($total_last_month_stock, 2, ',','.' ); 
		{/php}</td>
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
    </table>
    <table cellspacing="0" cellpadding="0">
	<!-- supply bbm -->
	{if !empty($gas_types)} 
	<tr>
		<td colspan="2"><i><b>Pembelian BBM</b></i> :</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	{php} $gas_supply = 0;{/php} 
	{php} $gas_supply_value = 0;{/php} 
	{section name=c loop=$gas_types}

	<tr>
		<td><b>- {$gas_types[c]->getInvDesc()}</b></td>
		<td align="right" class="amount">
		{if !empty($inv_supply)} 
		 {foreach from=$inv_supply key=k item=v} 
		  {if $k == $gas_types[c]->getInvType()} 
		  {foreach from=$v key=a item=b}
		  <i>{php} echo number_format($this->_tpl_vars['a'], 2, ',','.');{/php} Liter</i>
		  = Rp {php} echo number_format($this->_tpl_vars['b'], 2, ',','.');{/php}
		   {php} $gas_supply = bcadd($gas_supply, $this->_tpl_vars['b']);{/php}
		   {php} $gas_supply_value = bcadd($gas_supply_value, $this->_tpl_vars['a']);{/php}
		   {/foreach} 
		  {/if} 
		 {/foreach} 
		{/if}</td>
	</tr>
	{/section} 
	{/if}
	
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<!-- total supply -->
	<tr class="title">
		<td>Total Pembelian BBM {$actual_date}</td>
		<td align="right">
		<i>
		{php} 
		  bcscale(2); 
		  echo number_format(($gas_supply_value + $total_last_month_stock_value), 2, ',','.');
		{/php} Liter</i>
		= Rp 
		{php} 
	  	  bcscale(2);
		  echo number_format(($gas_supply + $total_last_month_stock), 2, ',','.'); 
		{/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	</table>
	<table cellspacing="0" cellpadding="0">
<!-- penjualan BBM -->
	{if !empty($gas_types)}
	{php} $s = 0; {/php} 
	<tr>
		<td colspan="2"><i><b>Penjualan BBM</b></i> :</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	
		{section name=c loop=$gas_types}
		
        
		{php} $o = 0; {/php}
		<tr>
			<td><strong>- Total Penjualan {$gas_types[c]->getInvDesc()}</strong></td>
			<td class="amount">
			{if !empty($total_output_inventory)} 
				{section name=jj loop=$total_output_inventory} 
					{if $total_output_inventory[jj]->getInvType() == $gas_types[c]->getInvType()} 
					  {assign var=o_inv value=$total_output_inventory[jj]->getOutputValue()} 
					  {php} 
					    $o = bcadd($o, $this->_tpl_vars['o_inv']); 
					  {/php} 
					{/if} 
				{/section} 
			{/if}
                        <i>{php} 
					  echo number_format($o, 2, ',','.'); 
					{/php} Liter</i>
			{if	!empty($total_sales_inventory)} 
				{foreach from=$total_sales_inventory key=k item=v} 
					{if $k == $gas_types[c]->getInvType()} = Rp 
						{php} 
						   echo number_format($this->_tpl_vars['v'], 2, ',','.'); 
						{/php} 
					{/if}
				{/foreach} 
			{/if}</td>
		</tr>
			
		<tr>
			<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
				border="0" /></td>
		</tr>
		
		{/section} 
	{/if}
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
  </table>
  <table cellspacing="0" cellpadding="0">
<!-- own-use BBM -->
	{if !empty($gas_types)}

	<tr>
		<td colspan="2"><i><b>BBM 'Own-Use'</b></i> :</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	
		{section name=c loop=$gas_types}
		
		{php} $g_own_use = 0; {/php}
		<tr>
			<td><strong>- Total {$gas_types[c]->getInvDesc()} 'Own-Use' </strong></td>
			<td class="amount">
			{if !empty($total_ownuse_output_inventory)}
			{section name=jj loop=$total_ownuse_output_inventory} 
				{if	$total_ownuse_output_inventory[jj]->getInvType() ==	$gas_types[c]->getInvType()} 
					{assign var=g_ou value=$total_ownuse_output_inventory[jj]->getOutputValue()} 
					{php} $g_own_use = bcadd($g_own_use, $this->_tpl_vars['g_ou']); {/php} 
				{/if} 
			{/section} 
			{/if} 
			{php} 
			   echo number_format($g_own_use, 2, ',','.');
			{/php} Liter 
			{if !empty($total_ownuse_sales_inventory)} 
				{foreach from=$total_ownuse_sales_inventory key=k item=v}
				{if $k == $gas_types[c]->getInvType()} = Rp 
					{php} echo number_format($this->_tpl_vars['v'], 2, ',','.'); {/php} 
				{/if}
				{/foreach} 
			{/if}</td>
		</tr>
		<tr>
			<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
				border="0" /></td>
		</tr>
	
		
		
		{/section} 
	{/if}
	<tr>
			<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
				border="0" /></td>
		</tr>
		</table>

		<table cellspacing="0" cellpadding="0">
	<!-- stock BBM -->
	{if !empty($gas_types)} 
	{php} $total_last_stock = 0; {/php} 
	{php} $total_last_stock_value = 0; {/php} 
		{if	!empty($last_stock)}
		
		<tr>
			<td colspan="2"><i><b>Sisa Stok BBM</b></i> :</td>
		</tr>
			{section name=c loop=$gas_types}
			<tr>
				<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
					border="0" /></td>
			</tr>
			<tr>
				<td><b>- Sisa stok {$gas_types[c]->getInvDesc()} {$actual_date}</b></td>
				<td align="right" class="amount">
				{foreach from=$last_stock key=k	item=v} 
				 {if $k == $gas_types[c]->getInvType()} 
				 {foreach from=$v key=h item=i}
				  {assign var=gas_last_stock value=$i} 
				  {assign var=gas_last_stock_value value=$h}
				  <i>{php} echo number_format($this->_tpl_vars['h'], 2, ',','.'); {/php} Liter</i>
				  = Rp 
				  {php} echo number_format($this->_tpl_vars['i'], 2, ',','.'); {/php}
				  {php} $total_last_stock = bcadd($total_last_stock, $this->_tpl_vars['gas_last_stock']);{/php} 
				  {php} $total_last_stock_value = bcadd($total_last_stock_value, $this->_tpl_vars['gas_last_stock_value']);{/php} 
				  {/foreach}
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
		<td>Total Sisa Stok BBM {$actual_date}</td>
		<td align="right">
		<i>{php} 
		bcscale(2); 
		echo number_format($total_last_stock_value, 2, ',','.' ); 
		{/php} Liter</i>
		= Rp {php} bcscale(2); echo
		number_format($total_last_stock, 2, ',','.' ); {/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>


	<!-- last month lub stock -->
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	</table>
	
	<!-- REAL STOCK -->
	<table cellspacing="0" cellpadding="0">
	
	{if !empty($gas_types)} 
	{php} $total_real_stock = 0; {/php} 
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
				 {foreach from=$v key=h item=i}
				  {assign var=gas_real_stock value=$i} 
				  {assign var=gas_real_stock_value value=$h}
				  <i>{php} echo number_format($this->_tpl_vars['h'], 2, ',','.'); {/php} Liter</i>
				  = Rp 
				  {php} echo number_format($this->_tpl_vars['i'], 2, ',','.'); {/php}
				  {php} $total_real_stock = bcadd($total_real_stock, $this->_tpl_vars['gas_real_stock']);{/php} 
				  {php} $total_real_stock_value = bcadd($total_real_stock_value, $this->_tpl_vars['gas_real_stock_value']);{/php} 
				  {/foreach}
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
		<i>{php} 
		bcscale(2); 
		echo number_format($total_real_stock_value, 2, ',','.' ); 
		{/php} Liter</i>
		= Rp {php} bcscale(2); echo
		number_format($total_real_stock, 2, ',','.' ); {/php}</td>
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
	
	</table>
	<!-- END REAL STOCK -->
	<!-- START BBM LOSSES -->
	{php} $total_stock_losses = 0; {/php} 
	{php} $total_stock_losses_value = 0; {/php} 
	<table cellspacing="0" cellpadding="0">
	
	{if !empty($gas_types)} 
	
		{if	!empty($stock_losses)}
		
		<tr>
			<td colspan="2"><i><b>Kerugian BBM</b></i> :</td>
		</tr>
			{section name=c loop=$gas_types}
			<tr>
				<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
					border="0" /></td>
			</tr>
			<tr>
				<td><b>- Kerugian {$gas_types[c]->getInvDesc()} {$actual_date}</b></td>
				<td align="right" class="amount">
				{foreach from=$stock_losses key=k item=v} 
				 {if $k == $gas_types[c]->getInvType()} 
				 {foreach from=$v key=h item=i}
				  {assign var=gas_stock_losses value=$i} 
				  {assign var=gas_stock_losses_value value=$h}
				  <i>{php} 
				  if (strstr($this->_tpl_vars['h'], '-') ) {
				      echo ("(");
				      echo number_format(substr($this->_tpl_vars['h'], 1), 2, ',','.'); 
				      echo (")");
				  } else {
				      echo number_format($this->_tpl_vars['h'], 2, ',','.'); 
				  }
				  {/php} Liter</i>
				  = Rp 
				  {php} 
				  if (strstr($this->_tpl_vars['i'], '-') ) {
				      echo ("(");
				      echo number_format(substr($this->_tpl_vars['i'], 1), 2, ',','.'); 
				      echo (")");
				  } else {
				     echo number_format($this->_tpl_vars['i'], 2, ',','.'); 
				  }
				  {/php}
				  {php} $total_stock_losses = bcadd($total_stock_losses, $this->_tpl_vars['gas_stock_losses']);{/php} 
				  {php} $total_stock_losses_value = bcadd($total_stock_losses_value, $this->_tpl_vars['gas_stock_losses_value']);{/php} 
				  {/foreach}
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
		<td>Total Kerugian BBM {$actual_date}</td>
		<td align="right">
		<i>{php} 
		bcscale(2); 
		if (strstr($total_stock_losses_value, '-') ) {
		   echo ("(");
		   echo number_format(substr($total_stock_losses_value, 1), 2, ',','.' ); 
		  echo (")");
		} else {
		    echo number_format($total_stock_losses_value, 2, ',','.' );
		}
		{/php} Liter</i>
		= Rp {php} bcscale(2);
		if (strstr($total_stock_losses, '-') ) { 
		    echo ("(");
		    echo number_format(substr($total_stock_losses, 1), 2, ',','.' ); 
		    echo (")");
		} else {
		    echo number_format($total_stock_losses, 2, ',','.' ); 
		}
		{/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>


	<!-- last month lub stock -->
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	</table>
		<!-- END BBM LOSSES -->
	<table cellspacing="0" cellpadding="0">
	<!-- stock pelumas -->
	{php} $total_llast_month_stock = 0; {/php}
	{php} $total_llast_month_stock_value = 0; {/php} 
	{if	!empty($last_month_stock) and !empty($lub_types)}
		<tr>
			<td colspan="2"><i><b>Sisa Stok Pelumas sebelumnya</b></i>:</td>
		</tr>
		{section name=c loop=$lub_types}
		<tr>
			<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
				border="0" /></td>
		</tr>
	
		<tr>
			<td><b>- Sisa stok {$lub_types[c]->getInvDesc()} sebelumnya</b></td>
			<td align="right" class="amount">
			{foreach from=$last_month_stock key=k item=v} 
			 {if $k == $lub_types[c]->getInvType()} 
			 {foreach from=$v key=j item=k} 
			  {assign var=lub_last_month_stock_value value=$j}
			  {assign var=lub_last_month_stock value=$k} 
			  <i>{php} echo number_format($this->_tpl_vars['j'], 0, ',','.'); {/php} Unit </i>
			  = Rp 
			  {php} echo number_format($this->_tpl_vars['k'], 2, ',','.'); {/php}
			  {php} $total_llast_month_stock = bcadd($total_llast_month_stock, $this->_tpl_vars['lub_last_month_stock']);{/php}
			  {php} $total_llast_month_stock_value = bcadd($total_llast_month_stock_value, $this->_tpl_vars['lub_last_month_stock_value']);{/php}
			  {/foreach} 
			 {/if}
			{/foreach}</td>
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
		<td>Total Sisa Stok Pelumas sebelumnya</td>
		<td align="right">
		<i>{php} 
		  bcscale(2); 
		  echo number_format($total_llast_month_stock_value,0, ',','.'); 
		{/php} Unit</i>
		= Rp 
		{php} 
		  bcscale(2); 
		  echo number_format($total_llast_month_stock,2, ',','.'); 
		{/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	</table>
<table cellspacing="0" cellpadding="0">
	<!-- supply pelumas -->
	{if !empty($lub_types)}
		<tr>
			<td colspan="2"><i><b>Pembelian Pelumas</b></i> :</td>
		</tr>
		<tr>
			<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
				border="0" /></td>
		</tr>
		{php} $lub_supply = 0;{/php} 
		{php} $lub_supply_value = 0;{/php} 
			{section name=d loop=$lub_types}
			<tr>
				<td><b>- {$lub_types[d]->getInvDesc()}</b></td>
				<td align="right" class="amount">
				{if !empty($inv_supply)} 
					{foreach from=$inv_supply key=a item=b} 
						{if $a == $lub_types[d]->getInvType()}  
						{foreach from=$b key=j item=k} 
						<i>{php} echo number_format($this->_tpl_vars['j'], 0, ',','.');{/php} Unit</i> = Rp 
							{php} 
							   echo number_format($this->_tpl_vars['k'], 2, ',','.');
							{/php} 
							{php} 
							  $lub_supply = bcadd($lub_supply,$this->_tpl_vars['k']);
							  $lub_supply_value = bcadd($lub_supply_value,$this->_tpl_vars['j']);
							{/php} 
						{/foreach}
						{/if} 
					{/foreach} 
				{/if}</td>
			</tr>
			<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
			{/section} 
	{/if}
	
	<!-- total supply pelumas -->

	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr class="title">
		<td>Total Pembelian Pelumas {$actual_date}</td>
		<td align="right">
		<i>
		{php} 
		   bcscale(2); 
		   echo number_format(($lub_supply_value + $total_llast_month_stock_value), 0, ',','.');
		{/php} Unit</i> 
		= Rp
		{php} 
		   bcscale(2); 
		   echo number_format(($lub_supply + $total_llast_month_stock), 2, ',','.'); 
		{/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	</table>
	<table cellspacing="0" cellpadding="0">
	<!-- penjualan pelumas -->
	{if !empty($lub_types)}
	{php} $l = 0; {/php} 
	
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2"><i><b>Penjualan Pelumas </b></i>:</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	 
		{section name=c loop=$lub_types}
		
		{php} $t = 0; {/php}
		<tr>
			<td><strong>- Total Penjualan {$lub_types[c]->getInvDesc()}</strong></td>
			<td class="amount">
			{if !empty($total_output_inventory)} 
			  {section name=jj loop=$total_output_inventory} 
			   {if $total_output_inventory[jj]->getInvType() == $lub_types[c]->getInvType()} 
			       {assign var=t_inv value=$total_output_inventory[jj]->getOutputValue()} 
			       {php} $t = bcadd($t, $this->_tpl_vars['t_inv']); {/php} 
			   {/if} 
			  {/section} 
			{/if}
                        <i>{php} 
					  echo number_format($t, 0, ',','.'); 
			{/php} Unit</i>
			{if !empty($total_sales_inventory)} 
			 {foreach from=$total_sales_inventory key=k item=v} 
			    {if $k == $lub_types[c]->getInvType()} = Rp 
			      {php} echo number_format($this->_tpl_vars['v'], 2, ',','.'); {/php} 
			    {/if}
			 {/foreach} 
			{/if}</td>
		</tr>
		<tr>
			<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
				border="0" /></td>
		</tr>
		
		{/section} 
	{/if}
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr class="title">
		<td>Total Penjualan (BBM + Pelumas) {$actual_date}</td>
		<td align="right">= Rp 
		{php} 
		  bcscale(2); 
		  $total_sales = bcadd($this->_tpl_vars['total_sales'], 0); 
		  echo number_format($total_sales, 2, ',','.'); 
		{/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	</table>
	<!-- ##### OWN USE  ##### -->
	<table cellspacing="0" cellpadding="0">
	<!-- pelumas on-use -->
	{if !empty($lub_types)}
	 
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2"><i><b>Pelumas 'Own-Use'</b></i> :</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	
		{section name=c loop=$lub_types}
		
		{php} $l_own_use = 0; {/php}
		<tr>
			<td><strong>- Total {$lub_types[c]->getInvDesc()} 'Own-Use' </strong></td>
			<td class="amount">
			{if !empty($total_ownuse_output_inventory)}
				{section name=jj loop=$total_ownuse_output_inventory} 
					{if $total_ownuse_output_inventory[jj]->getInvType() == $lub_types[c]->getInvType()} 
						{assign var=l_ou value=$total_ownuse_output_inventory[jj]->getOutputValue()} 
						{php} $l_own_use = bcadd($l_own_use, $this->_tpl_vars['l_ou']); {/php} 
					{/if}
				{/section} 
			{/if} 
			{php} 
			 echo number_format($l_own_use, 0, ',','.');
			{/php} Unit 
			{if !empty($total_ownuse_sales_inventory)} 
				{foreach from=$total_ownuse_sales_inventory key=k item=v} 
					{if $k == $lub_types[c]->getInvType()} = Rp 
					{php} 
						echo number_format($this->_tpl_vars['v'], 2, ',','.'); 
					{/php} 
			 	    {/if}
			    {/foreach} 
		   {/if}</td>
		</tr>
		<tr>
			<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
				border="0" /></td>
		</tr>
	
		{/section}
	{/if}
	</table>
	<!-- #### LUB LOSS  ##### -->
	{php} $l_losses = 0; {/php}
	{php} $total_lub_stock_losses = 0; {/php} 
	
<table cellspacing="0" cellpadding="0">
	
	<!-- losses pelumas -->
	{if !empty($lub_types)}

	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2"><i><b>Kerugian Pelumas </b></i>:</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
		{section name=c loop=$lub_types}
		
		
		<tr>
			<td><strong>- Total Kerugian {$lub_types[c]->getInvDesc()}</strong></td>
			<td class="amount">
		{if !empty($total_losses_output_inventory)}
			{section name=jj loop=$total_losses_output_inventory} 
			{if	$total_losses_output_inventory[jj]->getInvType() ==	$lub_types[c]->getInvType()} 
			{assign var=l_lo value=$total_losses_output_inventory[jj]->getOutputValue()} 
			{php} $l_losses = bcadd($l_losses, $this->_tpl_vars['l_lo']); {/php} 
			{/if}
			{/section} 
		{/if} 
		{php} echo number_format($l_losses, 0, ',','.'); {/php} Unit 
		{if !empty($total_losses_inventory)} 
			{foreach from=$total_losses_inventory key=k item=v} 
				{if $k == $lub_types[c]->getInvType()} = Rp 
				  {php} echo number_format($this->_tpl_vars['v'], 2, ',','.'); {/php}
				  {php} $total_lub_stock_losses = bcadd($total_stock_losses, $this->_tpl_vars['v']);{/php} 
				   
				{/if}
			{/foreach} 
		{/if}</td>
		</tr>
		<tr>
			<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
				border="0" /></td>
		</tr>
		{/section} 
	{/if}
	<tr>
			<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
				border="0" /></td>
		</tr>
		</table>
	<table cellspacing="0" cellpadding="0">	
	<!-- stock pelumas -->
	{php} $total_llast_stock = 0; {/php} 
	{php} $total_llast_stock_value = 0; {/php} 
	{if !empty($last_stock) and !empty($lub_types)}
	<tr>
		<td colspan="2"><i><b>Sisa Stok Pelumas</b></i> :</td>
	</tr>
		{section name=c loop=$lub_types}
		
		<tr>
			<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
				border="0" /></td>
		</tr>
	
		<tr>
			<td><b>- Sisa stok {$lub_types[c]->getInvDesc()} {$actual_date}</b></td>
			<td align="right" class="amount">
			{foreach from=$last_stock key=k	item=v}
				{if $k == $lub_types[c]->getInvType()}
				{foreach from=$v key=h item=i} 
					{assign	var=lub_last_stock value=$i} 
					{assign	var=lub_last_stock_value value=$h} 
					<i>{php} 
					  echo number_format($this->_tpl_vars['h'], 0, ',','.'); 
					{/php} Unit</i>
					= Rp 
					{php} 
					  echo number_format($this->_tpl_vars['i'], 2, ',','.'); 
					{/php}
					{php}
					  $total_llast_stock = bcadd($total_llast_stock, $this->_tpl_vars['lub_last_stock']);
					  $total_llast_stock_value = bcadd($total_llast_stock_value, $this->_tpl_vars['lub_last_stock_value']);
					{/php} 
				{/foreach}	
				{/if} 
			{/foreach}</td>
		</tr>
		
		{/section} 
	{/if}
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	
	<tr class="title">
		<td>Total Sisa Stok Pelumas {$actual_date}</td>
		<td align="right">
		<i>{php} 
		  echo number_format($total_llast_stock_value,0, ',','.'); 
		{/php} Unit </i>
		= Rp 
		{php} 
		  bcscale(2); 
		  echo number_format($total_llast_stock,2, ',','.'); 
		{/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	</table>
	<table cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr class="title">
		<td>Total 'OWN-USE' (Pelumas + BBM) {$actual_date}</td>
		<td align="right">= Rp 
		{php} 
		  echo number_format($this->_tpl_vars['total_ownuse_sales'], 2, ',','.');
		{/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	{php} $total_losses = bcadd($total_stock_losses, $total_lub_stock_losses);{/php}
	<tr class="title">
		<td>Total Kerugian (Pelumas + BBM) {$actual_date}</td>
		<td align="right">= Rp {php} 
		if (strstr($total_losses, '-') ) {
		    echo ("(");
		    echo number_format(substr($total_losses, 1), 2, ',','.');
		    echo (")");
		} else {
		    echo number_format($total_losses, 2, ',','.');
		} 
		{/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	</table>
	<table cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<!-- PROFIT BBM -->
	{php} $gas_value = array(); {/php} 
	{if !empty($gas_types)}
	<tr>
		<td colspan="2"><i><b>Keuntungan BBM</b></i> :</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
		{section name=c loop=$gas_types}
		<tr>
			<td><b>- {$gas_types[c]->getInvDesc()}</b> 
			{if !empty($total_margin_inventory)} 
			 {foreach from=$total_margin_inventory key=k item=v} 
			   {if $k == $gas_types[c]->getInvType()} 
			    <i>margin = {$v->getMarginValue()}%</i>
			   {/if} 
			 {/foreach} 
			{/if}</td>
			<td align="right" class="small-font">
			{if	!empty($total_sales_inventory)} 
				{foreach from=$total_sales_inventory key=k item=v} 
					{if $k == $gas_types[c]->getInvType()} 
						{if !empty($total_margin_inventory)} 
							{foreach from=$total_margin_inventory key=ky item=val} 
								{if $ky == $k} 
									<i>({$val->getMarginValue()}% x Rp {php} echo number_format($this->_tpl_vars['v'], 2, ',','.'); {/php})</i>
									{assign var=gas_margin_value value=$val->getMarginValue()} = Rp 
									{php}
									    bcscale(2); $gas_profit = bcmul($this->_tpl_vars['v'],$this->_tpl_vars['gas_margin_value']);
									    echo number_format(($gas_profit * 0.01), 2, ',','.'); 
									    $gas_value = array_merge($gas_value, array($gas_profit)); 
									{/php} 
								{/if} 
							{/foreach}
						{/if} 
					{/if} 
				{/foreach} 
			{/if}</td>
		</tr>
		{/section} 
	{/if}
	<!-- profit Pelumas -->
	{php} $lub_value = array(); {/php} 
	{if !empty($lub_types)}
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2"><i><b>Keuntungan Pelumas </b></i>:</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
		{section name=c loop=$lub_types}
		<tr>
			<td><b>- {$lub_types[c]->getInvDesc()}</b>
			{if !empty($total_margin_inventory)} 
				{foreach from=$total_margin_inventory key=ky item=val} 
					{if $ky == $lub_types[c]->getInvType()} 
					  <i>margin = {$val->getMarginValue()}%</i>
					{/if} 
				{/foreach} 
			{/if}</td>
			<td align="right" class="small-font">
			{if	!empty($total_sales_inventory)} 
				{foreach from=$total_sales_inventory key=k item=v} 
					{if $k == $lub_types[c]->getInvType()} 
						{if !empty($total_margin_inventory)} 
							{foreach from=$total_margin_inventory key=ky item=val} 
								{if $ky == $k} <i>({$val->getMarginValue()}% x Rp
									{php} echo number_format($this->_tpl_vars['v'], 2, ',','.'); {/php})</i>
									{assign var=lub_margin_value value=$val->getMarginValue()} = Rp 
									{php}
										 bcscale(2); 
										 $lub_profit = bcmul($this->_tpl_vars['v'],($this->_tpl_vars['lub_margin_value']));
										 $lub_value = array_merge($lub_value, array($lub_profit)); 
										 echo number_format(($lub_profit * 0.01), 2, ',','.'); 
									{/php} 
								 {/if}
							{/foreach} 
						{/if} 
					{/if} 
				{/foreach} 
			{/if}</td>
		</tr>
		{/section} 
	{/if}
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	</table>
	<table cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr class="title">
		<td>Margin Profit {$actual_date}</td>
		<td align="right">= Rp 
		{php} 
			bcscale(2); 
			$profit_array =	array_merge($lub_value, $gas_value); 
			$total_profit = 0;
			foreach($profit_array as $key => $value) {
				    $total_profit = bcadd($total_profit,$value); 
			} 
			$margin_profit = ($total_profit * 0.01); 
			echo number_format($margin_profit, 2, ',','.'); 
		{/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<!-- overhead cost -->
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	
	<tr class="title">
		<td>Total Biaya Overhead {$actual_date}</td>
		<td align="right">= Rp 
		{php} 
		  echo number_format($this->_tpl_vars['total_overhead_cost'], 2,',','.');
		{/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>

<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	{php} $total_all_stock= $total_llast_stock + $total_last_stock; {/php} 
	<tr class="title">
		<td>Total Aset Inventory {$actual_date}</td>
		<td align="right">Rp 
		{php} 
		  bcscale(2); 
		  echo number_format($total_all_stock,2, ',','.'); 
		{/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
<!-- net profit -->
{php} $net_profit = 0; {/php} 
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr class="title">
		<td>Net Profit {$actual_date}</td>
		<td align="right">= Rp 
		{php} 
			bcscale(2); 
			$net_profit = bcsub($margin_profit, bcadd($this->_tpl_vars['total_ownuse_sales'], $total_losses)); 
			$net_profit = bcsub($net_profit, $this->_tpl_vars['total_overhead_cost']); 
			echo number_format($net_profit, 2, ',','.'); 
		{/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>

	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
{php} $total_asset = $total_all_stock + $net_profit; {/php} 
       <tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>

	<tr class="title">
		<td>Cash Flow {$actual_date}</td>
		<td align="right">Rp 
		{php} 
		  bcscale(2); 
		  echo number_format($total_asset,2, ',','.'); 
		{/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	{if !empty($work_in_capital)} 
	<tr class="title">
		<td>Saldo Kas {$actual_date}</td>
		<td align="right">Rp 
		{php} 
		  bcscale(2); 
                  $last_wic = bcadd($this->_tpl_vars['work_in_capital']->getValue(), $net_profit); 
                  
                  $cash_in_hand = $last_wic - $total_all_stock;
		  echo number_format($cash_in_hand,2, ',','.'); 
		{/php}</td>
	</tr>
	{/if}
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
       

	{if !empty($work_in_capital)} 
		{assign var=wic_value value=$work_in_capital->getValue()}
		<tr>
			<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
		</tr>
		<tr class="title">
			<td>Modal Kerja Awal</td>
			<td align="right">= Rp 
			{php}
				bcscale(2); 
				echo number_format($this->_tpl_vars['wic_value'], 2, ',','.'); 
			{/php}</td>
		</tr>
		<tr>
			<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
		</tr>
	{/if}

	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr class="title">
		<td>Modal Kerja Akhir {$actual_date}</td>
		<td align="right">= Rp 
		{php} 
			bcscale(2); 
			$last_wic =	bcadd($this->_tpl_vars['wic_value'], $net_profit);  
			echo number_format($last_wic, 2, ',','.'); 
		{/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>

</table>
</td>
</tr>
</table>
