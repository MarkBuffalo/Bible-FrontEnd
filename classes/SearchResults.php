<?php
		require_once("GlobalVariables.php");
		require_once("DatabaseFunctions.php");


		if (isset($_GET['s']))
		{
			// I know what you're thinking. Follow the yellow brick road before assuming anything, though. :)
			echo checkSearchType($_GET['s']);
		}
?>