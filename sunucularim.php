<?
session_start();
ob_start();
include("inc/sql_base.php");
include("inc/functions.php");
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

if($_GET['sunucu'] == 'yonet'){
	
	$serveridsi = $_GET['id'];


	$serververicek = $sql->prepare("SELECT * FROM sunucular Where id=?");
	$serververicek->execute(array($serveridsi));
		foreach($serververicek as $verile){
			
			$serveripsi = $verile['serverip'];
			$serverportu = $verile['serverport'];
			
		}
			
	
	$tscontrol = $sql->prepare("SELECT * FROM yonetsunucu WHERE email = ?");
	$tscontrol->execute(array($email));
	$tscontrolla = $tscontrol->fetch(PDO::FETCH_ASSOC);
	
	if($tscontrolla)
	{
		
		$yonetguncelle = $sql->prepare("UPDATE yonetsunucu SET yonetilecekip=?,yonetilecekport=? WHERE email=?");
		$yonetguncelle->execute(array($serveripsi,$serverportu,$email));
		
		header("Location:sunucuayarlari.php");
		
	}else{
		
		$yonetekle = $sql->prepare("INSERT INTO yonetsunucu SET email=?,yonetilecekip=?,yonetilecekport=?");
		$yonetekle->execute(array($email,$serveripsi,$serverportu));
		
		header("Location:sunucuayarlari.php");
		
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
                                    <div class="card-header">Sunucularım
                                    </div>
                                    <div class="table-responsive">
                                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                            <tbody>
											
											<th>#</td>
											<th>IP Adresi</th>
											<th>Port</th>
											<th></th>
											
											<?php	
											$sunucusec = $sql->prepare("SELECT * FROM sunucular Where email = ?");
											$sunucusec->execute(array($email));

												if ($sunucusec->rowCount()){
														foreach($sunucusec as $suncuyazdir){
											?>
                                            <tr>
												<td><?echo $suncuyazdir['id']; ?></td>
                                                <td><?echo $suncuyazdir['serverip']; ?></td>
                                                <td><?echo $suncuyazdir['serverport']; ?></td>
												<td>
												<a href="sunucularim.php?sunucu=yonet&id=<?echo $suncuyazdir['id'];?>" class="btn btn-danger">
												Sunucuyu Yönet
												</a>
												</td>
                                            </tr>
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

<script type="text/javascript" src="assets/scripts/main.js"></script>
</body>
</html>
