<?php
session_start();
ob_start();
include("inc/sql_base.php");
include("inc/functions.php");



		$tscontrol = $sql->prepare("SELECT * FROM sunucular WHERE email = ?");
		$tscontrol->execute(array($email));
		$tscontrolla = $tscontrol->fetch(PDO::FETCH_ASSOC);
		require_once("class/framework/TeamSpeak3.php");	
		require_once("class/framework/ts3admin.class.php");
		
		
		require_once("inc/ts3_function.php");
		
		$geridon = $_SERVER['HTTP_REFERER'];
?>
<html>

<head>
	<? include("pages/head.php");?>
</head>

<body>

<?
	// Oturum Kontrolü
		if($_SESSION['login']!= "OK"){
			alertmsg("Uyarı!","Bu sayfayı görüntüleyebilmek için giriş yapmış olmanız gerekmektedir.","index.php","warning");
			return;
		}


?>

<?
		if($error == 1){
		alertmsg("","Sunucunuza Erişim Sağlanamıyor. Lütfen Yetkiliyle İletişime Geçiniz.","sunucularim.php","warning");
		return;
		}
?>


    <? include("pages/footer.php");?>       

			<? include("pages/header.php"); ?>
		
		
<?
	$x = $_GET['komut'];	
	
	########################################################################################################
	#Kullanıcı Kickleme
	########################################################################################################
	if(isset($_POST['user_kick']))
	{
			$kickname = $_POST['islemadam'];
			
			if($kickname == '0'){
			alertmsg("","Geçersiz Kullanıcı Seçtiniz!","$geridon","warning");
			return;
			}
			
			$kreason = $_POST['kreason'];
			$ts3->clientGetByName($kickname)->kick(TeamSpeak3::KICK_SERVER, "$kreason");
			alertmsg("","$kickname Kullanıcısı Kicklendi.","$geridon","success");
			return;
	}

	if(isset($_POST['user_poke'])){

		$pokename = $_POST['islemadam'];
			
			if($pokename == '0'){
			alertmsg("","Geçersiz Kullanıcı Seçtiniz!","$geridon","warning");
			return;
			}
			
		$kreason = $_POST['kreason'];
		$ts3->clientGetByName($pokename)->poke($kreason);
		
		alertmsg("","$pokename Kullanıcısı Pokelendi.","$geridon","success");
	}
	
	if(isset($_POST['user_ban']))
	{
	
		$banname = $_POST['islemadam'];
			
			if($banname == '0'){
			alertmsg("","Geçersiz Kullanıcı Seçtiniz!","$geridon","warning");
			return;
			}
			
		$kreason = $_POST['kreason'];
		$time = $_POST['time'];
		
		$ts3->clientGetByName($banname)->ban($timeseconds = $time,$kreason = $kreason);
		alertmsg("","$banname Kullanıcısı Pokelendi.","$geridon","success");
	}
	
	
	

?>
		
		
		
		
		
		
<div class="app-main__outer">
	<div class="app-main__inner">

		<div class="row">
			<div class="col-md-6 col-xl-4">
				<div class="card mb-3 widget-content bg-midnight-bloom">
					<div class="widget-content-wrapper text-white">
						<div class="widget-content-left">
							<div class="widget-heading"></div>
						</div>
						<div class="widget-content-right">
							<div class="widget-numbers text-white"><span><a href="ts3server://<?echo $serverip;?>:<?echo $serverport;?>">Sunucuya Bağlan</a></span></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-xl-4">
				<div class="card mb-3 widget-content bg-arielle-smile">
					<div class="widget-content-wrapper text-white">
						<div class="widget-content-left">
							<div class="widget-heading">Sunucu IP</div>
						</div>
						<div class="widget-content-right">
							<div class="widget-numbers text-white"><span><?echo $serverip;?>:<?echo $serverport;?></span></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-xl-4">
				<div class="card mb-3 widget-content bg-grow-early">
					<div class="widget-content-wrapper text-white">
						<div class="widget-content-left">
							<div class="widget-heading">Aktif Kullanıcılar</div>
						</div>
						<div class="widget-content-right">
							<div class="widget-numbers text-white"><span><? echo $ts3->virtualserver_clientsonline . " / " . $ts3->virtualserver_maxclients; ?></span></div>
						</div>
					</div>
				</div>
			</div>
		</div>
						
						<div class="row">
                            <div class="col-md-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-header">Sunucu Durumu : <? echo $ts3->virtualserver_status; ?></div>
									<div class="card-header">Sunucu İsmi : <? echo $ts3->virtualserver_name; ?></div>
									<div class="card-header">Sunucu Uptime : <? echo TeamSpeak3_Helper_Convert::seconds($ts3->virtualserver_uptime); ?></div>
									<div class="card-header">Sunucu Version : <? echo TeamSpeak3_Helper_Convert::version($ts3->virtualserver_version); ?></div>
									<div class="card-header">Sunucu Pingi : <? echo $ts3->virtualserver_total_ping; ?></div>
									<div class="card-header">Paket Kaybı : <? echo $ts3->virtualserver_total_packetloss_total; ?></div>
								</div>
                            </div>
                        </div>

<div class="row">
<div class="col-md-12">
<div class="main-card mb-3 card">
	<div class="card-header">Kullanıcı İşlemleri</div>
	
<div class="table-responsive">
	<table class="align-middle mb-0 table table-borderless table-striped table-hover">
		<tbody>
			<form method="POST" action="kullaniciislem.php" class="form-validation-1">
	
	
				<tr>				
					
					<td>
					
					
					
						<div class="block-area" id="required">
								<div class="clearfix"></div>
								
							<div class="form-group m-b-15">
									<select name="islemadam" class="form-control">
										<option value="0">İşlem Yapılacak Kullanıcıyı Seçin</option>
									<?
									$x_kullanicilistesi = $ts3->clientList(array("client_platform" => ""));
									foreach($x_kullanicilistesi as $ts3_Client)
									{
									echo  "<option value='$ts3_Client' name='$ts3_Client'>".$ts3_Client ."</option>";
									}
									?>
									</select>	
								
								</div> 
								
								<div class="form-group">
								  <label for="exampleInputEmail1">Kullanıcı Kick</label><br>	
								  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Açıklama" name="kreason"><br>
								  <input class="btn btn-success btn-md" type="submit"  name="user_kick"  value="Kickle"/>
								</div>

								<div class="form-group">
								  <label for="exampleInputEmail1">Kullanıcı Poke</label><br>	
								  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Mesaj" name="kreason"><br>
								  <input class="btn btn-success btn-md" type="submit"  name="user_poke"  value="Poke At"/>
								</div>
								<div class="form-group">
								  <label for="exampleInputEmail1">Kullanıcıyı Banla</label><br>	
								  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Sebep" name="kreason"><br>
								  <label for="exampleInputEmail1">Ban Süresi (Saniye)</label><br>	
								  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Ban Süresi" name="time"><br>
								  <input class="btn btn-success btn-md" type="submit"  name="user_ban"  value="Ban At"/>
								</div>

						</div>

					
					</td>
					

					
				</tr>
				
				
				
				
			</form>
		</tbody>
	</table>
</div>

</div>
</div>
</div>
                        
                    </div>
                    <?include("pages/altkisim.php");?>
					
       </div>

<script type="text/javascript" src="assets/scripts/main.js"></script>
</body>
</html>
