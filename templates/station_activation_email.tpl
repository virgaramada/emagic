Yth Pemilik SPBU,

Permohonan pendaftaran SPBU baru atas nama : 
No. SPBU : {$gas_station->getStationId()} 
Nama pemilik : {$userAccount->getFirstName()} {$userAccount->getLastName()} 
Alamat : {$gas_station->getStationAddress()} 
Email : {$userAccount->getEmailAddress()} 
Wilayah Penyaluran : {$dist_loc->getLocationName()} 

Telah disetujui oleh sistem kami,
Anda dapat menggunakan aplikasi kami dengan login terlebih dahulu di URL : 

http://{$smarty.server.SERVER_NAME}/gismo/LoginAction.php

Silahkan gunakan nama login dan kata sandi yang kami kirimkan melalui email terdahulu

Terima kasih,
Gismo
