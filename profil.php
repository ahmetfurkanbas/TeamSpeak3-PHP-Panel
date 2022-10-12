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
    

		<? include("pages/footer.php"); ?>
	   
	   
		<? include("pages/header.php"); ?>

	   <div class="col-xl-4 col-lg-12" style="position:relative;left:650;right:auto;">

			<div class="card card-chart" style="background-color:#E48430;">
                <div class="card-header card-header-success" style="background-color:#E48430;">
                  <div class="ct-chart" id="dailySalesChart">Bilgilerim</div>
                </div>

                <div class="card-body">
               <input type="text" class="input-text" value="<?echo $adsoyad;?>" disabled />
					<input type="text" class="input-text" value="<?echo $email;?>" disabled />
					<input type="text" class="input-text" value="<?echo $kadi;?>" disabled />
               <input type="text" class="input-text" value="<?echo $telno;?>" disabled />
									
                </div>
				
            </div>

			</div>

		
<script type="text/javascript" src="assets/scripts/main.js"></script>
</body>
</html>
