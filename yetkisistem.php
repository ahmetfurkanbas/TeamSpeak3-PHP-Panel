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

// Admin Server Query Yetkisi Verme
if($_POST['botver']){

$inputuser = $_POST["imclient"];
$sgid = "$ts3_bayi_queryid";     // Query ID
if($inputuser == 0){
	alertmsg("","Geçersiz Kullanıcı Seçtiniz.","$geridon","warning");
	return;
}
$ts3->selfUpdate(array('ts3querynick'=>"$ana_server_name"));
$nick = $_POST['client'];

try{
$ts3->serverGroupClientAdd($sgid,$inputuser);	
alertmsg("Başarılı","Admin Server Query Yetkisi Verildi","$geridon","success");
return;
}catch(TeamSpeak3_Exception $e){
alertmsg("Hata!","Yetki Verilirken Problem Oluştu.","$geridon","error");
return;
}

}


// Admin Server Query Yetkisi Alma
if($_POST['botal']){

$inputuser = $_POST["imclient"];
$sgid = "$ts3_bayi_queryid";     // Query ID
		
if($inputuser == 0){
	alertmsg("","Geçersiz Kullanıcı Seçtiniz.","$geridon","warning");
	return;
}
$ts3->selfUpdate(array('ts3querynick'=>"$ana_server_name"));
$nick = $_POST['client'];


try{
$ts3->serverGroupClientDel($sgid,$inputuser);
alertmsg("Başarılı","Admin Server Query Yetkisi Alındı","$geridon","success");
return;
}catch(TeamSpeak3_Exception $e){
alertmsg("Hata!","Yetki Alınırken Problem Oluştu.","$geridon","error");
return;
}

}

	/// Normal Yetki Sistemi
	
	if(isset($_POST['yetkiver'])) {
		
		$kullanicigrup = $_POST['kullanicigrup'];
		if($kullanicigrup == 0){
			alertmsg("","Geçersiz Kullanıcı Seçtiniz.","$geridon","warning");
			return;
		}
		$perm = $_POST['perm'];
		if($perm == 0){
			alertmsg("","Geçersiz Yetki Seçtiniz.","$geridon","warning");
			return;
		}
		$ts3->selfUpdate(array('ts3querynick'=>"$ana_server_name"));
		
		try{
			
		$ts3->serverGroupClientAdd($perm,$kullanicigrup);
		alertmsg("","Yetki Verildi.","$geridon","success");
		return;
		
		}catch(TeamSpeak3_Exception $e){
			
		alertmsg("Hata!","Yetki Verilirken Problem Oluştu.","$geridon","error");
		return;
		
		}
	}
	
	
	// Normal Yetki Alma
	if(isset($_POST['yetkial'])) {
		
		$kullanicigrup = $_POST['kullanicigrup'];
		if($kullanicigrup == 0){
			alertmsg("","Geçersiz Kullanıcı Seçtiniz.","$geridon","warning");
			return;
		}
		$perm = $_POST['perm'];
		
		if($perm == 0){
			alertmsg("","Geçersiz Yetki Seçtiniz.","$geridon","warning");
			return;
		}
		$ts3->selfUpdate(array('ts3querynick'=>"$ana_server_name"));
		try{
			
		$ts3->serverGroupClientDel($perm,$kullanicigrup);
		alertmsg("","Yetki Alındı.","$geridon","success");
		return;
		
		}catch(TeamSpeak3_Exception $e){
			
		alertmsg("Hata!","Yetki Alınırken Problem Oluştu.","$geridon","error");
		return;
		}
		
	}		
	
// Yetki Kodu Oluşturma
$x = $_GET['r'];
	
if(isset($_POST['createtoken']))
{
	
	$yetki = $_POST['yetki'];
	
	if($yetki == '0'){
		alertmsg("","Geçersiz Yetki Seçtiniz.","$geridon","warning");
		return;	
	}
	
	$group = $ts3->serverGroupGetByName("$yetki");
	try{
		$key = $group->privilegeKeyCreate();
		alertmsg("Başarılı","Token Kodu Oluşturuldu. $key","$geridon","success");
		return;
	}catch(TeamSpeak3_Exception $e){
		alertmsg("","Token Oluşturulamadı.","$geridon","error");
		return;
	}
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
	<div class="card-header">Yetki Sistemi</div>
	
<div class="table-responsive">
	<table class="align-middle mb-0 table table-borderless table-striped table-hover">
	<tbody>
			<form method="POST" action="yetkisistem.php"class="form-validation-1">
				<tr>
					<td>
						<div class="widget-content p-0">
							<div class="widget-content-wrapper">
								<div class="widget-content-left mr-3">
									<div class="widget-content-left">
										Admin Server Query<br><br>
									

									<div class="form-group">
										<select name="imclient" class="form-control">	
										<option value="0">Yetki Verilecek Kullanıcıyı Seçin</option>										
									<?php 
										foreach($ts3->clientList() as $tsclient) {
 
											if($tsclient['client_type'] == 1) continue;
											$diq = $tsclient['client_database_id'];
											echo"<option value=$diq>".$tsclient."</option>";
 
											}
										?>								
										</select>
									</div>
										
										<input type="submit" name="botver" class="mb-2 mr-2 btn btn-secondary" value="Yetkiyi Ver">
										<input type="submit" name="botal" class="mb-2 mr-2 btn btn-secondary" value="Yetkiyi Al">
									</div>
								</div>
									<div class="widget-content-left flex2">
										<div class="widget-heading">
																								
										</div>
									</div>
							</div>
						</div>
					</td>
					
					<td>
						<div class="widget-content p-0">
							<div class="widget-content-wrapper">
								<div class="widget-content-left mr-3">
									<div class="widget-content-left">
										Yetki Verme Sistemi<br><br>
									

									<div class="form-group">
										<select name="kullanicigrup" class="form-control">	
										<option value="0">Yetki Verilecek Kullanıcıyı Seçin</option>										
									<?php 
											foreach($ts3->clientList() as $tsclient) {

												if($tsqclient['client_type'] == 1) false;

												$uniqq = $tsclient['client_database_id'];

												echo"<option value=$uniqq>".$tsclient."</option>";
											}
											
										?> 							
										</select>
										<br>
										
										<select name="perm" class="form-control">	
										<option value="0">Yetkiyi Seçin</option>										
										<?php 
											$servergroups = $ts3->serverGroupList(array("type" => TeamSpeak3::GROUP_DBTYPE_REGULAR));
											foreach($servergroups as $groups) {

											$grp = $groups['sgid'];

											echo"<option value='$grp'>".$groups."</option>";

											}
										?>  	
										
										</select>
									</div>
										
										<input type="submit" name="yetkiver" class="mb-2 mr-2 btn btn-secondary" value="Yetkiyi Ver">
										<input type="submit" name="yetkial" class="mb-2 mr-2 btn btn-secondary" value="Yetkiyi Al">
									</div>
								</div>
									<div class="widget-content-left flex2">
										<div class="widget-heading">
																								
										</div>
									</div>
							</div>
						</div>
					</td>
		
					<td>
						<div class="widget-content p-0">
							<div class="widget-content-wrapper">
								<div class="widget-content-left mr-3">
									<div class="widget-content-left">
										Token Oluştur<br><br>
									

					<div class="block-area" id="required">
								<div class="clearfix"></div>
							
									<div class="form-group m-b-15">
					
										<select name="yetki" class="form-control">
											<option value="0">Kodu Oluşturulacak Yetkiyi Seçin</option>
											<?
											$x_sunucugruplari = $ts3->serverGroupList(array("type" => TeamSpeak3::GROUP_DBTYPE_REGULAR));
											foreach($x_sunucugruplari as $sunucugrubulistesi)
											{
												echo  "<option value='$sunucugrubulistesi' name='$sunucugrubulistesi'>".$sunucugrubulistesi ."</option>";
											}
											?>
										</select>
							
									</div> 

										<input class="mb-2 mr-2 btn btn-secondary" type="submit" name="createtoken" value="Olustur">
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
			</form>
		</tbody>
	</table>
	
</div>
<?php
	try {	
		$permList = $ts3->serverGroupList();
		$tokenList = $ts3->privilegeKeyList(true);
	} catch( Exception $e ) {
		$tokenList = array();
	}
	
?>

<div class="row">
<div class="col-md-12">
<div class="main-card mb-3 card">
	<div class="card-header">Token Listesi</div>

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
									
	<table class='table table-hover'>  
			<center>
								<tr style='font-weight: bold;'> 
									<td width='150' align='center'>Token</td>
									<td width='150' align='center'>Token Tipi</td> 
									<td width='300' align='center'>Yetki</td> 
									<td width='150' align='center'>Oluşturma Tarihi</td>
								</tr>
									
									<?php
									
									try {	
										$permList = $ts3->serverGroupList();
										$tokenList = $ts3->privilegeKeyList(true);
									} catch( Exception $e ) {
										$tokenList = array();
									}
									
									foreach ($tokenList as $tokenliste) 
									{ 
									?>
										
										
										<td width="150" align="center"><?php echo $tokenliste['token'];?> </td>
										<td width="150" align="center"><?php echo $tokenliste['token_type'] ? 'Channel (Kanal)' : 'Server'?></td>
										<td width="300" align="center"><?php echo $tokenliste['token_id1'] ? $tokenliste['token_id1'] : '-'?></td>
										<td width="150" align="center"><?php echo date('d.m.Y - H:i:s', $tokenliste['token_created']);?></td>										
										</tr>
			</center>
										
								<?	}?>
								
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
</div>
                        
                    </div>
                    <?include("pages/altkisim.php");?>
					
       </div>

<script type="text/javascript" src="assets/scripts/main.js"></script>
</body>
</html>
