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


	$x = $_GET['r'];
	########################################################################################################
	#Sunucuyu Başlatma
	########################################################################################################
	if(isset($_POST['server_start']))
	{
	$port = $serverport;
	$id=$ts3->serverIdGetByPort($port);
	$ts3->serverStart($id);
	alertmsg("Başarılı","Sunucunuz Başlatıldı.","$geridon","success");
	return;
	
	}
	
	########################################################################################################
	#Sunucuyu Durdurma
	########################################################################################################
	if(isset($_POST['server_stop']))
	{
	$ts3->stop();
	alertmsg("Başarılı","Sunucunuz Durduruldu.","$geridon","success");
	return;
	}
	

if($_POST['guncelle']){

	$name = $_POST['nameofserver'];
	$welcomemessage = $_POST['welcomemessage'];
	$slots = $_POST['slotsofserver'];
	$reservedslots = $_POST['reservedslots'];
	$securitylevel = $_POST['securitylevel'];
	$gfximgurl = $_POST['gfximgurl'];
	$gfxurl = $_POST['gfxurl'];
	$hostmessage = $_POST['hostmessage'];
	$hostmode = $_POST['hostmode'];
	$hbutaractip = $_POST['hbutaractip'];
	$hbbutonurl = $_POST['hbbutonurl'];
	$hbikonurl = $_POST['hbikonurl'];

$edit = array("virtualserver_welcomemessage=$welcomemessage","virtualserver_name=$name",
"virtualserver_hostbanner_gfx_url=$gfximgurl",
"virtualserver_hostbanner_url=$gfxurl",
"virtualserver_hostmessage=$hostmessage",
"virtualserver_hostmessage_mode=$hostmode"); 
$ts3->modify($edit);

alertmsg("Başarılı","Sunucu Bilgileriniz Değiştirildi.","$geridon","success");

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
	<div class="card-header">Sunucu Ayarları</div>
	
<div class="table-responsive">
	<table class="align-middle mb-0 table table-borderless table-striped table-hover">
	<tbody>
			<form method="POST" action="sunucuayarlari.php?r=<?echo$_GET['r'];?>"class="form-validation-1">
				<tr>
					<td>
						<div class="widget-content p-0">
							<div class="widget-content-wrapper">
								<div class="widget-content-left mr-3">
									<div class="widget-content-left">
										<input type="submit" name="server_start" class="mb-2 mr-2 btn btn-secondary" value="Sunucuyu Başlat">
										<input type="submit" name="server_stop" class="mb-2 mr-2 btn btn-secondary" value="Sunucuyu Durdur">
									</div>
								</div>
									<div class="widget-content-left flex2">
										<div class="widget-heading">
																								
										</div>
									</div>
							</div>
						</div>
					</td>
				</tr>
			</form>
												
												
			<tr>
			<td>
			<div class="widget-content p-0">
				<div class="widget-content-wrapper">
					<div class="widget-content-left mr-3">
						<div class="widget-content-left">
							<form method="post" action="sunucuayarlari.php">
								<div class="form-group">
								  <label for="exampleInputEmail1">Sunucu Adı</label>
								  <input type="text" class="form-control" name="nameofserver" value="<?php echo $ts3->virtualserver_name; ?>">
								</div>

								<div class="form-group">
								  <label for="exampleInputEmail1">Sunucu İp</label>
								  <input type="text" class="form-control" name="ayar_port" value="<?echo $serverip;?>:<?echo $serverport;?>" disabled>
								</div>
								<div class="form-group">
								  <label for="exampleInputEmail1">Kişi Kapasitesi</label>
								  <input type="number" class="form-control" name="slotsofserver" value="<?php echo $ts3->virtualserver_maxclients; ?>"  disabled>
								</div>

								<div class="form-group">
								  <label for="exampleInputEmail1">Server Chat Mesajı</label>
								  <textarea rows="3" cols="30" class="form-control" name="welcomemessage"><?php echo $ts3->virtualserver_welcomemessage; ?></textarea>
								</div>

								<div class="form-group">
								  <label for="exampleInputEmail1">Server Karşılama Mesajı</label>
								  <textarea rows="3" cols="30" class="form-control" name="hostmessage"><?php echo $ts3->virtualserver_hostmessage; ?></textarea>
								</div>
								
								<div class="form-group">
								  <label for="exampleInputEmail1">Resim URL</label>
								  <textarea rows="1" cols="30" class="form-control" name="gfximgurl"><?php echo $ts3->virtualserver_hostbanner_gfx_url; ?></textarea>
								</div>
								
								
								<div class="form-group">
								  <label for="exampleInputEmail1">Gfx URL</label>
								  <textarea rows="1" cols="30" class="form-control" name="gfxurl"><?php echo $ts3->virtualserver_hostbanner_url; ?></textarea>
								</div>

								<div class="form-group">
								  <label for="exampleInputEmail1">Server Karşılama Türü</label>
								  
							 <?
								$hostmode = $ts3->virtualserver_hostmessage_mode;
								if($hostmode == 0) $sifir="selected=''";
								if($hostmode == 1) $bir="selected=''";
								if($hostmode == 2) $iki="selected=''";
								if($hostmode == 3) $uc="selected=''";
							 ?>
								  <select class="form-control" name="hostmode">
								  <option value="0" name="0" selected="" <?php echo $sifir ?>>Gösterme </option>
								  <option value="1" name="1" <?php echo $bir ?>>LOG a kaydet</option>
								  <option value="2" name="2" <?php echo $iki ?>>Poke at</option>
								  <option value="3" name="3" <?php echo $uc ?>>Poke at ve tsye sokma </option>
								  </select> 
								</div>

								<input type="submit" class="btn btn-success" value="Güncelle" name="guncelle">
							</form>
						</div>
					</div>
							<div class="widget-content-left flex2">
								<div class="widget-heading">
																			
								</div>
							</div>
				</div>
			</div>
			</td>
			</tr>
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
