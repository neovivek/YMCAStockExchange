<?php
	session_start();
	if(isset($_SESSION['userid']))
	{
		session_unset();
		session_destroy();
	}
?>