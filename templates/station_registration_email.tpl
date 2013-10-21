Yth Admin,

Pada tanggal {$create_date}, ada permintaan pendaftaran SPBU baru atas nama :
No. SPBU : {$gas_station->getStationId()} 
Nama pemilik : {$userAccount->getFirstName()} {$userAccount->getLastName()} 
Alamat : {$gas_station->getStationAddress()} 
Email : {$userAccount->getEmailAddress()} 
Wilayah Penyaluran : {$dist_loc->getLocationName()} 

Silahkan melakukan konfirmasi dan aktifasi atas permintaan tersebut melalui :

http://{$smarty.server.SERVER_NAME}/gismo/StationActivationAction.php?station_id={$gas_station->getStationId()}&user_id={$userAccount->getUserId()}


Terima kasih,
Gismo
