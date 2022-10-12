<?
session_start();
ob_start();
include("inc/sql_base.php");
include("inc/functions.php");

require_once("class/framework/TeamSpeak3.php");	
require_once("class/framework/ts3admin.class.php");

$geridon = $_SERVER['HTTP_REFERER'];
?>
<html>

<head>
	<? include("pages/head.php");?>
	<link href="css/style.bundle.css" rel="stylesheet" type="text/css">
</head>

<body>

<?
	// Oturum Kontrolü
		if($_SESSION['login']!= "OK"){
			alertmsg("Uyarı!","Bu sayfayı görüntüleyebilmek için giriş yapmış olmanız gerekmektedir.","index.php","warning");
			return;
		}


?>

<?if($admin_mi !== '1'){
	alertmsg("","Burası Senin İçin Yapılmadı Bilader Hadi İşine :)","index.php","warning");
	return;
	}
	
	?>

<?
if($_GET['banlaeleman'])
{
	
	$banlanacakeleman = $_GET['banlaeleman'];
	
$banlakullanici = $sql->prepare("SELECT * FROM users WHERE id=?");
$banlakullanici->execute(array($banlanacakeleman));
	foreach($banlakullanici as $banlavericek){

$adamid = $banlavericek['id'];
$adamasoyad = $banlavericek['adsoyad'];
$banlaemail = $banlavericek['email'];
$banlakadi = $banlavericek['kadi'];
}

if($banlakullanici > 0){

		$banadam = $sql->prepare("UPDATE users SET hesapban=? WHERE id=?");
		$pekibanla = $banadam->execute(array("1",$banlanacakeleman));

		alertmsg("","$adamasoyad İsimli Kullanıcı Yasaklandı!","$geridon","success");		
		return;
}else{
		alertmsg("","Bu ID'e ait kullanıcı yoktur.","$geridon","warning");
		return;
}
	
}

if($_GET['bankaldir'])
{
	
	$bankaldireleman = $_GET['bankaldir'];
	
$banlakullanici = $sql->prepare("SELECT * FROM users WHERE id=?");
$banlakullanici->execute(array($bankaldireleman));
	foreach($banlakullanici as $banlavericek){

$adamid = $banlavericek['id'];
$adamasoyad = $banlavericek['adsoyad'];
$banlaemail = $banlavericek['email'];
$banlakadi = $banlavericek['kadi'];
}

if($banlakullanici > 0){

		$banadam = $sql->prepare("UPDATE users SET hesapban=? WHERE id=?");
		$pekibanla = $banadam->execute(array("0",$bankaldireleman));

		alertmsg("","$adamasoyad İsimli Kullanıcının Yasağı Kaldırıldı!","$geridon","success");		
		return;
}else{
		alertmsg("","Bu ID'e ait kullanıcı yoktur.","$geridon","warning");
		return;
}
	
}


?>



    <? include("pages/footer.php");?>       

		

			<? include("pages/header.php"); ?>

		
				<div class="app-main__outer">
                    <div class="app-main__inner">
                       
						<div class="row">
                            <div class="col-md-6 col-xl-4">
                                <div class="card mb-3 widget-content bg-midnight-bloom">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Toplam Sunucu</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white"><span><?echo $allservers;?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="card mb-3 widget-content bg-arielle-smile">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Toplam Kullanıcı</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white"><span><?echo $allusers; ?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="card mb-3 widget-content bg-grow-early">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Toplam Aktif Kullanıcı</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white"><span><?echo $aktifkullanici;?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-header">Kullanıcılar 
                                    </div>
                                    <div class="table-responsive">
                                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                            <tbody>
											
											<th>ID</th>
											<th>Ad Soyad</th>
											<th>Email</th>
											<th>Kullanıcı Adı</th>
											<th>Telefon Numarası</th>
											<th>Yetkisi</th>
											<th>Aktiflik Durumu</th>
											<th>Ban Durumu</th>
											<th>İp Adresi</th>
											<th>Son Giriş Tarihi</th>
											<th>Son Giriş Saati</th>
											<th></th>
											<?php
												$kullanic = $sql->query("SELECT * FROM users", PDO::FETCH_ASSOC);
													if ($kullanic->rowCount()){
														foreach($kullanic as $kullanicilaridok){
											?>
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left mr-3">
                                                                <div class="widget-content-left">
																<tr>
                                                                    <td><?echo $kullanicilaridok['id'];?></td>
                                                                    <td><?echo $kullanicilaridok['adsoyad'];?></td>
                                                                    <td><?echo $kullanicilaridok['email'];?></td>
                                                                    <td><?echo $kullanicilaridok['kadi'];?></td>
                                                                    <td><?echo $kullanicilaridok['telno'];?></td>
                                                                    <td>
																		<?php
																		if($kullanicilaridok['admin_mi'] == '1'){
																			echo "Admin";																		
																		}else{
																			echo "User";
																		}?>
																	</td>
																	
																	<td>
																		<?php
																		if($kullanicilaridok['aktif_mi'] == '1'){
																			echo "Aktif";
																		}else{
																			echo "Çevrimdışı";
																		}
																		?>
																	</td>
																	<td>
																		<?php
																		if($kullanicilaridok['hesapban'] == '1'){
																			echo "Banlı Hesap";
																		}else{
																			echo "Banı Yok";
																		}?>
																	</td>
																	<td><?echo $kullanicilaridok['uip'];?></td>
																	<td><?echo $kullanicilaridok['songiristarih'];?></td>
																	<td><?echo $kullanicilaridok['songirissaat'];?></td>
                                                                    <td>
																	<a href="kullanicilistele.php?banlaeleman=<?echo $kullanicilaridok['id'];?>" class="btn btn-danger">
																	Kullanıcıyı Yasakla
																	</a>
																	</td> 
																	<td>
																	<a href="kullanicilistele.php?bankaldir=<?echo $kullanicilaridok['id'];?>" class="btn btn-danger">
																	Kullanıcının Yasağı Kaldır
																	</a>
																	</td>
																</tr>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                          <? } } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
						
						
                        
                    </div>
                    <?include("pages/altkisim.php");?>
					
       </div>

	<script src="js/vendors.bundle.js" type="text/javascript"></script>
	<script src="js/scripts.bundle.js" type="text/javascript"></script>
	<script src="js/fullcalendar.bundle.js" type="text/javascript"></script>
	<script src="js/dashboard.js" type="text/javascript"></script>
	<script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
	<script src="js/sweetalert.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="assets/scripts/main.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
</body>
</html>
