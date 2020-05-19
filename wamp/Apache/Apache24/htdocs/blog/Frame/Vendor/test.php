<?php 
require_once(Captcha.class.php);

 $c=new Captcha();
 $a=$c->getCode();
 echo "$a";
?>