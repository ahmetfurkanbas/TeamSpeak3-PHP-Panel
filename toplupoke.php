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

########################################################################################################
	#Kullanıcıları Pokele
	########################################################################################################
	if(isset($_POST['poke_all_users']))
	{

		$a = $_POST['servergrubu'];
		$mesaj = $_POST['pokemesaji'];
		
		try{
			foreach($ts3->serverGroupGetByName($a) as $client)
			{
			$client->poke("$mesaj");
			alertmsg("","$a Grubundaki Tüm Herkese Poke Gönderildi.","$geridon","success");
			return;
			}  
		}
		catch(TeamSpeak3_Exception $e)
		{
		alertmsg("Hata!","Poke Atılamadı.","$geridon","error");
		return;
		}


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
			<form method="POST" action="toplupoke.php?r=<?echo $_GET['r'];?>" class="form-validation-1">
	
	
				<tr>				
					
					<td>
					
					
					
						<div class="block-area" id="required">
								
							<td>
					
													
							<div class="form-group m-b-15">
								<label>Poke Mesajı Girin</label>
								<textarea name="pokemesaji" class="form-control" placeholder="Mesaj"></textarea>
							</div>
							<div class="form-group m-b-15">
			                    <select name="servergrubu" class="form-control">
								<option value="">Pokenin Gönderileceği Sunucu Grubu</option>
								<?
								$servergroups = $ts3->serverGroupList(array("type" => TeamSpeak3::GROUP_DBTYPE_REGULAR));
								foreach($servergroups as $sunucugrubulistesi)
								{
									echo  "<option value='$sunucugrubulistesi' name='$sunucugrubulistesi'>".$sunucugrubulistesi ."</option>";
								}
								?>
								</select>
							</div>

                        
							<input class="btn btn-block btn-alt" type="submit" name="poke_all_users" value="Gonder">
					
					
					
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
