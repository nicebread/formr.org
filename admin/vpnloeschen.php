<?php
require ('admin_header.php');
# should maybe put the date in the vpndata table as well
if(isset($_GET['wen'])) {
require ('includes/settings.php');


$db_host = $DBhost;
$db_user = $DBuser;
$db_pwd = $DBpass;
$database = $DBName;

if (!mysql_connect($db_host, $db_user, $db_pwd))
    die("Can't connect to database");

if (!mysql_select_db($database))
    die("Can't select database");
mysql_query("set names 'utf8';");

if(isset($_GET['bestaetigt'])) {
$success = 0;
$mail = mysql_query("DELETE FROM vpnueberblick
	WHERE email = '{$_GET['wen']}' AND lab_id IS NULL")  or die(mysql_error());

	if(mysql_affected_rows()>0) {
		$success = mysql_affected_rows();
		$joomla = mysql_query("UPDATE jos_comprofiler 
			LEFT JOIN jos_users 
			 ON jos_comprofiler.user_id=jos_users.id
			SET jos_comprofiler.approved = 2 WHERE jos_users.email = '{$_GET['wen']}'") or die(mysql_error());
	}
	header("Location: http://vomstudiumindenberuf.de/tagebuch/admin/kommandozentrale.php?geloescht=".$success."&email=".$_GET['wen']);
	exit;
}
else {
	?>
	<form action="http://vomstudiumindenberuf.de/tagebuch/admin/vpnloeschen.php" method="get"><input type="text" name="wen" value="<?=$_GET['wen']?>" /><br>
		<label><input type="checkbox" name="bestaetigt" /> wirklich aus der VPNDATENTABELLE löschen</label>
		<input type="submit" value="Loeschen!" />
	<?php
}

}
?>