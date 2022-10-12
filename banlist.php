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

<?php

	$ts3a = new ts3admin($ts3_bayi_ip, $ts3_bayi_queryport);
	if($ts3a->getElement('success', $ts3a->connect())) {
		$ts3a->login($ts3_bayi_kullanici, $ts3_bayi_password);
		if($ts3a->getElement('success', $ts3a->selectServer($ts3_bayi_kullanici_port,'port',TRUE))) {
		$ts3a->setName("".$ana_server_name['ts3querynick']."");
		$ts3bilgiler =  $ts3a->serverInfo("-short");
		$ts3_bot = $ana_bayi_baglan['imbot'];
		if ($ts3bilgiler['success'])
		{
			$ts3bilgiler = $ts3bilgiler['data'];
			$pingcek = $ts3bilgiler['virtualserver_total_ping'];
			$loss = $ts3bilgiler['virtualserver_total_packetloss_total'];
				$ping = "".number_format($pingcek, 0)." Ms";
			$paketkaybi = "".number_format($loss*100, 2)." %";
		}
	}
	}


?>	

<?

	try{
		$banlist = $ts3->banList();
		$error = 0;
	}
	catch(TeamSpeak3_Adapter_ServerQuery_Exception $e) 
	{ 
		$error = 1;
	} 

	
	########################################################################################################
	#Ban Kaldırma
	########################################################################################################
	if(isset($_GET['bankaldir'])) {
		$ts3->banDelete($_GET['bankaldir']);
		alertmsg("","Ban Kaldırıldı.","$geridon","success");
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
								</div>
                            </div>
                        </div>

<div class="row">
<div class="col-md-12">
<div class="main-card mb-3 card">
	<div class="card-header">Ban Listesi</div>
	
	<?php if($error == 1) { ?>
			<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h4><i class="icon fa fa-ban"></i> Mesaj</h4>
				Banlı Kullanıcı Bulunamadı!
			</div>

		<?php } ?>
	
<div class="table-responsive">
	<table class="align-middle mb-0 table table-borderless table-striped table-hover">
	<tbody>
				<tr>
					<td>
						<div class="widget-content p-0">
							<div class="widget-content-wrapper">
								<div class="widget-content-left mr-3">
									<div class="widget-content-left">
									

									<div class="form-group">
									<? 
									echo "<table class='table table-hover'>";  
									echo '<center>';
									echo "<tr style='font-weight: bold;'>";  
									echo "<td width='150' align='center'>Id</td>";
									echo "<td width='150' align='center'>İsim</td>";  
									echo "<td width='300' align='center'>UID</td>";  
									echo "<td width='150' align='center'>Tarih</td>";  
									echo "<td width='150' align='center'>Banlayan</td>";  
									echo "<td width='150' align='center'>Ban Süresi</td>";  
									echo "<td width='150' align='center'>Açıklama</td>"; 
									echo "<td width='30' align='center'></td>"; 
									echo "</tr>";
									
									foreach ($banlist as $banlists) 
									{ 
										$segundos = " Seconds";
										echo '<td width="150" align=center>' . $banlists['banid'] . '</td>';
										echo '<td width="150" align=center>' . $banlists['lastnickname'] . '</td>';
										echo '<td width="300" align=center>' . $banlists['uid'] . '</td>';
										echo '<td width="150" align=center>' . date('d/m/Y - H:i',$banlists['created']) . '</td>';
										echo '<td width="150" align=center>' . $banlists['invokername'] . '</td>';
										echo '<td width="150" align=center>' . $banlists['duration'].$segundos. '</td>';
										echo '<td width="150" align=center>' . $banlists['reason'] . '</td>';
										echo '<td width="30" align=center><a class="fa fa-remove" href="banlist.php?bankaldir='.$banlists['banid'].'"></a></td>';
										echo '</tr>';
										echo '</center>';
										
									}
									?>
									</div>
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
					
					
       </div>


<script type="text/javascript" src="assets/scripts/main.js"></script>
</body>
</html>
