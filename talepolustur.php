<?
session_start();
ob_start();
include("inc/sql_base.php");
include("inc/functions.php");
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
    <? include("pages/footer.php");?>  

	
<?php

if(isset($_POST['talep'])){

$mesaj = $_POST['mesaj'];
$baslik = $_POST['baslik'];
$acil = $_POST['aciliyet'];
$durum_acik = '<input type="button" class="btn btn-success" value="Açık">';

$talepolstr = $sql->prepare("INSERT INTO ticket SET baslik=?,kimden=?,adsoyad=?,aciliyet=?,tarih=?,icerik=?,durum=?");
$hmmtalepolusturdum = $talepolstr->execute(array($baslik,$email,$adsoyad,$acil,"$tarih - $saat",$mesaj,$durum_acik));

if($hmmtalepolusturdum){
	alertmsg("","Destek Talebiniz Oluşturuldu.","support.php","success");
	return;
}else{
	alertmsg("","Teknik Bir Problem Oluştu.","$geridon","warning");
	return;
}
}

?>

		

			<? include("pages/header.php"); ?>

		
				<div class="app-main__outer">
                    <div class="app-main__inner">
                       
						

                        <div class="row">
                            <div class="col-md-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-header"><a href="talepolustur.php" class="btn btn-danger">
									Destek Talebi Oluştur
									</a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                            <tbody>
												<form action="talepolustur.php" method="POST">
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left flex2">
                                                                <div class="widget-heading">
																	<tr>
																		<td>Başlık</td>
																		<td>
																			<input type="text" class="input-text" name="baslik" placeholder="Başlık" required>
																		</td>
																	</tr>
																	<tr>
																		<td>Aciliyet</td>
																		<td>
																		<select class="input-text" name="aciliyet" required>
																		<option value="Acil">Acil</option>
																		<option value="Orta" selected>Orta</option>
																		<option value="Normal">Normal</option>
																		</select>
																		</td>
																	</tr>
																	<tr>
																		<td>Mesajınız</td>
																		<td>
																			<input type="text" class="input-text" name="mesaj" placeholder="Mesaj" required>
																		</td>
																	</tr>
																	<tr>
																		<td></td>
																		<td>
																		 <input type="submit" class="btn btn-success" name="talep" value="Talep Oluştur">
																		</td>
																	</tr>
																</div>
                                                            </div>
                                                        </div>
                                                    </div>
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
