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

<?
	// Oturum Kontrolü
		if($_SESSION['login']!= "OK"){
			alertmsg("Uyarı!","Bu sayfayı görüntüleyebilmek için giriş yapmış olmanız gerekmektedir.","index.php","warning");
			return;
		}


?>

<body>
    

		<? include("pages/footer.php"); ?>
	   
	   
		<? include("pages/header.php"); ?>

	   <div class="col-xl-4 col-lg-12" style="position:relative;left:650;right:auto;">
			<form action="process.php" method="POST">
			<div class="card card-chart" style="background-color:#E48430;">
                <div class="card-header card-header-success" style="background-color:#E48430;">
                  <div class="ct-chart" id="dailySalesChart">Parola Değiştir</div>
                </div>

                <div class="card-body">
					<input type="password" class="input-text" name="eskiparola" placeholder="Eski Şifre">
					<input type="password" class="input-text" name="yeniparola" placeholder="Yeni Şifre">
					<input type="password" class="input-text" name="yeniparolatekrar" placeholder="Yeni Şifre Tekrar">
					<input type="submit" name="paswddegis" value="Şifremi Değiştir" class="button buttonBlue">
									
                </div>

            </div>
			</form>

			</div>

		
<script type="text/javascript" src="assets/scripts/main.js"></script>
</body>
</html>
