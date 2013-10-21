{include file="header.tpl"}
<table border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
    <td>
	
      <table border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>

			<div class="tabulation">
				<span class="active-tabForm ">
				Dashboard
				</span>
			</div>
			<div class="tabbodycolored">
			<table  border="0" cellspacing="0" cellpadding="0" id="inner-table">
				<tr>
					<td>
						<div align="center"><b>Tangki Bensin</b></div>
						{$dashboard_tank_1}
					</td>
					<td>
						<div align="center"><b>Tangki Solar</b></div>
						{$dashboard_tank_2}
					</td>
                </tr>
			</table>
			</div>
			
			<div class="tabbtmcolored"></div>
				</td>
            </tr>
		</table>
		</td>
    </tr>
</table>
{include file="footer.tpl"}