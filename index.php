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
    

       <? include("pages/login.php"); ?>

<script type="text/javascript" src="assets/scripts/main.js"></script>
</body>
</html>
