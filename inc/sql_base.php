<?

try {
		$sql = new PDO("mysql:host=localhost;dbname=xxx;charset=utf8", "xxx", "xxx");
		$sql->exec("set names utf8");
		
} catch ( PDOException $e ){
     print $e->getMessage();
}

	$anasunucu = ("xxx.com");
	$scriptsunucu = ("xxx.com/site/projetest/script.ish");
	$sinusbot_file = ("ish_sinusbot");
	$scusercontrol = ("ish");

	$scriptisim = ('TeamSpeak Dünyası');

	date_default_timezone_set("Europe/Istanbul");
	$tarih = date('d.m.Y');
	$saat =  date("H:i:s");
		
	error_reporting(1);
	ini_set("display_errors",1);
	
$warning_head = '<div class="m-alert m-alert--outline m-alert--outline-2x alert alert-warning alert-dismissible" role="alert"><i class="la la-warning"></i>';
$warning_head2 = '<div class="alert alert-warning alert-dismissible" role="alert"><i class="la la-warning"></i>';

$danger_head = '<div class="m-alert m-alert--outline m-alert--outline-2x alert alert-danger alert-dismissible" role="alert"><i class="la label-warning"></i>';
$danger_head2 = '<div class="alert alert-danger alert-dismissible" role="alert"><i class="la label-warning"></i>';

$success_head = '<div class="m-alert m-alert--outline m-alert--outline-2x alert alert-success alert-dismissible" role="alert">';
$success_head2 = '<div class="alert alert-success alert-dismissible" role="alert">';

$info_head = '<div class="m-alert m-alert--outline m-alert--outline-2x alert alert-info alert-dismissible" role="alert"><i class="la label-info"></i>';
$info_head2 = '<div class="alert alert-info alert-dismissible" role="alert"><i class="la label-info"></i>';
	
?>
