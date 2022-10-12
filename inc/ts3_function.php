<?

		
		
		$ana_server_name = array( 
			"ts3querynick" => "TeamSpeakDunyasi"
		);
		
		$ana_bayi_baglan = $sql->query("SELECT * FROM servers")->fetch(PDO::FETCH_ASSOC);
		
				
		// Kullanıcının Yönettiği Portu Çek
		$email = $_SESSION['email'];
		$vericeksncu = $sql->prepare("SELECT * FROM yonetsunucu WHERE email=?");
		$vericeksncu->execute(array($email));
		$sonsunucum = $vericeksncu->fetch(PDO::FETCH_ASSOC);
		$id = $sonsunucum['id'];
		$ts3_bayi_ip = $sonsunucum['yonetilecekip'];
		$ts3_bayi_kullanici_port = $sonsunucum['yonetilecekport'];
		
		
		$ts3_bayi_queryport = $ana_bayi_baglan['queryport'];
		$ts3_bayi_password = $ana_bayi_baglan['password'];
		$ts3_bayi_kullanici = $ana_bayi_baglan['username'];
		$ts3_bayi_queryid = $ana_bayi_baglan['imbot'];
		
	
	try{
		$ts3 = TeamSpeak3::factory("serverquery://$ts3_bayi_kullanici:$ts3_bayi_password@$ts3_bayi_ip:$ts3_bayi_queryport/");
		$sid = $ts3->execute("serveridgetbyport", array("virtualserver_port" => $ts3_bayi_kullanici_port))->toList();
		$ts3 = TeamSpeak3::factory("serverquery://$ts3_bayi_kullanici:$ts3_bayi_password@$ts3_bayi_ip:$ts3_bayi_queryport//?server_port=".$ts3_bayi_kullanici_port."&nickname=".$ana_server_name["ts3querynick"]."&use_offline_as_virtual=$sid");
	}
	catch(TeamSpeak3_Exception $e)
	{
		
		$error = 1;
		
	}

?>
