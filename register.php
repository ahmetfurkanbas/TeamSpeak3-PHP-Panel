<?
session_start();
ob_start();
include("inc/sql_base.php");
include("inc/functions.php");
?>

<html>

<head>
	<? include("pages/head.php");?>
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body>

<?if($_SESSION["login"] != "OK"){?>

<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-b-160 p-t-50">
				<form method="POST" action="process.php" class="login100-form validate-form">
					<span class="login100-form-title p-b-43">
						Kayıt Sistemi
					</span>
					
					<div class="wrap-input100 rs1 validate-input">
						<input class="input100" type="text" name="adsoyad">
						<span class="label-input100">Ad ve Soyad</span>
					</div>

					<div class="wrap-input100 rs2 validate-input">
						<input class="input100" type="text" name="kadi">
						<span class="label-input100">Kullanıcı Adınız</span>
					</div>
					
					<div class="wrap-input100 rs2 validate-input">
						<input class="input100" type="email" name="email">
						<span class="label-input100">E-Mail</span>
					</div>
					
					<div class="wrap-input100 rs2 validate-input">
						<input class="input100" type="tel" name="telno">
						<span class="label-input100">Telefon Numaranız</span>
					</div>
					
					<div class="wrap-input100 rs2 validate-input">
						<input class="input100" type="password" name="parola">
						<span class="label-input100">Parola</span>
					</div>
					
					<div class="wrap-input100 rs2 validate-input">
						<input class="input100" type="password" name="parolatekrar">
						<span class="label-input100">Parola Tekrar</span>
					</div>
							
					<div class="container-login100-form-btn">
						<button name="kayitol" class="login100-form-btn">
							Kayıt Ol
						</button>
					</div>
					
					<div class="text-center w-full p-t-23">
						<a href="#" class="txt1" style="float:right;">
							Şifremi Unuttum
						</a>
						<a href="index.php" class="txt1" style="float:left;">
							Giriş Yap
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>

<? }else{ 
	header("Location:anasayfa.php");
 }?>
  
<script type="text/javascript" src="assets/scripts/main.js"></script>
</body>
</html>
