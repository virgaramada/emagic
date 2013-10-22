{include file="header.tpl"}
<table border="0" cellspacing="0" cellpadding="0" id="main-table">

  <tr>
    
    <td>
	
      <table border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>

          <input type="hidden" name="method" value="create"/>
            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
            <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" style="font-weight:bold;"><img src="images/dot.gif" border="0" height="1" width="10"/>Permohonan pembuatan akun baru</td>
              </tr>
              <tr>
                <td colspan="3" style="font-weight:bold;"><img src="images/dot.gif" border="0" height="1" width="10"/>Berikut adalah data-data SPBU anda</td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>              
              <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>No SPBU(*)</td>
                <td>{$gas_station->getStationId()}</td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Wilayah Penyaluran(*)</td>
                  <td>{$dist_loc->getLocationName()}
                  </td>
                </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Alamat SPBU(*)</td>
                  <td>
                  <textarea rows="1" cols="1" name="station_address" onfocus="this.blur();" class="disabled">{$gas_station->getStationAddress()}</textarea>
                  </td>
                </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3"><img src="images/dot.gif" border="0" height="1" width="10"/>
                <span style="text-decoration:underline;font-weight:bold;">Data Pemilik</span></td>
              </tr>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Nama depan (*)</td>
                  <td>{$userAccount->getFirstName()}</td>
                </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Nama belakang</td>
                  <td>{$userAccount->getLastName()}</td>
                </tr>
               
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>E-mail</td>
                  <td>{$userAccount->getEmailAddress()}</td>
                </tr>
               
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3"><img src="images/dot.gif" border="0" height="1" width="10"/>
                <span style="text-decoration:underline;font-weight:bold;">Data Akses</span></td>
              </tr>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Login (*)</td>
                  <td>{$userAccount->getUsername()}</td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" style="font-weight:bold;font-style:italic;"><img src="images/dot.gif" border="0" height="1" width="10"/>Data anda akan di proses oleh sistem kami, apabila memenuhi syarat, maka sistem kami akan mengirim email konfirmasi aktivasi account</td>
              </tr>
              <tr>
                <td colspan="3" style="font-weight:bold;font-style:italic;"><img src="images/dot.gif" border="0" height="1" width="10"/>Terima kasih telah mendaftar di aplikasi kami</td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
            </table>
                       
          </td>
        </tr>      
      </table>

    </td>
  </tr>
</table>
{include file="footer.tpl"}
