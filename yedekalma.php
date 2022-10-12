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
// Yedek Alma
if(isset($_POST['yedekal'])){
	$mytr = date('d-m-Y-H-i-s');
	$mytr_ih = date('d-m-Y - H:i');

	$datayedek = $ts3->snapshotCreate();

	$file_include = "yedekler/yedek_".$serverip."-".$serverport."-".$mytr.".snapshot";

	file_put_contents($file_include, $datayedek);

	
	$sql_querys = $sql->prepare("INSERT INTO yedeks SET email=?,yedekadi=?,yedekaciklama=?,port=?,bayi=?");
	$sql_query = $sql_querys->execute(array($email,$file_include,$mytr_ih,$serverport,$serverip));
										
	alertmsg("","Sunucu Yedeğiniz $mytr Tarihinde Alınmıştır.Yönlendiriliyorsunuz.","$geridon","");
	return;
}
			


// Yedek Atma

if($_GET['yedek']){

$yedekid = $_GET['yedek'];

$yedekat = $sql->prepare("SELECT * FROM yedeks WHERE id=?");
$yedekat->execute(array($yedekid));
	foreach($yedekat as $yedekatm){

		$yedek_yol = $yedekatm['yedekadi'];
		$yedek_aciklama = $yedekatm['yedekaciklama'];
		$yedek_port = $yedekatm['port'];
		$yedek_bayi = $yedekatm['bayi'];
	}


if($yedek_bayi !== $serverip){
alertmsg("","Yedek Size Ait Değildir.","$geridon","warning");
return;
}else{
 

		$data = file_get_contents($yedek_yol);

			$ts3->snapshotDeploy($data);
			alertmsg("","Yedek Başarılı Kuruldu.","$geridon","success");
			return;
}
}

// Yedek Silme

if($_GET['yedeksil']){

$yedekid = $_GET['yedeksil'];

$yedeksil = $sql->prepare("SELECT * FROM yedeks WHERE id=?");
$yedeksil->execute(array($yedekid));
	foreach($yedeksil as $yedeksildim){

$yedek_id = $yedeksildim['id'];
$yedek_yol = $yedeksildim['yedekadi'];
$yedek_aciklama = $yedeksildim['yedekaciklama'];
$yedek_port = $yedeksildim['port'];
$yedek_bayi = $yedeksildim['bayi'];
}


if($yedek_bayi !== $serverip){
alertmsg("","Yedek Size Ait Değildir.","$geridon","warning");
return;
}else{


		$yedeksiliyom = $sql->prepare("DELETE FROM yedeks WHERE id=?");
		$pekisildim = $yedeksiliyom->execute(array($yedekid));
		unlink($yedek_yol);

		unset($yedek_yol);

		alertmsg("","Yedeğiniz Başarılı Şekilde Silinmiştir.","$geridon","success");		
		return;

}
}
/*
// Yedek indirme
if($_GET['yedekindir']){

$yedekid = $_GET['yedekindir'];

$yedekindir = $sql->prepare("SELECT * FROM yedeks WHERE id=?");
$yedekindir->execute(array($yedekid));
	foreach($yedekindir as $yedekdownload){

$yedek_id = $yedekdownload['id'];
$yedek_yol = $yedekdownload['yedekadi'];
$yedek_aciklama = $yedekdownload['yedekaciklama'];
$yedek_port = $yedekdownload['port'];
$yedek_bayi = $yedekdownload['bayi'];
}


if($yedek_bayi !== $serverip){
alertmsg("","Yedek Size Ait Değildir.","$geridon","warning");
return;
}else{
	
		download($yedek_yol);
		
		

}
}
*/

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
		<form method="POST" action="yedekalma.php">
<div class="row">
<div class="col-md-12">
<div class="main-card mb-3 card">
			<div class="card-header">Yedek Sistemi</div> 						

		
			<input type="submit" name="yedekal" value="Yedek Oluştur" class="mb-2 mr-2 btn btn-secondary">

		</form>
	
<div class="table-responsive">
	<table class="align-middle mb-0 table table-borderless table-striped table-hover">
	<tbody>
				<tr>
					<td>
						<div class="widget-content p-0">
							<div class="widget-content-wrapper">
								<div class="widget-content-left mr-3">
									<div class="widget-content-left">
										<form method="POST" action="yedekalma.php?r=<?echo $_GET['r'];?>">
											<div class="form-group">
												 <tr>

													<th>ID</th>
													<th>YEDEK TARIHI</th>
													<th></th>
													<th></th>

												  </tr>
												  
												  <?php
												  
													$yedeklerim = $sql->prepare("SELECT * FROM yedeks WHERE port=? AND bayi=?");
													$yedeklerim->execute(array($serverport,$serverip));
														foreach($yedeklerim as $yedekyazdir){
		
													$yedek_id = $yedekyazdir['id'];
													$yedek_yol = $yedekyazdir['yedekadi'];													
													
													?>
													<tr>
													
													<td><?echo $yedekyazdir['id'];?></td>
													<td><?echo $yedekyazdir['yedekaciklama'];?></td>
													<td><a href="yedekalma.php?yedek=<?echo $yedekyazdir['id'];?>" class="btn btn-danger">Yedeği Yükle</a></td>
													<td><a href="yedekalma.php?yedeksil=<?echo $yedekyazdir['id'];?>" class="btn btn-danger">Yedeği Sil</a></td>
													
													</tr>
													
														<?}?>



											</div>
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
