<?
		
		
		set_include_path(get_include_path() . PATH_SEPARATOR . 'inc/phpseclib');
		include('Net/SSH2.php');

	
		
		$srv_errmsg = "
		<div class='serverproblem'>
		<i class='fas fa-exclamation-triangle'></i> Hata Kodu: 1435
		<br><br>
		Server tarafında problem algılandı.
		<br><br>
		Yönetici ile irtibata geçin.
		<br>
		<br>
		<a href='index.php'>Geri Dön</a>
		
		</div>
		

		";
		
	
	
function alertmsg($title,$msg,$backUrl,$type){ $msg = "<script>Swal.fire({
title: '$title',
													text: '$msg',
													allowOutsideClick: false,
													allowEscapeKey: false,											
													type:'$type'
														}).then((result) => {
														  if (result.value) {
															window.location.href = '$backUrl';
														  }
		})</script>"; return print $msg; }
		
		// Kullanıcıya Ait Verileri Çektik.
		$email = $_SESSION['email'];
		$password = $_SESSION['password'];
		$admin_mi = $sql->prepare("SELECT * FROM users WHERE email=? AND password=?");
		$admin_mi->execute(array($email,$password));
		$veri_admin = $admin_mi->fetch(PDO::FETCH_ASSOC);
		$id = $veri_admin['id'];
		$kadi = $veri_admin['kadi'];
		$adsoyad = $veri_admin['adsoyad'];
		$admin_mi = $veri_admin['admin_mi'];
		$uip = $veri_admin['uip'];
		$telno = $veri_admin['telno'];
		$hesapbanned = $veri_admin['hesapban'];
		$profilkonum = $veri_admin['profilkonum'];
		$sunucucontrol = $veri_admin['sunucucontrol'];
		$aktif_mi = $veri_admin['aktif_mi'];
		
		// Kullanıcıya Ait Sunucu Bilgisi
		$email = $_SESSION['email'];
		$sunucuvericek = $sql->prepare("SELECT * FROM sunucular WHERE email=?");
		$sunucuvericek->execute(array($email));
		$verisunucu = $sunucuvericek->fetch(PDO::FETCH_ASSOC);
		$id = $verisunucu['id'];
		$sunucumip = $verisunucu['serverip'];
		$sunucumport = $verisunucu['serverport'];
		
		// Kullanıcıya Ait Sunucu Bilgisi
		$email = $_SESSION['email'];
		$vericeksncu = $sql->prepare("SELECT * FROM yonetsunucu WHERE email=?");
		$vericeksncu->execute(array($email));
		$sonsunucum = $vericeksncu->fetch(PDO::FETCH_ASSOC);
		$id = $sonsunucum['id'];
		$serverip = $sonsunucum['yonetilecekip'];
		$serverport = $sonsunucum['yonetilecekport'];
					
		// Kullanıcı IP Kontrolü
		function GetIP(){
		 if(getenv("HTTP_CLIENT_IP")) {
		 $ip = getenv("HTTP_CLIENT_IP");
		 } elseif(getenv("HTTP_X_FORWARDED_FOR")) {
		 $ip = getenv("HTTP_X_FORWARDED_FOR");
		 if (strstr($ip, ',')) {
		 $tmp = explode (',', $ip);
		 $ip = trim($tmp[0]);
		 }
		 } else {
		 $ip = getenv("REMOTE_ADDR");
		 }
		 return $ip;
		}
		
		function rasgeleharf($uzunluk){
		$karakterler = "1234567890abcdefghijklmnopqrstuvwxyz";
		for($i=0;$i<$uzunluk;$i++){
		$key .= $karakterler{rand(0,35)};
		}
		return $key;
		}



		/*if(GetIP() != $veriadmin['uip']){
		//	header("refresh:0; url=process.php?i=logout");
		}*/


		// Şuanki Zaman
		date_default_timezone_set('Europe/Istanbul');
		$date = date("d.m.Y H:i:s");

	
		// Toplam Kullanıcı Sayısı
		$alluser = $sql->prepare("SELECT COUNT(*) FROM users");
		$alluser->execute();
		$allusers = $alluser->fetchColumn();
		
		// Toplam Sunucu Sayısı
		$allsunucu = $sql->prepare("SELECT COUNT(*) FROM sunucular");
		$allsunucu->execute();
		$allservers = $allsunucu->fetchColumn();
		
		// Toplam Aktif Kullanıcı
		$kalanstok = $sql->prepare("SELECT COUNT(*) FROM users Where aktif_mi=?");
		$kalanstok->execute(array("1"));
		$aktifkullanici = $kalanstok->fetchColumn();


?>
