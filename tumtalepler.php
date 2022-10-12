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

<?if($admin_mi !== '1'){
	alertmsg("","Burası Senin İçin Yapılmadı Bilader Hadi İşine :)","index.php","warning");
	return;
	}
	
?>
	
    <? include("pages/footer.php");?>  

			<? include("pages/header.php"); ?>

		
				<div class="app-main__outer">
                    <div class="app-main__inner">
                       
						

                        <div class="row">
                            <div class="col-md-12">
                                <div class="main-card mb-3 card">
									<div class="card-header"><a href="destektalepleri.php" class="btn btn-danger">
									Aktif Talepleri Görüntüle
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
												$taleplerim = $sql->prepare("SELECT * FROM ticket");
												$taleplerim->execute(array());
														foreach($taleplerim as $talepyazdir){
															
															
															$dtid = $talepyazdir['id'];
															$dtad = $talepyazdir['baslik'];
															$dtkimden = $talepyazdir['kimden'];
															$dtacil = $talepyazdir['aciliyet'];
															$dttarih = $talepyazdir['tarih'];
															$dtileti = $talepyazdir['icerik'];
															$dtdurum = $talepyazdir['durum'];
															$dtbayi = $talepyazdir['bayi'];
											?>
                                            <tr>
                                               <td>
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left flex2">
                                                                <div class="widget-heading">
																	<tr>
																		<th scope="row">#<?echo $dtid;?></th>
																		<td><? echo $dtad;?></td>
																		<td><? echo $dtacil;?></td>
																		<td><? echo $dttarih;?></td>
																		<td><? echo $dtdurum; ?></td>
																		<td><a href="admintalep.php?id=<? echo $dtid; ?>" class="btn btn-warning">Görüntüle</a></td>
																	</tr>
																</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                          <? } ?>
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
