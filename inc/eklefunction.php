<?php

require_once("sql_base.php");
require_once("class/framework/TeamSpeak3.php");	
require_once("class/framework/ts3admin.class.php");

?>

<?
if ($_GET['operation'] == 'BayiEkleLa') {


	$sunucuip = $_POST['sunucuip'];
	$username = $_POST['username'];
	$yatqapassword = $_POST['yatqapassword'];
	$queryport = $_POST['queryport'];
	$queryid = $_POST['queryid'];


	if (empty($sunucuip)) {
		echo $warning_head2.' Lütfen Sunucu İp Adresini Giriniz.</div>';
	} elseif (empty($username)) {
		echo $warning_head2.' Lütfen Kullanıcı Adı Giriniz</div>';
	} elseif (empty($yatqapassword)) {
		echo $warning_head2.' Yatqa Şifresi Giriniz.</div>';
	} elseif (empty($queryport)) {
		echo $warning_head2.' Query Port Giriniz.</div>';
	} elseif (empty($queryid)) {
		echo $warning_head2.' Admin Server Query ID Giriniz.</div>';
	} else{

		$licensec = $sql->prepare("SELECT * FROM servers WHERE serveradres = ?");
		$licensec->execute(array($sunucuip));

		if($licensec->rowCount() == 0){

				
	
	
	
		$bayiekle = $sql->prepare("INSERT INTO servers SET serveradres=?, username=?, password=?, queryport=?, imbot=?");
		$bayiekledim = $bayiekle->execute(array($sunucuip,$username,$yatqapassword,$queryport,$queryid));
	

			if ($bayiekledim) {
				echo $success_head2.' <i class="la la-check-circle-o"></i> Bayi Başarıyla Eklendi, Sayfa Yenileniyor.</div><meta http-equiv="refresh" content="2">';
			} else{
				echo $warning_head2.' Teknik Bir Problem Oluştu.</div>';
			}
		} else{
			echo $warning_head2.' Bu Bayi Zaten Mevcut.</div>';
		}
	}
}
?>

<?
if ($_GET['operation'] == 'portsunucuekle') {


	$emails = $_POST['email'];
	$port = $_POST['port'];
	$kisisayisi = $_POST['kisisayisi'];
	$sunucusec = $_POST['sunucusec'];


	if (empty($emails)) {
		echo $warning_head2.' Lütfen Email Adresi Giriniz.</div>';
	} elseif (empty($port)) {
		echo $warning_head2.' Lütfen Port Giriniz</div>';
	} elseif (empty($kisisayisi)) {
		echo $warning_head2.' Kişi Sayısı Belirtiniz.</div>';
	} elseif (empty($sunucusec)) {
		if($sunucusec == 0){
			echo $warning_head2.' Lütfen Herhangi Bir Sunucu Seçiniz.</div>';
		}
	} else{

		$licensec = $sql->prepare("SELECT * FROM sunucular WHERE serverip=? AND serverport = ?");
		$licensec->execute(array($sunucusec,$port));

		if($licensec->rowCount() == 0){
	
		$suncekl = $sql->prepare("INSERT INTO sunucular SET email=?,serverip=?, serverport=?, kisisayisi=?");
		$sunucuekle = $suncekl->execute(array($emails,$sunucusec,$port,$kisisayisi));
		
		
		$banadam = $sql->prepare("UPDATE users SET sunucucontrol=? WHERE email=?");
		$pekibanla = $banadam->execute(array("1",$emails));
	
	
				$bayi = $sql->prepare("SELECT * FROM servers WHERE serveradres = ?");
				$bayi->execute(array($sunucusec));
				$bayibilgi = $bayi->fetch(PDO::FETCH_ASSOC);
						
				$ts3_ip = $bayibilgi['serveradres'];
				$ts3_queryport = $bayibilgi['queryport'];
				$ts3_user = $bayibilgi['username'];
				$ts3_pass = $bayibilgi['password'];

				$ts3_sunucu = TeamSpeak3::factory("serverquery://$ts3_user:$ts3_pass@$ts3_ip:$ts3_queryport/");

			if ($sunucuekle) {
				
				$ts3_sunucu->serverCreate(array(
				  "virtualserver_port"         => $port,
				  "virtualserver_maxclients"         => $kisisayisi,
				  "virtualserver_autostart"         => 1,
							
				));
								
				echo $success_head2.' <i class="la la-check-circle-o"></i> Sunucu Başarıyla Eklendi, Sayfa Yenileniyor.</div><meta http-equiv="refresh" content="2">';
			} else{
				echo $warning_head2.' Teknik Bir Problem Oluştu.</div>';
			}
		} else{
			echo $warning_head2.' Bu Port Zaten Mevcut.</div>';
		}
	}
}
?>




