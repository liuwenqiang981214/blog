<?php 
$db_host="localhost";
$db_user="root";
$db_pass="root";
$db_name="php";
$charset="utf8";
$linx=mysqli_connect($db_host,$db_user,$db_pass,$db_name);

if (!$link= @mysqli_connect($db_host,$db_user,$db_pass)) {
	echo "<h2>连接mysql服务器失败</h2>";
	die();
}else{
	echo "yes";
}

if (!mysqli_select_db($linx,$db_name)) {
	echo "<h2>选择数据库{$db_name}失败</h2>";
	die();
}{
	echo "yes";
}


echo mysqli_select_db($linx,$db_name);
echo mysqli_set_charset($linx,$charset);
$result=mysqli_query($link,"SELECT * FROM photos");
if (empty($result)) {
	echo "失败";
}
?>