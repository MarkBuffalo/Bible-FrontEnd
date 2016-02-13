<?php

	// Split the the string into an array based on regex capture groups.
	function getPregSplitArray($pattern, $str)
	{
		return preg_split($pattern, $str, -1, PREG_SPLIT_DELIM_CAPTURE);
	}

	// This is where we determine whether or not the query is valid before sending it to the database.
	function checkSearchType($search)
	{
		if (isset($search) && mb_strlen($search) < 250)
		{
			
			// Remove trailing spaces because they won't trigger our regex.
			$newSearch = rtrim($search);
			
			global $dqo;
			
			foreach ($dqo as $d)
			{
				// Our DatabaseQueryObject properties
				$query = $d->query;
				$parameters = $d->parameters;
				$parameterTypes = $d->parameterTypes;
				$regex = $d->regex;
				$queryType = $d->queryType;
				$lang = $d->lang;
				
				// Is it one of our valid queries, and *NOT* a keyword search?
				if ($queryType != 5 && preg_match($regex, $newSearch))
				{
					// We've got a match. Split the query into an array based on regex capture groups.
					$contents = getPregSplitArray($regex, $newSearch);
					

					// How big is our array?
					$conCount = count($contents);

					// This is where we'll put the temporary parameters once we've removed the empty ones.
					$tmpParameters = array();

					// Remove bad elements and insert into new array, $parameters.
					for ($i = 0; $i < $conCount; $i++)
					{
						// If it's not the first or last option (both of which are empty when using preg_split()), add it to the parameter list.
						if ($i != 0 && $i != ($conCount - 1))
						{
							//echo "Index: [" . $i . "] value: " . $contents[$i] . "<br/>"; Great. Chinese is correct.
							array_push($tmpParameters, $contents[$i]);
						}
					}

					// This query was for Song of Solomon. Combine tmpParameters[0], tmpParameters[1], and tmpParameters[2] to create a single book.
					if (strtolower($tmpParameters[0]) == "song")
					{
						// Combine the full book name.
						$bookName = $tmpParameters[0] . " " . $tmpParameters[1] . " " . $tmpParameters[2];

						array_push($parameters, $bookName);

						for ($j = 0; $j < count($tmpParameters); $j++)
						{
							// Make sure we skip the book name. We already combined that.
							if ($j != 0 && $j != 1 && $j != 2)
							{
								array_push($parameters, $tmpParameters[$j]);
							}
						}
					} // Found a number book. Example: 2 Peter. Combine tmpParameters[0] and tmpParameters[1].
					else if (is_numeric($tmpParameters[0]))
					{
						// Combine the full book name.
						$bookName = $tmpParameters[0] . " " . $tmpParameters[1];

						array_push($parameters, $bookName);

						for ($j = 0; $j < count($tmpParameters); $j++)
						{
							// Make sure we skip the book name. We already combined that.
							if ($j != 0 && $j != 1)
							{
								array_push($parameters, $tmpParameters[$j]);
							}
						}
					} // Book without multiple accompanying books. Example: Genesis.
					else if (is_string($tmpParameters[0]))
					{
						$parameters = $tmpParameters;
					}

					// Everything looks good. Let's start the parameterization process, and return the results to the visitor.

					$results = queryDatabase($query, $parameters, $parameterTypes, $queryType, $newSearch, $lang);


					// Found something
					if (strlen($results) > 10)
					{
						return $results;
					}
				}
				else if (preg_match($regex, $newSearch) && $queryType == 5)
				{
					$results = queryDatabase($query, array($newSearch), $parameterTypes, $queryType, $newSearch, $lang);
					if (strlen($results) > 10)
					{
						return $results;
					}
				}
			}
		}
		else
		{
			return "No results found.";
		}
		
		return "No results found.";
	}
	// This is so we can find the number of chapters in a book. Not currently used.
	function getChapterCount($book)
	{
		global $servername;
		global $databasename;
		global $username;
		global $password;
		global $chapterCountQuery;
		
		$db = new mysqli($servername, $username, $password, $databasename);
		$stmt = $db->prepare($chapterCountQuery);
		
		$stmt->bind_param("s", $book);
		$stmt->execute();

		$stmt->store_result();
		$stmt->bind_result($NumChapters);
		
		return $NumChapters;
	}
	
	function validateNonEnglishBookParameter($param, $lang, $length)
	{
		if (mb_strlen($param) > $length && $lang != "English")
		{
			if ($lang == "ChineseSimplified")
			{
				die("书的名字是太大");
			}
			
			else if ($lang == "ChineseTraditional")
			{
				die("書的名字是太大");
			}
		}
	}


	function queryDatabase($query, $parameters, $parameterType, $queryType, $searchQuery, $lang)
	{
		global $servername;
		global $databasename;
		global $username;
		global $password;

		$results = "";

		$db = new mysqli($servername, $username, $password, $databasename);
		
		$stmt;
		
		// So we can actually use UTF8 searches.
		$db->set_charset("utf8");
		
		// Our queries work for all languages due to the way they're set up. We just need to change the table name. Let's do that.
		if ($lang == "English")
		{			
			$stmt = $db->prepare($query);
		}
		else if ($lang == "ChineseSimplified") 
		{
			$stmt = $db->prepare(str_replace("`English`", "`ChineseSimplified`", $query));				
		}
		else if ($lang == "ChineseTraditional") 
		{
			$stmt = $db->prepare(str_replace("`English`", "`ChineseTraditional`", $query));								
		}
		else
		{
			die("Invalid Language specified.");
		}
		

		switch ($queryType)
		{
			case 0: // bookChapterVerse
			{
				$stmt->bind_param($parameterType, $parameters[0], $parameters[1], $parameters[($lang == "English") ? 2:3]); // sii
			} break;
			
			case 1: // bookChapterVerseFromVerseTo
			{
				// To can't be greater than From. Example: Genesis 2-1 is invalid. This does not allow you to search backwards.
				if ($parameters[2] > $parameters[3] && $lang == "English")
				{
					// Free up resources.
					$stmt->free_result();
					$stmt->close();
					return "VerseTo can't be greater than VerseFrom.";
				}
				
				// Kills the PHP script if the parameters are too long.
				validateNonEnglishBookParameter(parameters[0], $lang, 7);
				
				$stmt->bind_param($parameterType, $parameters[0], $parameters[1], $parameters[($lang == "English") ? 2:3], $parameters[($lang == "English") ? 3:5]); // siii
			} break;
			
			case 2: // bookChapterFromChapterTo
			{
				// To can't be greater than From. Example: Genesis 2-1 is invalid. This does not allow you to search backwards.
				if ($parameters[1] > $parameters[2]  && $lang == "English")
				{
					// Free up resources.
					$stmt->free_result();
					$stmt->close();
					return "ChapterTo can't be greater than ChapterFrom.";
				}
				// Kills the PHP script if the parameters are too long.
				validateNonEnglishBookParameter(parameters[0], $lang, 7);

				$stmt->bind_param($parameterType, $parameters[0], $parameters[1], $parameters[($lang == "English") ? 2:3]); // sii	
			} break;
			
			case 3: // bookChapter
			{					
				// Kills the PHP script if the parameters are too long.
				validateNonEnglishBookParameter(parameters[0], $lang, 7);

				$stmt->bind_param($parameterType, $parameters[0], $parameters[1]); // si
			} break;
			
			case 4: // Book
			{
				// Kills the PHP script if the parameters are too long.
				validateNonEnglishBookParameter(parameters[0], $lang, 7);

				$stmt->bind_param($parameterType, $parameters[0]); // s
			} break;
			case 5: // Non-book-based search. Allows searching words. 
			{
				// Kills the PHP script if the parameters are too long.
				validateNonEnglishBookParameter(parameters[0], $lang, 7);

				$fixedParameter = "%" . $parameters[($lang == "English") ? 0:1] . "%";
				$stmt->bind_param($parameterType, $fixedParameter); // s
			}break;
			
			default:
			{
				// Free up resources.
				$stmt->free_result();
				$stmt->close();

				die("Incorrect value entered");
			} break;
		}
		$stmt->execute();


		$stmt->store_result();
		$stmt->bind_result($BookName, $Chapter, $Verse, $Word);

		$numResults = 0;

		// Print results.
		
		$lastChapter = 0;
		$lastBook = "";
		
		
		// Set the appropriate result formatting so as not to confuse anyone.
		if ($lang == "English") 
		{ 
			$chapterWordNativeLanguage = "Chapter"; 
			$resultsWordNativeLanguage = "Results for";
		}
		else if ($lang == "ChineseSimplified") 
		{ 
			$chapterWordNativeLanguage = "章节";
			$resultsWordNativeLanguage = "搜索结果";
		}
		else if ($lang == "ChineseTraditional") 
		{ 
			$chapterWordNativeLanguage = "章節";
			$resultsWordNativeLanguage = "搜索結果";
		}
		
		
		
		if ($queryType != 5)
		{
			$results .= "<h1 style='text-align: center;'>" . htmlspecialchars($searchQuery) . "</h1>";
			$results .= "<p><br/></p>";
			
			while ($stmt->fetch())
			{
				// This will always be different if the last chapter was different. This allows us to separate chapters with the below HTML.
				if ($Chapter != $lastChapter)
				{
					$results .= "<p><br/></p>";
					$results .= "<h2>". $chapterWordNativeLanguage . " " . $Chapter . "</h2>";
					$results .= "<hr/><p>";
				}
				$results .= "<strong>" . $Chapter . "</strong><em>:</em><strong>" . $Verse . "</strong> <em>-</em> " . $Word . " <br/><br/>";
				$numResults++;
				$lastChapter = $Chapter;
			}
			$results .= "</p>";
		}
		
		// Query contains user-defined search. Must sanitize output. If attacker somehow gets past validation, this is the last line of defense.
		// While our database will not find anything that could be used for XSS, and therefore not return anything, this would be sloppy coding if I didn't account for it.
		else
		{
			while ($stmt->fetch())
			{
				// To separate results by book name.
				if ($BookName != $lastBook)
				{
					$results .= "<p><br/></p>";
					$results .= "<h2>". $resultsWordNativeLanguage . "  ". $BookName . "</h2>";
					$results .= "<hr/>";						
				}
				$results .= "<em>" . $BookName . "</em> <strong>" . $Chapter . "</strong><em>:</em><strong>" . $Verse . "</strong> <em>-</em> " . str_replace($parameters[0], "<strong>".htmlentities($parameters[0])."</strong>", $Word) . " <br/><br/>";
				$numResults++;
				$lastBook = $BookName;
			}
		}


		// Free up resources.
		$stmt->free_result();
		$stmt->close();

		if ($numResults == 0)
		{
			return $numResults;
		}

		// Send the data back to checkSearch()
		return $results;
	}
?>