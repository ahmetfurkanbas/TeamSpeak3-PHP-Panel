<?if($_SESSION["login"] != "OK"){?>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-b-160 p-t-50">
				<form method="POST" action="process.php" class="login100-form validate-form">
					<span class="login100-form-title p-b-43">
						Kullanıcı Girişi
					</span>
					
					<div class="wrap-input100 rs1 validate-input">
						<input class="input100" type="text" name="email">
						<span class="label-input100">Email</span>
					</div>

					<div class="wrap-input100 rs2 validate-input">
						<input class="input100" type="password" name="password">
						<span class="label-input100">Parola</span>
					</div>

					<div class="container-login100-form-btn">
						<button name="login" class="login100-form-btn">
							Giriş Yap
						</button>
					</div>
					
					<div class="text-center w-full p-t-23">
						<a href="#" class="txt1" style="float:right;">
							Şifremi Unuttum
						</a>
						<a href="register.php" class="txt1" style="float:left;">
							Kayıt Ol
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
  
  
<? }else{ ?>

<?
					
						$time = $_SERVER['REQUEST_TIME'];

							/**
							* for a 30 minute timeout, specified in seconds
							*/
							$timeout_duration = 600;

							/**
							* Here we look for the user's LAST_ACTIVITY timestamp. If
							* it's set and indicates our $timeout_duration has passed,
							* blow away any previous $_SESSION data and start a new one.
							*/
							if (isset($_SESSION['LAST_ACTIVITY']) && 
							   ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
								   
								$update_active = $sql->prepare("UPDATE users SET aktif_mi=? WHERE email=?");
								$update_active->execute(array("0",$email));
								   
								   echo "					<script>    
											Swal.fire({
											title: 'Uyarı!',
											text: 'Oturumunuz zaman aşımına uğradı otomatik olarak çıkış yapılacak.',
											allowOutsideClick: false,
											allowEscapeKey: false,											
											type:'warning'
												}).then((result) => {
												  if (result.value) {
													window.location.href = 'index.php';
												  }
												})
													  
										</script>";
									
								session_unset();
								session_destroy();
								session_start();
								
							}

							/**
							* Finally, update LAST_ACTIVITY so that our timeout
							* is based on it and not the user's login time.
							*/
							$_SESSION['LAST_ACTIVITY'] = $time;
					
					?>
  
			
				<?
					header("Location:anasayfa.php");
		}
				?>