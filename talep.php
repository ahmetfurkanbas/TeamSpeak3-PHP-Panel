<?
session_start();
ob_start();
include("inc/sql_base.php");
include("inc/functions.php");
$geridon = $_SERVER['HTTP_REFERER'];
$idcek = $_GET['id'];

		$talepvarmi = $sql->prepare("SELECT * FROM ticket WHERE id = ?");
		$talepvarmi->execute(array($idcek));
		$talepvarmiasama = $talepvarmi->fetch(PDO::FETCH_ASSOC);
		
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


		
		if(!$talepvarmiasama){
			alertmsg("","Böyle bir destek talebi mevcut değildir.","support.php","warning");
			return;
		}
?>


<?


if(isset($_POST['gonder'])){

$tidi = $_POST['ticketid']; 
$cvkim = $adsoyad;
$cvcevap = $_POST['cevap'];
$ticketi = $_GET['id'];

$durum_acik = '<input type="button" class="btn btn-success" value="Açık">';

$devamke = $sql->prepare("INSERT INTO ticketre SET cevap=?,cevapsahibi=?,tarih=?,ticketid=?");
$devamke->execute(array($cvcevap,$cvkim,"$tarih - $saat",$ticketi));

$devamke2 = $sql->prepare("UPDATE ticket SET durum=? WHERE id=?");
$devamke2->execute(array($durum_acik,$ticketi));

if($devamke){
	alertmsg("","Mesajınız İletildi.","$geridon","success");
	return;
}else{
	alertmsg("","Teknik Bir Problem Oluştu.","support.php","warning");
	return;
}

}

?>

    <? include("pages/footer.php");?>  

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
											
											<tr>
												<th>#</th>
												<th>Başlık</th>
												<th>Aciliyet</th>
												<th>Tarih</th>
												<th>Durum</th>
												<th></th>
											</tr>
											<?php 


$listeisl = $sql->prepare("SELECT * FROM ticket Where id=?");
	$listeisl->execute(array($idcek));
		foreach($listeisl as $listele){
															
	
			$dtid = $listele['id'];
			$dtad = $listele['baslik'];
			$dtkimden = $listele['kimden'];
			$dtadsoyad = $listele['adsoyad'];
			$dtacil = $listele['aciliyet'];
			$dttarih = $listele['tarih'];
			$dtileti = $listele['icerik'];
			$dtdurum = $listele['durum'];
			$dtbayi = $listele['bayi'];

if($dtkimden !== $email){
	alertmsg("","Size Ait Olmayan Talepleri Görüntüleyemezsiniz.","support.php","warning");
	return;
}else{
?>
											 <tr>
												<th scope="row">#<? echo $_GET['id']; ?></th>
												<td><? echo $dtad; ?></td>
												<td><? echo $dtacil; ?></td>
												<td><? echo $dttarih; ?></td>
												<td><? echo $dtdurum; ?></td>
											</tr>
											</tbody>
										</table>
									</div>
									<!-- /.box-body -->
								  </div>
								  <!-- /.box -->
								</div>
								<!-- /.col -->



            <div class="col-md-12">
              <!-- DIRECT CHAT -->
              <div class="box box-warning direct-chat direct-chat-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Talep > <? echo $dtad; ?></h3>
          


            <!-- /.box-header -->
            <div class="box-body">

				
					<div class="box-body">

						<div class="card adminticketreplyheader">
							  <table width="100%" border="0" cellpadding="10" cellspacing="10">
								<tr>
								  <td><b><?echo $dtadsoyad;?></td>
								  <td align="right"><? echo $dttarih;?></td>
								</tr>
							  </table>
						</div>	
						<div class="card clientticketreply" style="overflow:hidden;">
						  <? echo $dtileti; ?>
						</div>

					</div>
                <!-- /.item -->
			</div>
			

<?
}
}
?>

<?
$listeisl2 = $sql->prepare("SELECT * FROM ticketre Where ticketid=?");
	$listeisl2->execute(array($idcek));
		foreach($listeisl2 as $listele2){
			
$dtctar = $listele2['tarih'];
$dtcre = $listele2['cevap'];
$dtkim = $listele2['cevapsahibi'];

if($dtkimden == $email){
?>

            <!-- /.box-header -->

				<div class="card adminticketreplyheader">
					  <table width="100%" border="0" cellpadding="10" cellspacing="10">
						<tr>
						  <td><b><?echo $dtkim;?></td>
						  <td align="right"><? echo $dtctar;?></td>
						</tr>
					  </table>
				</div>	
				<div class="card clientticketreply" style="overflow:hidden;">
				  <? echo $dtcre; ?>
				</div>

                <!-- /.item -->

<?

}

}
?>

<form method="post">
		<div class="messages__reply messages__details">
			<input name="ticketid" type="hidden" value="<? echo $idcek; ?>" /><br />
			<input name="cvpkimden" type="hidden" value="Musteri" /><br />
				<div class="row">
					<div class="col-lg-5">
						<input type="text" class="input-text" name="cevap" placeholder="Cevap">

					</div> 
					<div class="col-lg-5">
						<input name="gonder" class="btn btn-danger" type="submit" value="Gönder" />
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
                    <?include("pages/altkisim.php");?>
					
       </div>

<script type="text/javascript" src="assets/scripts/main.js"></script>
</body>
</html>
