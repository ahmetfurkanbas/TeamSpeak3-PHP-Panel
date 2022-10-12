<div class="app-main">
                <div class="app-sidebar sidebar-shadow bg-primary sidebar-text-light">
                    <div class="app-header__logo">
                        <div>TeamSpeak Dünyasi</div>
                        <div class="header__pane ml-auto">
                            <div>
                                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="app-header__mobile-menu">
                        <div>
                            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="app-header__menu">
                        <span>
                            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
                    </div>    
					<div class="scrollbar-sidebar">
                        <div class="app-sidebar__inner">
                            <ul class="vertical-nav-menu">
                                <li class="app-sidebar__heading"></li>
                                <li>
                                    <a href="anasayfa.php" class="mm-active">
                                        <i class="metismenu-icon pe-7s-rocket"></i>
                                        Ana Sayfa
                                    </a>
                                </li>
                                <li class="app-sidebar__heading">Web Panel</li>
								<? if($sunucucontrol == 1){?>
                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-diamond"></i>
                                        TeamSpeak3 Sunucum
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="sunucuayarlari.php">
                                                <i class="metismenu-icon"></i>
                                                Sunucu Ayarları
                                            </a>
                                        </li>
                                        <li>
                                            <a href="yetkisistem.php">
                                                <i class="metismenu-icon">
                                                </i>Yetki İşlemleri
                                            </a>
                                        </li>
										<li>
                                            <a href="kullaniciislem.php">
                                                <i class="metismenu-icon">
                                                </i>Kullanıcı İşlemleri
                                            </a>
                                        </li>
										<li>
                                            <a href="toplupoke.php">
                                                <i class="metismenu-icon">
                                                </i>Toplu Poke
                                            </a>
                                        </li>
										<li>
                                            <a href="banlist.php">
                                                <i class="metismenu-icon">
                                                </i>Ban Listesi
                                            </a>
                                        </li>
                                        <li>
                                            <a href="yedekalma.php">
                                                <i class="metismenu-icon">
                                                </i>Yedek Alma/Atma
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="metismenu-icon">
                                                </i>Yedek Atma
                                            </a>
                                        </li>
                                    </ul>
                                </li>
								<? }else if($sunucucontrol == 0){ ?>
								<li>
                                    <a href="kirala.php">
                                        <i class="metismenu-icon pe-7s-diamond"></i>
                                        TeamSpeak3 Sunucu Kirala
                                    </a>
                                </li>
								<? } ?>
                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-car"></i>
                                        Klana Özel Banner
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="components-tabs.html">
                                                <i class="metismenu-icon">
                                                </i>JailBreak Yedeği
                                            </a>
                                        </li>
                                        <li>
                                            <a href="components-accordions.html">
                                                <i class="metismenu-icon">
                                                </i>Pro Public Yedeği
                                            </a>
                                        </li>
                                        <li>
                                            <a href="components-notifications.html">
                                                <i class="metismenu-icon">
                                                </i>BaseBuilder Yedeği
                                            </a>
                                        </li>
                                        <li>
                                            <a href="components-modals.html">
                                                <i class="metismenu-icon">
                                                </i>Furien Yedeği
                                            </a>
                                        </li>
                                        <li>
                                            <a href="components-progress-bar.html">
                                                <i class="metismenu-icon">
                                                </i>CsGo Mod Yedeği
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="app-sidebar__heading">SinusBot</li>
                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-display2"></i>
                                        SinusBot(Yakında)
                                    </a>
                                </li>
								<li class="app-sidebar__heading">Destek Talebi</li>
                                <li>
                                    <a href="support.php">
                                        <i class="metismenu-icon pe-7s-display2"></i>
                                        Destek Talebi
                                    </a>
                                </li>
								
								<?/*
                                <li class="app-sidebar__heading">Aktif Adminler</li>
								<?
								$admincontrol = $sql->query("SELECT * FROM users Where aktif_mi = 1 AND admin_mi = 1", PDO::FETCH_ASSOC);
													if ($admincontrol->rowCount()){
														foreach($admincontrol as $adminyazdir){
								?>
                                <li>
                                        <font color="#E89820">
                                        <?echo $adminyazdir['adsoyad'];?>
										</font>
                                </li>
								
													<? } }?>
													
													<?*/?>
								
								<? if($admin_mi == '1'){ ?>
                                <li class="app-sidebar__heading">Admin Paneli</li>
								<li>
                                    <a href="destektalepleri.php">
                                        <i class="metismenu-icon pe-7s-graph2">
                                        </i>
                                        Destek Talepleri
                                    </a>
                                </li>
								<li>
                                    <a href="sunucular.php">
                                        <i class="metismenu-icon pe-7s-graph2">
                                        </i>
                                        TeamSpeak3 Sunucuları
                                    </a>
                                </li>
								<li>
                                    <a href="bayiekle.php">
                                        <i class="metismenu-icon pe-7s-graph2">
                                        </i>
                                        Bayi Ekle
                                    </a>
                                </li>
								<? } ?>
                            </ul>
                        </div>
                    </div>
                </div> 
