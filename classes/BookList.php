<?php


	require_once("GlobalVariables.php");
	
	$bookQuery = "SELECT DISTINCT Book from `English`";
	
	
	if (isset($_GET['lang']) && is_numeric($_GET['lang']))
	{
		echo getBookList($_GET['lang']);
	}
	
	function checkBookList($num)
	{
		if ($num == 0)
		{
			return "<h1 style='text-align: center;'>Bible Book List</h1>";
		}
		else if ($num == 1)
		{
			return "<h1 style='text-align: center;'>图书列表</h1>";
		}
		else if ($num == 2)
		{
			return "<h1 style='text-align: center;'>圖書列表</h1>";
		}
		else 
		{
			return "<h1 style='text-align: center;'>Invalid Book List</h1>";
		}
	}
	
	function getBookList($lang)
	{
		global $servername;
		global $databasename;
		global $username;
		global $password;
		global $bookQuery;
		
		$db = new mysqli($servername, $username, $password, $databasename);
		$db->set_charset("utf8");
		
		$results = "";
		$stmt;
		
		
		if ($lang == 0) { $result = $db->query($bookQuery); }
		else if ($lang == 1) { $result = $db->query(str_replace("`English`", "`ChineseSimplified`", $bookQuery)); }
		else if ($lang == 2) { $result = $db->query(str_replace("`English`", "`ChineseTraditional`", $bookQuery)); }
		else 
		{
			// User entered an invalid language. That's a no go.
			die("Invalid Language specified.");
		}
		

		$numResults = 0;
	
		
		$results .= "<div class=\"container\">";
		$results .= checkBookList($lang) . "<p><br/></p>";
		
		$results .= "<div class=\"list-group\" style=\"float: left; width: 33%; margin: 0 auto; text-align: center;\">";
		while ($row = $result->fetch_assoc())
		{
			if ($numResults % 22 == 0 && $numResults != 0)
			{
				$results .= "</div>\r\n";
				$results .= "<div class=\"list-group\" style=\"float: left; width: 33%; margin: 0 auto; margin-left: 4px; text-align: center;\">";
				$results .= "\t<a href=\"#\" class=\"list-group-item\">". $row["Book"] . "</a>\r\n";
			}
			else
			{
				$results .= "\t<a href=\"#\" class=\"list-group-item\">". $row["Book"] . "</a>\r\n";
			}
			$numResults++;
		}
		$results .= "</div></div>\r\n";
		
		$result->free_result();
		$db->close();
		
		if ($numResults == 0)
		{
			return $numResults;
		}
		return $results;
		
	}

?>