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
<div class="m-content">
		<!--begin::Modal-->
		<div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">
							Sunucu Ekle
						</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form id="portekleform" method="post">
						<div class="modal-body">
							<div id="PortEkleLa"></div>
							<div class="form-group">
								<label class="form-control-label">
									Email
								</label>
								<input type="text" class="form-control m-input m-input--solid" placeholder="Email" name="email" autocomplete="off">
							</div>
							<div class="form-group">
								<label class="form-control-label">
									Port
								</label>
								<input type="text" class="form-control m-input m-input--solid" placeholder="Port" name="port" autocomplete="off">
							</div>
							<div class="form-group">
								<label class="form-control-label">
									Kişi Sayısı
								</label>
								<input type="text" class="form-control m-input m-input--solid" placeholder="Kişi Sayısı" name="kisisayisi" autocomplete="off">
							</div>
							<div class="form-group">
								<label class="form-control-label">
									Sunucu Seçiniz
								</label>
								<select class="form-control m-input m-input--solid" name="sunucusec" autocomplete="off">
									<option value="0">Sunucu Seçiniz</option>
									<?php
									$sunucusec = $sql->prepare("SELECT * FROM servers");
									$sunucusec->execute(array());

										if ($sunucusec->rowCount()){
											foreach($sunucusec as $sunucusecim){
									?>
									<option name="sunucusec" value="<?echo $sunucusecim['serveradres'];?>"><?echo $sunucusecim['serveradres'];?></option>
									
										<?}}?>
								</select>
							</div>

							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">
								İptal
							</button>
							<div id="SunucuEkle" class="btn btn-success">
								Ekle
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
</div>

<?
if($_GET['sunucusil'])
{
	
	$silinecekid = $_GET['sunucusil'];
	
$silsunucu = $sql->prepare("SELECT * FROM sunucular WHERE id=?");
$silsunucu->execute(array($silinecekid));
	foreach($silsunucu as $silvericek){

$sunucuid = $silvericek['id'];
$yedek_yol = $silvericek['email'];
}

if($silsunucu > 0){

		$yedeksiliyom = $sql->prepare("DELETE FROM sunucular WHERE id=?");
		$pekisildim = $yedeksiliyom->execute(array($silinecekid));

		alertmsg("","Sunucu Başarılı Şekilde Silindi.","$geridon","success");		
		return;
}else{
		alertmsg("","Bu ID'e ait sunucu yoktur.","$geridon","warning");
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
                                    <div class="card-header">Sunucular 
                                    </div>
									<div data-toggle="modal" data-target="#add_modal" class="m--font-accent btn btn-danger">Sunucu Ekle</div>
                                    <div class="table-responsive">
                                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                            <tbody>
											
											<th>ID</th>
											<th>Email</th>
											<th>İp Adresi</th>
											<th>Port</th>
											<th></th>
											<?php
												$sunuculars = $sql->query("SELECT * FROM sunucular", PDO::FETCH_ASSOC);
													if ($sunuculars->rowCount()){
														foreach($sunuculars as $sunucularyazdir){
											?>
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left mr-3">
                                                                <div class="widget-content-left">
																<tr>
                                                                    <td><?echo $sunucularyazdir['id'];?></td>
                                                                    <td><?echo $sunucularyazdir['email'];?></td>
                                                                    <td><?echo $sunucularyazdir['serverip'];?></td>
                                                                    <td><?echo $sunucularyazdir['serverport'];?></td>
                                                                    <td>
																	<a href="sunucular.php?sunucusil=<?echo $sunucularyazdir['id'];?>" class="btn btn-danger">
																	Sunucuyu Sil
																	</a>
																	<a href="#" class="btn btn-danger">
																	Sunucuyu Düzenle
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
