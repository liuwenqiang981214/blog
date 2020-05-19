<?php
	echo "hello world!";
	echo "<br>";
	if (mysqli_connect('localhost','root','root')) {
		echo "success";
	}
	echo "<br>";

	$name="hello";
	echo substr($name, 1);
	echo "<br>";

	echo md5("123");

	function show_all_files($dir){

		$handle=opendir($dir);
		echo "<ul>";

		while ($line=readdir($handle)) {
			if ($line=='.'||$line=='..') {
				continue;
			}
			echo "<li>$line</li>";

			if (is_dir($dir."/".$line)) {
				show_all_files($dir."/".$line);
			}
		}
		echo "</ul>";

		closedir($handle);
	}
	/*show_all_files("./");*/

	function del_all_files($dir){

		$handle=opendir($dir);

		while ($line=readdir($handle)) {
			if ($line=='.'||$line=='..') {
				continue;
			}

			if (is_dir($dir."/".$line)) {
				del_all_files($dir."/".$line);
			}else{
				unlink($dir."/".$line);
			}
		}

		closedir($handle);
		rmdir($dir);
	}
	/*del_all_files("./a");*/

	phpinfo();

?>