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
    <? include("pages/footer.php");?>       

			<? include("pages/header.php"); ?>

<?


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
	<div class="card-header">Sunucudaki Kişiler</div>
	
<div class="table-responsive">
	<table class="align-middle mb-0 table table-borderless table-striped table-hover">
	<tbody>
			<form method="POST" action="yetkisistem.php"class="form-validation-1">
				<tr>
					<td>
						<div class="tile">
                                <div class="tile-config dropdown">
                                    <a data-toggle="dropdown" href="" class="tooltips tile-menu" title="" data-original-title="Options"></a>
                                    <ul class="dropdown-menu pull-right text-right"> 
                                    </ul>
                                </div>
                                
                                <div class="listview narrow">
								
									<?php
									
									
									
									

									/*
										<?php $map = $ts3->getViewer(new TeamSpeak3_Viewer_Html("class/framework/Viewer/", "images/countryflags/", "data:image")); ?>

											<?= $map; ?>
											$kullanici = $ts3->channelList(); // clientList
									*/
									
									// https://yat.qa/ressourcen/variablen-parameter/#channel
									// https://yat.qa/ressourcen/server-query-kommentare/
									
									/*$ts3->clientListReset();
									foreach ($ts3->clientList() as $client) {
										echo "Client " . $client->client_nickname . " in channel with ID " . $client->cid . " has channel group " . $client->client_channel_group_id . "\n";
									}  */
									
									
									echo "<br>";
									echo "<br>";
									echo "<br>";
									echo "<br>";
									
									$kullanici = $ts3->channelList(); // clientList
									foreach($kullanici as $inf_users)
									
									{
										
								/*		$ts3_VirtualServer->getViewer(new TeamSpeak3_Viewer_Html("baglanti/framework/Viewer/", "images/countryflags/", "data:image"));
								                                            <?/*<a href=""><small class="text-muted"><? echo $inf_users['client_nickname']; ?></small></a>
                                            <a href=""><small class="text-muted">IP : <? echo $inf_users['connection_client_ip']; ?></small></a>
											
								*/

									
									?>
									<div class="media p-l-5">
                                        <div class="pull-left">
											
                                        </div>
                                        <div class="media-body">
											<? echo $inf_users['channel_name']; ?>
											<br>Kişi Sayısı : <? echo $inf_users['total_clients']; ?>
											

                                        </div>
                                    </div>
									<?}?>

                                </div>
                    </div>
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
