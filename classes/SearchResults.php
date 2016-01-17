<?php
		require_once("GlobalVariables.php");
		require_once("DatabaseFunctions.php");


		if (isset($_GET['s']))
		{
			echo checkSearchType($_GET['s']);
		}
?>