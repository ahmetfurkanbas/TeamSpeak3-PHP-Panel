
			<?if($_GET['r']=='server_status'){?>
			
			                <div class="block-area" id="required">
				<?  echo $sonuc; ?>
                    <h3 class="block-title">SUNUCU ISTATISLIKLERI</h3>

                            <div class="tile">
                                <h2 class="tile-title">Sunucu Bilgileri</h2>
                                
                                <div class="listview narrow">
                
                                    <div class="media">
                                        <div class="pull-right">
                                            <div class="counts" style="font-size: 15px;"><? echo $ts3->getAdapterHost(); echo ":"; echo $ts3->virtualserver_port; ?></div>
                                        </div>
                                        <div class="media-body">
                                            <h6>Sunucu Host : </h6>
                                        </div>
                                    </div>
                                    
                                    <div class="media">
                                        <div class="pull-right">
                                            <div class="counts" style="font-size: 15px;"><? echo $ts3->virtualserver_name; ?></div>
                                        </div>
                                        <div class="media-body">
                                            <h6>Sunucu Adı : </h6>
                                        </div>
                                    </div>
                                    
                                    <div class="media">
                                        <div class="pull-right">
                                            <div class="counts" style="font-size: 15px;"><? echo TeamSpeak3_Helper_Convert::seconds($ts3->virtualserver_uptime); ?></div>
                                        </div>
                                        <div class="media-body">
                                            <h6>Sunucu Uptime : </h6>
                                        </div>
                                    </div>
                                    
                                    <div class="media">
                                        <div class="pull-right">
                                            <div class="counts" style="font-size: 15px;"><? echo TeamSpeak3_Helper_Convert::version($ts3->virtualserver_version); ?></div>
                                        </div>
                                        <div class="media-body">
                                            <h6>Sunucu Version : </h6>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="pull-right">
                                            <div class="counts" style="font-size: 15px;"><? echo $ts3->virtualserver_clientsonline . " / " . $ts3->virtualserver_maxclients; ?></div>
                                        </div>
                                        <div class="media-body">
                                            <h6>Aktif Kullanıcılar : </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

					
					<div class="tile">
                                <h2 class="tile-title">Kullanıcılar</h2>
                                <div class="tile-config dropdown">
                                    <a data-toggle="dropdown" href="" class="tooltips tile-menu" title="" data-original-title="Options"></a>
                                    <ul class="dropdown-menu pull-right text-right"> 
                                    </ul>
                                </div>
                                
                                <div class="listview narrow">
									<?
									$kullanici = $ts3->clientList();
									foreach($kullanici as $inf_users){?>
                                    <div class="media p-l-5">
                                        <div class="pull-left">
                                            <img width="37" src="img/profile-pics/<? $fx=rand(1,4); echo "$fx.jpg";?>" alt="">
                                        </div>
                                        <div class="media-body">
                                            <a class="news-title" href=""><? echo $inf_users['client_nickname']; ?></a>
                                            <div class="clearfix"></div>
                                            <a href=""><small class="text-muted">IP : <? echo $inf_users['connection_client_ip']; ?></small></a>
                                        </div>
                                    </div>
									<?}?>

                                </div>
                    </div>
					
					
					
					
					
                </div>
				
			<?}?>
			
			<?if($_GET['r']=='serverprocess'){?>
                <div class="block-area" id="required">
								<?  echo $sonuc; ?>
                    <h3 class="block-title">SUNUCU ISLEMLERI</h3>
                    <form role="form" method="POST" action="process.php?r=<?echo$_GET['r'];?>"class="form-validation-1">
                        

                        
                        <div class="clearfix"></div>
                        
													
                        

						
					<div class="form-group m-b-15" align="center" style="width: 100%">
                        <input name="server_start" type="submit" class="btn btn-sm" style="width:35%" value="Sunucuyu Baslat" >
                        <input name="server_stop" type="submit" class="btn btn-sm" style="width:35%"value="Sunucuyu Durdur" >

                    </div>
                    </form>
                </div>
			<?}?>
			
			<?if($_GET['r']=='createtoken'){?>
                <div class="block-area" id="required">
								<?  echo $sonuc; ?>
                    <h3 class="block-title">Yetki Kodu Olustur</h3>
                    <form role="form" method="POST" action="process.php?r=<?echo$_GET['r'];?>"class="form-validation-1">
                        

                        
                        <div class="clearfix"></div>
                        
                    <div class="form-group m-b-15">
					
                            <select name="yetki" class="select" name="bank2" id="bank2">
                                <option value="">Kodu Oluşturulacak Yetkiyi Seçin</option>
								<?
								$x_sunucugruplari = $ts3->serverGroupList();
								foreach($x_sunucugruplari as $sunucugrubulistesi)
								{
									echo  "<option value='$sunucugrubulistesi' name='$sunucugrubulistesi'>".$sunucugrubulistesi ."</option>";
								}
								?>
                            </select>
							
                        </div> 
			

                        
                        <input class="btn btn-block btn-alt" type="submit" name="createtoken" value="Olustur">
                    </form>
                </div>
			<?}?>
			
			
			
			
			
			<?if($_GET['r']=='createchannel'){?>
                <div class="block-area" id="required">
								<?  echo $sonuc; ?>
                    <h3 class="block-title">Yeni Kanal Olustur</h3>
                    <form role="form" method="POST" action="process.php?r=<?echo$_GET['r'];?>"class="form-validation-1">
                        

                        
                        <div class="clearfix"></div>
                        
                        <div class="form-group m-b-15">
                            <label>Kanal Adını Girin</label>
                            <textarea name="channelname" class="input-sm validate[required] form-control" placeholder="..."></textarea>
                        </div>
                        <input class="btn btn-block btn-alt" type="submit" name="createchannel" value="Olustur">
                    </form>
                </div>
			<?}?>
			
			
			
			<?if($_GET['r']=='allkick'){?>
                <div class="block-area" id="required">
								<? include("inc/sonuc.php"); ?>
                    <h3 class="block-title">Tüm Kullanıcıları Kickle</h3>
                    <form role="form" method="POST" action="process.php?r=<?echo$_GET['r'];?>"class="form-validation-1">
                        

                        
                        <div class="clearfix"></div>
                        
                        <div class="form-group m-b-15">
                            <label>Kick Sebebini Girin</label>
                            <textarea name="why" class="input-sm validate[required] form-control" placeholder="..."></textarea>
                        </div>
                        <input class="btn btn-block btn-alt" type="submit" name="users_kick" value="Kickle">
                    </form>
                </div>
			<?}?>
			
			
			
			


			
			<?if($_GET['r']=='oneuserkick'){?>
                <div class="block-area" id="required">
                    <h3 class="block-title">Kullanıcı Kickle</h3>
                    <form role="form" method="POST" action="process.php?r=<?echo$_GET['r'];?>"class="form-validation-1">
                        

                        
                        <div class="clearfix"></div>
                        
                    <div class="form-group m-b-15">
                            <select name="whokick" class="select" name="bank2" id="bank2">
                                <option value="">Kicklenecek Kullanıcıyı Seçin</option>
							<?
							$x_kullanicilistesi = $ts3->clientList(array("client_platform" => ""));
							foreach($x_kullanicilistesi as $ts3_Client)
							{
							echo  "<option value='$ts3_Client' name='$ts3_Client'>".$ts3_Client ."</option>";
							}
							?>
                            </select>	
						
                        </div> 
						
										<div class="form-group m-b-15">
                            <label>Kick Sebebini Girin</label>
                            <textarea class="input-sm validate[required] form-control" placeholder="..."></textarea>
                        </div>
                        
                        <input class="btn btn-block btn-alt" type="submit" name="user_kick" value="Olustur">
                    </form>
                </div>
			<?}?>
			
			
			<?if($_GET['r']=='oneuserban'){?>
                <div class="block-area" id="required">
								<?  echo $sonuc; ?>
                    <h3 class="block-title">Kullanıcı Banla</h3>
                    <form role="form" method="POST" action="process.php?r=<?echo$_GET['r'];?>"class="form-validation-1">
                        

                        
                        <div class="clearfix"></div>
                        
                    <div class="form-group m-b-15">
                            <select name="client" class="select" name="bank2" >
                                <option value="">Banlanacak Kullanıcıyı Seçin</option>
							<?
							$x_kullanicilistesi = $ts3->clientList(array("client_platform" => ""));
							foreach($x_kullanicilistesi as $ts3_Client)
							{
							echo  "<option value='$ts3_Client' name='$ts3_Client'>".$ts3_Client ."</option>";
							}
							?>
                            </select>
                        </div> 
												                        <div class="form-group">
                            <label>Ban Süresi (Saniye)</label>
                            <input name="time" type="text" class="input-sm  form-control" name="grouped" placeholder="...">
                        </div>
														
				<div class="form-group m-b-15">
                            <label>Ban Sebebini Girin</label>
                            <textarea name="reason" class="input-sm validate[required] form-control" placeholder="..."></textarea>
                        </div>
			

                        
                        <input class="btn btn-block btn-alt" type="submit" name="user_ban" value="Olustur">
                    </form>
                </div>
			<?}?>
			
			
			<?if($_GET['r']=='servermessage'){?>
                <div class="block-area" id="required">
				<?  echo $sonuc; ?>
                    <h3 class="block-title">Mesaj Gönder</h3>
                    <form role="form" method="POST" action="process.php?r=<?echo$_GET['r'];?>"class="form-validation-1">
                        

                        
                        <div class="clearfix"></div>
                        
														
				<div class="form-group m-b-15">
                            <label>Gönderilecek Mesajı Girin</label>
                            <textarea name="mesaj" class="input-sm validate[required] form-control" placeholder="..."></textarea>
                        </div>
			

                        
                        <input class="btn btn-block btn-alt" type="submit" name="server_message" value="Gonder">
                    </form>
                </div>
			<?}?>

			
						<?if($_GET['r']=='pokeallusers'){?>
                <div class="block-area" id="required">
				<?  echo $sonuc; ?>
                    <h3 class="block-title">Kullanıcılara Poke Gönder</h3>
                    <form role="form" method="POST" action="process.php?r=<?echo$_GET['r'];?>"class="form-validation-1">
                        

                        
                        <div class="clearfix"></div>
                        
														
				<div class="form-group m-b-15">
                            <label>Poke Mesajı Girin</label>
                            <textarea name="pokemesaji" class="input-sm validate[required] form-control" placeholder="..."></textarea>
                        </div>
			<div class="form-group m-b-15">
			                       <select name="servergrubu" class="select" id="bank2">
                                <option value="">Pokenin Gönderileceği Sunucu Grubu</option>
								<?
								$x_sunucugruplari = $ts3->serverGroupList();
								foreach($x_sunucugruplari as $sunucugrubulistesi)
								{
									echo  "<option value='$sunucugrubulistesi' name='$sunucugrubulistesi'>".$sunucugrubulistesi ."</option>";
								}
								?>
                            </select>
							</div>

                        
                        <input class="btn btn-block btn-alt" type="submit" name="poke_all_users" value="Gonder">
                    </form>
                </div>
			<?}?>
			
			
			
			
			
			
			
			
			
			
			
			