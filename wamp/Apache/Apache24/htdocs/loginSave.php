<?php 

require_once("./conn.php");

session_start();

if (isset($_POST['token'])&& $_POST['token']==$_SESSION['token']) {
	$username=$_POST['username'];
	$password=md5($_POST['password']);
	$verify  =$_POST['verify'];

	/*if (strtolower($verify)!=$_SESSION['captcha']) {
		echo "<h2>验证码不一致！</h2>";
		header("refresh:3;url=./login.php");
		die();
	}*/

	$sql="SELECT * FROM user WHERE username='$username' and password='$password'";
	$result=mysqli_query($link,$sql);
	echo $password;
	echo $result;
	/*$records=mysqli_num_rows($result);

	if (!$records) {
		echo "<h2>用户名或密码不正确</h2>";
		header("refresh:50;url=./login.php");
		die();
	}*/

	$_SESSION['username']=$username;

	/*header("location:./index.php");*/
}else{
	header("location:./login.php");
}
?>