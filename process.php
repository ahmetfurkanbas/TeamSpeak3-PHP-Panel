<?			
	session_start();
	ob_start();	
	include("inc/sql_base.php");	
	include("inc/functions.php");
	$i = $_GET['i'];
	$usersil = $_GET['usersil'];
	$sunucuyusil = $_GET['sunucuyusil'];
?>


<html>
	<head>
		<? include("pages/head.php");?>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css" />
		
		<style>
		.swal2-popup {
    font-family: Exo, sans-serif;
}

	</style>
	</head>
<body>

	
<?

// giriş yapma
	if(isset($_POST['login'])){


		$geridon = $_SERVER['HTTP_REFERER'];
		$email = htmlspecialchars($_POST['email']);
		$passw = htmlspecialchars(md5($_POST['password']));
		
			$hesapbancontrol = $sql->prepare("SELECT * FROM users Where email=? AND hesapban=?");
			$hesapbancontrol->execute(array($email,"1"));
			$banlandin = $hesapbancontrol->fetch(PDO::FETCH_ASSOC);
			
			if($banlandin){
				alertmsg("Banlandınız!","Lütfen Site Sorumlusuyla İletişime Geçiniz.","index.php","error");
				return;
			}

		$u_check = $sql->prepare("SELECT * FROM users Where email=? AND password=?");
		$u_check->execute(array($email,$passw));
		$datacek = $u_check->fetch(PDO::FETCH_ASSOC);
							
		if($u_check->rowCount() > 0){
							
			$update_ip = $sql->prepare("UPDATE users SET uip=?,songiristarih=?,songirissaat=? WHERE email=?");
			$update_ip->execute(array(GetIP(),$tarih,$saat,$email));
				
								
			$update_active = $sql->prepare("UPDATE users SET aktif_mi=? WHERE email=?");
			$update_active->execute(array("1",$email));
				
				
				
			$_SESSION["login"] = "OK";
			$_SESSION["email"] = "$email";
			$_SESSION["password"] = "$passw";
			
			
			$logtut = $sql->prepare("INSERT INTO logs SET email=?,tarih=?,ipadres=?,islem=?");
			$logtutuluyor = $logtut->execute(array($email,"$tarih - $saat",GetIP(),"Sisteme Giriş Yapıldı"));
										

			alertmsg("Tebrikler!","Giriş yapıldı. Yönlendiriliyorsunuz.","$geridon","success");													  
		}else{
			alertmsg("Hata!","Veritabanımızda girdiğiniz bilgiler ile eşleşen kullanıcı bulunamadı.","$geridon","warning");		
		}
				
	}
?>


<?


	// Kayıt Olma 
	if(isset($_POST['kayitol'])){

		$geridon = $_SERVER['HTTP_REFERER'];
		$kadiekle = $_POST['kadi'];
		$emailekle = $_POST['email'];
		$adsoyadekle = $_POST['adsoyad'];
		$telnoekle = $_POST['telno'];
		$passwordekle = md5($_POST['parola']);
		$passwordekletekrar = md5($_POST['parolatekrar']);
		
		$_SESSION["kayitol"] = "OK";
		$_SESSION["adsoyad"] = "$adsoyadekle";
		$_SESSION["kadi"] = "$kadiekle";
		$_SESSION["email"] = "$emailekle";
		$_SESSION["telno"] = "$telno";
		$_SESSION["parola"] = "$passwordekle";
		$_SESSION["parolatekrar"] = "$passwordekletekrar";

		if($passwordekle != $passwordekletekrar){
          alertmsg("Dikkat!","Lütfen girdiğiniz parolaları kontrol ediniz.","register.php","warning");
		return;
      }

		$email_check = $sql->prepare("SELECT * FROM users Where email=?");
		$email_check->execute(array($emailekle));
		$check_email = $email_check->rowCount();

		if($check_email > 0){
         alertmsg("Dikkat!","Girdiğiniz email adresi zaten sistemden kayıtlı.","index.php","warning");
        return;
		}
		
	$usereklekontrol = $sql->prepare("SELECT * FROM users WHERE kadi = ?");
	$usereklekontrol->execute(array($kadiekle));
	$userkontrol_varmi = $usereklekontrol->rowCount();
	
	if($userkontrol_varmi > 0){
      alertmsg("Dikkat!","$kadiekle İsminde Kullanıcı Zaten Mevcut.","index.php","warning");
      return;
	}
	
	$userekliyom = $sql->prepare("INSERT INTO users SET 
	adsoyad=?,
	kadi=?,
	email=?,
	password=?,
	telno=?,
	profilkonum=?,
	sunucucontrol=?,
	aktif_mi=?,
	admin_mi=?,
	hesapban=?");
	$userekledimbak = $userekliyom->execute(array($adsoyadekle,$kadiekle,$emailekle,$passwordekle,$telnoekle,"photo/profil.png","0","0","0","0"));
	
	if($userekledimbak){
       alertmsg("Tebrikler!","$emailekle Kullanıcısı Oluşturuldu","index.php","success");
		}else{
		exit("$srv_errmsg");
		}
	}

	

?>



<?

// Hesaba Sunucu Ekleme Sistemi
if(isset($_POST['serverekle'])){
	
	$geridon = $_SERVER['HTTP_REFERER'];
	$sunucuip = $_POST['sunucuip'];
	$sunucupassword = $_POST['sunucusifre'];
	
	$server_two = new Net_SSH2($sunucuip);
	$login_server_two = $server_two->login("root",$sunucupassword);
	
	if(!$login_server_two){
		alertmsg("Hata!","Sunucu Bilgilerinizi Kontrol Ediniz Erişim Sağlanamadı!","$geridon","warning");
		return;
	}
	
	$servercontrol = $sql->prepare("SELECT * FROM servers WHERE email=? AND serverip = ?");
	$servercontrol->execute(array($email,$sunucuip));
	$serverlaacontrol = $servercontrol->rowCount();
	
	if($serverlaacontrol > 0){
		alertmsg("Dikkat!","$sunucuip Adresi Hesabınızda Zaten Mevcut.","$geridon","warning");
		return;
	}
	
	$userekliyom = $sql->prepare("INSERT INTO servers SET email=?,serverip=?,serverlogin=?,serverpassword=?,ekletarih=?,ekleyenip=?");
	$userekledimbak = $userekliyom->execute(array($email,$sunucuip,"root",$sunucupassword,"$tarih - $saat",GetIP()));
	
	// Log Sistemi İp Eklendi
	$logtut = $sql->prepare("INSERT INTO logs SET email=?,tarih=?,ipadres=?,islem=?");
	$logtutuluyor = $logtut->execute(array($email,"$tarih - $saat",GetIP(),"$sunucuip Sunucusu Eklendi."));
	
	if($userekledimbak){
		if($logtutuluyor){
		alertmsg("Tebrikler!","$sunucuip İp Adresi Eklendi.","$geridon","success");
		return;
		}
	}
	
}

?>


<?
// Sunucu silme
if($sunucuyusil == 'OK'){
		
		
		$hesapmail = $_SESSION['email'];
		
		$geridon = $_SERVER['HTTP_REFERER'];
		$serverip = $_GET['serverip'];
		$silserversid = $_GET['id'];
		
		
		$sunucuhesapcontrol = $sql->prepare("SELECT * FROM servers WHERE email=? AND serverip = ?");
		$sunucuhesapcontrol->execute(array($hesapmail,$serverip));
		$sunucucontrolet = $sunucuhesapcontrol->rowCount();
		
		if($sunucucontrolet > 0){

			$verisil = $sql->prepare("DELETE FROM servers WHERE id=?");
			$sunucusilla = $verisil->execute(array($silserversid));
			
			// Log Sistemi İp Silme
			$logtut = $sql->prepare("INSERT INTO logs SET email=?,tarih=?,ipadres=?,islem=?");
			$logtutuluyor = $logtut->execute(array($email,"$tarih - $saat",GetIP(),"$serverip Sunucusu Silindi."));
			
			
			
			if($sunucusilla){
				if($logtutuluyor){
				alertmsg("Tebrikler!","$serverip İp Adresli Sunucu Silindi.","$geridon","success");
				return;
				}
			} else {
				alertmsg("Hata!","Silinemedi. Yönlendiriliyorsunuz.","$geridon","warning");
				return;
			}
			
		}else{
				alertmsg("Dikkat!","$serverip Adresi Sizin Hesabınıza Ait Değildir.","sunucularim.php","warning");
				return;
			}
}
?>

<?
// Kullanıcı Şifre Değiştirme
		$email = $_SESSION['email'];
		$u_password = $_SESSION['password'];
		
		
		$veri = $sql->prepare("SELECT * FROM users Where email=? AND password=?");
		$veri->execute(array($email,$u_password));
		$user_info = $veri->fetch(PDO::FETCH_ASSOC);
		
		$email = $user_info['email'];
		$passwd = $user_info['password'];
			
		if(isset($_POST['paswddegis'])){
			
			
			$geridon = $_SERVER['HTTP_REFERER'];
			$eskisifre = md5($_POST['eskiparola']);
			$yenisifre = md5($_POST['yeniparola']);
			$yenisifretekrar = md5($_POST['yeniparolatekrar']);
					
			if($yenisifretekrar != $yenisifre){
				alertmsg("","Girmiş Olduğunuz yeni şifreler eşleşmiyor. Yönlendiriliyorsunuz.","$geridon","warning");
				return;
			}

			if($passwd == $eskisifre){
				
				$update = $sql->prepare("UPDATE users SET password=? WHERE email=? AND password=?");
				$update->execute(array($yenisifre,$email,$eskisifre));
				
				$_SESSION["password"] = "$yenisifre";

				alertmsg("","Şifreniz Başarılı Şekilde Değiştirildi.","$geridon","success");
				return;
				
			}else{
				alertmsg("","Girmiş olduğunuz eski şifre yanlış.","$geridon","warning");
				return;
			}
			
		}
?>

<?
	// Admin Paneli Kullanıcı Ekleme
	if(isset($_POST['usereklemebolum'])){
		
		if($admin_mi != '1'){
				alertmsg("Baya Çakalsın :)","Buraya Sadece Adminler Post Gönderebilir Hadi Köyüne :)","index.php","warning");
				return;
		}

		$geridon = $_SERVER['HTTP_REFERER'];
		$kadiekle = $_POST['kadiekle'];
		$adsoyadekle = $_POST['adsoyadekle'];
		$emailekle = $_POST['emailekle'];
		$telnoekle = $_POST['telnoekle'];
		$passwordekle = md5($_POST['parolaekle']);
		$passwordekletekrar = md5($_POST['parolaekletekrar']);
        $usertip = $_POST['yetkisistem'];
			
			$_SESSION["usereklemebolum"] = "OK";
			$_SESSION["kadiekle"] = "$kadiekle";
			$_SESSION["emailekle"] = "$emailekle";
			$_SESSION["telnoekle"] = "$telnoekle";
			$_SESSION["parolaekle"] = "$passwordekle";
			$_SESSION["parolaekletekrar"] = "$passwordekletekrar";
			$_SESSION["yetkisistem"] = "$usertip";
			
			if($passwordekle != $passwordekletekrar){
				alertmsg("Uyarı!","Girmiş Olduğunuz Şifreler Eşleşmiyor.","$geridon","warning");
				return;
			}

			$mailkontrol = $sql->prepare("SELECT * FROM users WHERE email = ?");
			$mailkontrol->execute(array($emailekle));
			$mailkontrol_varmi = $mailkontrol->rowCount();
			
			if($mailkontrol_varmi > 0){
				alertmsg("Uyarı!","$emailekle İsminde Mail Zaten Mevcut! Yönlendiriliyorsunuz.","$geridon","warning");
				return;
			}
				
			$usereklekontrol = $sql->prepare("SELECT * FROM users WHERE kadi = ?");
			$usereklekontrol->execute(array($kadiekle));
			$userkontrol_varmi = $usereklekontrol->rowCount();
			
			if($userkontrol_varmi > 0){
				alertmsg("Uyarı!","$kadiekle İsminde Kullanıcı Zaten Mevcut!","$geridon","warning");
				return;
			}
			
		if($usertip == '1' || $usertip == '0'){
			
			$userekliyom = $sql->prepare("INSERT INTO users SET adsoyad=?,email=?,kadi=?, password=?,telno=?,admin_mi=?");
			$userekledimbak = $userekliyom->execute(array($adsoyadekle,$emailekle,$kadiekle,$passwordekle,$telnoekle,$usertip));
			
			if($userekledimbak){
				alertmsg("Tebrikler!","$kadiekle İsminde Kullanıcı Oluşturuldu!","$geridon","success");
				return;
			}
			
		}else{
			alertmsg("Dikkat!","Geçersiz Yetki Tipi Seçtiniz.","$geridon","warning");
			return;
		}
	
	}
?>

<?

if(isset($_POST['istatistiksifirla'])){
	
	if($admin_mi != '1'){
				alertmsg("Baya Çakalsın :)","Buraya Sadece Adminler Post Gönderebilir Hadi Köyüne :)","index.php","warning");
				return;
			}
			
	$geridon = $_SERVER['HTTP_REFERER'];
	$istatissifir = $sql->prepare("TRUNCATE istatistik");
	$istatistiklerisifirla = $istatissifir->execute();
	
	if($istatistiklerisifirla){
		alertmsg("Tebrikler!","Bütün İstatistikler Sıfırlandı.","$geridon","success");
		return;
	}else{
		alertmsg("Uyarı!","İstatistikler Sıfırlanamadı.","$geridon","warning");
		return;
	}
	
}


?>

<?
		
		// Kullanıcı silme
		if($usersil == 'OK'){
			
			if($admin_mi != '1'){
				alertmsg("Baya Çakalsın :)","Buraya Sadece Adminler Post Gönderebilir Hadi Köyüne :)","index.php","warning");
				return;
			}
			
			$geridon = $_SERVER['HTTP_REFERER'];
			$silkadi = $_GET['kadi'];
			$silid = $_GET['id'];
			
			
			$verisil = $sql->prepare("DELETE FROM users WHERE id=?");
			$veriidsil = $verisil->execute(array($silid));
			
			if($veriidsil){
				alertmsg("Tebrikler!","$silkadi Kullanıcısı Silindi. Yönlendiriliyorsunuz.","$geridon","success");
				return;
			} else {
				alertmsg("Hata!","Silinemedi. Yönlendiriliyorsunuz.","$geridon","warning");
				return;
			}
		
		
		}
?>



<?

// Çıkış yapma
	if($i == "logout"){

				session_destroy();
				setcookie ("email", "", time() - 3600);
				setcookie ("password", "", time() - 3600);
				
				$update_active = $sql->prepare("UPDATE users SET aktif_mi=? WHERE email=?");
				$update_active->execute(array("0",$email));
				
				alertmsg("Tebrikler!", "Çıkış yapıldı. Yönlendiriliyorsunuz.","index.php","warning");
				return;
		}

?>


</body>
</html>

